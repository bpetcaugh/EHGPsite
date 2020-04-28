<?php
session_start();
include'functions_2.php';
password_protect();
include 'includeInc_2.php';
dohtml_header("Request an NHS Tutor");

$db = get_database_connection();
?>
<script type='text/javascript'>

    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
        formObject.action = "NHSTutorSubmit_2.php";
    }

    //Confirms that all fields on form are filled out before submitting; alerts user if false
    function validateForm()
    {
        var email = document.forms["theForm"]["email"].value;
		var class1 = document.forms["theForm"]["class1"].value;
		var desc = document.forms["theForm"]["desc"].value;
		var period = document.forms["theForm"]["period"].value;
        

        var s = "";

        //Where there is a value missing, s adds onto itself that box's error message

        if (class1 == null || class1 == "0")
        {
            s = s + "Class must be filled out.\n";
        }
		if (desc == null || desc == "")
        {
            s = s + "Description must be filled out.\n";
        }
		if (email == null || email == "")
        {
            s = s + "Email must be filled out.\n";
        }
		if (period == null || period == "")
        {
            s = s + "You must select a period.\n";
        }
        //If s is still blank, all boxes have been filled, and the form is submitted
        //If not, the value of s is printed in the alert box, and the form is not submitted
        if (s == "")
        {
            return true;
        } else
        {
            alert(s);
            return false;
        }
        return false;
    }

    function send()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>

<table class='centered'>

    <form id='theForm' name='theForm' onsubmit='return validateForm()' method='post' action='NHSTutorSubmit_2.php'>
        <!--If at least one field is blank, the form won't submit-->
        <?php

        //echo "<br/>";
       
        echo "<tr><td>";
        echo "Your Student ID is " . $_SESSION['id'] . "<br /><br /><input type=hidden name=student value=" . $_SESSION['id'] . ">";
        echo "</td></tr><tr><td>";
        echo "<table class='centered'><tr><td>";
        echo "What class do you need help with?";
		
		$courses = array();
		$myfile = fopen("directory/cours.txt", "r") or die("Unable to open file!");
		$count=0;
		while(!feof($myfile)) {
			$pieces = array_pad(explode("	", fgets($myfile)),8,"	");
			if ($_SESSION['id'] == $pieces[0]){
				$count++;
				$courses = array_pad($courses, $count, $pieces);	
			}
		}
		echo "<select name=class1>";
		echo "<option value=0>Select a Class</option>";
		foreach($courses as $class){
			if ($class[1] != "Open Study"){
				echo "<option value='" . $class[1] . " " . str_replace("'", "", $class[3]) . ";" . substr($class[7],0,strlen($class[7])-1) . "'>" . $class[1] . "</option>";
			}
		}
		echo "</select>";		
		
		echo "</td></tr>";
		echo "<tr><td>Describe what you need help with:</td></tr><tr><td><textarea rows=4 cols=50 name=desc></textarea></td></tr>";
        echo "<tr><td>Enter your email: <input type='email' name='email'></td></tr>";
		echo "<tr><td><br>Please select which period and tutor you would like to meet with:<br></td></tr>";
		
		//figure out semester
		if (date("m") == "08" || date("m") == "09" || date("m") == "10" || date("m") == "11" || date("m") == "12"){
			$term=1;
		}
		else
			$term=2;
		$allyear = 0;
		$date = date("Y-m-d");
        $sql = "SELECT * FROM calendar WHERE date>=:date ORDER BY date ASC";
        $query = $db->prepare($sql);
        $query->bindValue(":date", $date);
        $query->execute();
		echo "<tr><td><table class='centered' border=1><tr>";
		for ($three=0; $three<3; $three++){
			echo "<td>";
			$row = $query->fetch();
			echo date("l", mktime(0,0,0,substr($row['date'],5,2),substr($row['date'],8,2),substr($row['date'],0,4))). " (";
			echo $row['date'] . ")" . "<br>";
			echo $row['letter'] . " Day<br>";
			//get only open study for this letter day
			unset($studyperiods);
			$j=0;
			for($i=0; $i < sizeof($courses); $i++){
				if ($courses[$i][1] == "Open Study" && strpos($courses[$i][5], $row['letter']) !== false && substr($courses[$i][6],3,1) == $term){
					$studyperiods[$j] = $courses[$i];
					$j++;
				}
			}
			//sort by period
			for($i=0; $i < sizeof($studyperiods)-1; $i++){
				for($j=$i+1; $j < sizeof($studyperiods); $j++){
					if (intval(substr($studyperiods[$i][5],0,strlen($studyperiods[$i][5])-3)) > intval(substr($studyperiods[$j][5],0,strlen($studyperiods[$j][5])-3))){
						$temp = $studyperiods[$i];
						$studyperiods[$i] = $studyperiods[$j];
						$studyperiods[$j] = $temp;
					}
				}
			}		
			//match open NHS tutors
			foreach($studyperiods as $class){
				if(substr($class[5],0,strlen($class[5])-3) != "7" && substr($class[5],0,strlen($class[5])-3) != "8"){
					if(substr($class[5],0,strlen($class[5])-3) == "6"){
						echo "<input type=radio name=period value='" . $row['letter'] . substr($class[5],0,strlen($class[5])-3) . "'>Period 6/7 ";
					}
					else{
						echo "<input type=radio name=period value='" . $row['letter'] . substr($class[5],0,strlen($class[5])-3) . "'>Period " . substr($class[5],0,strlen($class[5])-3) . " ";
					}
					$sql = "SELECT * FROM nhstutors WHERE freeperiods like '%" . $class[5] . "%' ORDER BY RAND()";
					$query2 = $db->prepare($sql);
					$query2->execute();
					if($row2 = $query2->fetch()){
						echo "<select name=" . $row['letter'] . substr($class[5],0,strlen($class[5])-3) . "><option value='" . $row2['name'] . "'>" . $row2['name'] . "</option>";
						while($row2 = $query2->fetch()){
							echo "<option value='" . $row2['name'] . "'>" . $row2['name'] . "</option>";
						}
						echo "</select><br>";
					}
					else
						echo "NHS tutor not available.<br>";
				}						
			}	
			echo "</td>";
		}		
		echo "</tr></table>";
		echo "<tr><td>* - Spanish Tutors<br>** - French Tutors<br>*** - Latin Tutors</td></tr>";
		
		echo "</table>";
        $db = null;
        ?>
		<br>
        <input type='submit' name='submit' value='Submit' onclick='send()'/>
        <input type='button' name='cancel' value='Cancel' onclick='self.location = "login_2.php"'/><br/><br/><br/><br/>
        </td></tr>;
    </form>
<?php 
homeLogout();
echo "</table>";

dohtml_footer(true);
?>