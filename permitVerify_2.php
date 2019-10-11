<?php
// Code fixed by Eric Ghildyal, but really fixed/totally rewritten by mmm 7-31-15
//NO LONGER TODO: After "acccept" is clicked, the form does not refresh correctly
session_start();
include 'functions_2.php'; //added _2 to update file
password_protect();
admin_only();
include 'includeInc_2.php';
dohtml_header("Parking Permit Verification");
$db = get_database_connection();
?>
<script type='text/javascript'>
        function refresh() //This code may or may not work...
        {
            var formObject = document.forms['theForm'];
            formObject.action="permitVerify_2.php";
            formObject.submit();
        } 
       /* function refresh()
        {
            var formObject = document.forms['theForm'];
            formObject.submit();
        }
        function send()
        {
            var formObject = document.forms['theForm'];
            formObject.submit();
        }*/
</script>
<?php
      
//Set up heading: Date, links to HGP Home Page, EHGP, and Logout
//$date = date('Y-m-d');
//echo "<table class='centered'><tr><td>";
//echo "<h2>" . date('l', strtotime($date)) . "<br />" . $date;
//echo "</h2></td></tr>";
//homeLogout();



//Set up heading: Date, links to HGP Home Page, EHGP, and Logout
        $date = date('Y-m-d');
        echo "<table class='centered'><tr><td>";
        echo "<h2>" . date('l', strtotime($date)) . "<br />" . $date . "</h2></td></tr>";
        homeLogout();
	//echo "<td>";
//echo "<br/>"; //too much space after buttons?


//Gets all unverified results from database
$verify = 0; // 0 is unverified
$pcheck = $db->prepare("SELECT * FROM parkingpermit WHERE verify=:verify");
$pcheck->bindvalue(":verify", $verify);
$pcheck->execute();
$result = $pcheck->fetchAll();

//Checks if 'accept' button was pressed ==SUBMIT ->Verify
if (isset($_POST['submit'])){
        //Checks if the permit number was updated
        if (isset($_POST["pnumber"]) && ($_POST["pnumber"])!=NULL){ //isset() added to prevent "Notice: Undefined index"
            $permitnumber = ($_POST["pnumber"]);
        }else{
            $permitnumber = $row['permitnumber'];
        }
        // Updates verify and permitnumber at the same time
        $id = $_POST['permitid'];
        $sql = "UPDATE parkingpermit SET verify=:verify, permitnumber=:permitnumber WHERE id=:id";
        $pupdate = $db->prepare($sql);
        $pupdate->bindValue(":id", $id);
        $pupdate->bindValue(":permitnumber", $permitnumber);
        $pupdate->bindValue(":verify", 1); //update verify to be 1 instead of 0
        $pupdate->execute();
}//isset $_POST submit

echo "</table><table id='permits' align=center border=1><tr><th>First Name</th><th>Last Name</th><th>Make</th><th>Model</th><th>Year</th><th>Color</th><th>Licenseplate</th><th>Permit Number</th></tr>";
//Gets all unverified results from database
$verify = 0; // 0 is unverified
$pcheck = $db->prepare("SELECT * FROM parkingpermit WHERE verify=:verify");
$pcheck->bindvalue(":verify", $verify);
$pcheck->execute();
$result = $pcheck->fetchAll();

$i = 0;
foreach ($result as $row){
	$sid = $row['studentid'];

    $statement0 = $db->prepare("SELECT * FROM student WHERE id=:id");
    $statement0->bindValue(":id", $sid);
    $statement0->execute();
    $student = $statement0->fetch();

           		echo "<tr><td>" . $student['firstname'] . "</td>"; 
                echo "<td>" . $student['lastname'] . "</td>"; 
                echo "<td>" . $row['make'] . "</td>"; 
                echo "<td>" . $row['model'] . "</td>"; 
                echo "<td>" . $row['year'] . "</td>"; 
                echo "<td>" . $row['color'] . "</td>"; 
                echo "<td>" . $row['licenseplate'] . "</td>"; 
             echo "<td><form action=permitVerify_2.php method='post'>";
				echo     "<input type='text' name='pnumber' value='" . $row['permitnumber'] . "' /></td>"; 
				echo     "<input type='hidden' name='permitid' value='" .$row['id']. "' />";
				echo     "<td> <input type='submit' name='submit' value='Verify'/></td></form>";
  
			 /*  	 //</form>*/
	echo "<br /></tr>";
	$i++;
}//foreach result as row
echo "</table>";

  dohtml_footer(true);
?>


<?php

//echo '<form name="theForm" method="post" action="permitVerify_2.php">';
//echo '<form name="theForm" method="post" action="refresh()">'; NO

//echo "<br/>";
//echo "<br/><td>";
// echo '<form name="theForm" method="post" action="permitVerify_2.php">';

    //$teacher = false;
    //checks to see if it is a teacher
    /*if (is_teacher_id($sid)){
         $statement0 = $db->prepare("SELECT * FROM teacher WHERE id=:id");
         $statement0->bindValue(":id", $sid);
         $statement0->execute();
         $teacher = true; */

    /* <tr>
	    <td> <?php if (!$teacher){
        echo $student['firstname'];
    }else{
        echo 'Teacher'; //displays the first name as teacher if not a student
    }
	echo '</td><td>';
    if (!$teacher){
        echo $student['lastname'];
    }else{
        echo $student['name']; //displays teacher name if teacher
    }?></td>
    */
              
//example stolen from scheduleRoom_2 by Mike Jacobs '01, Director of Technology 7-31-15
// echo "<form action=scheduleRoom_2.php method='post'><input type=text size=3 name=num>
//<input type=hidden name=room value=" . $rooms[$i] . "><input type=hidden name=date value=" . $date . ">
//<input type='submit' name='signout' value='Sign Out'></td></form>";
//used to be start of theForm because perhaps each one should be its own form???????????????????????????????????????

         // echo '<input type="hidden" onClick="history.go(0)" value=""> <input type="submit" name="submit" value="Submit Changes"/>';
		 // echo '</form>';//form start removed
        //$_POST['submit'] = NULL;

        /*foreach ($result as $row){
            $id = $row['id'];

            //checks to see if the permitnumber was updated, if not use the old number
            if (($_POST["pnumber" . $i .""])!=NULL){
                $permitnumber = ($_POST["pnumber" . $i . ""]);
            }else{
                $permitnumber = $row['permitnumber'];
            }

            $sql = "UPDATE parkingpermit SET permitnumber=:permitnumber WHERE id=:id";
            $pupdate = $db->prepare($sql);
            $pupdate->bindValue(":permitnumber", $permitnumber);
            $pupdate->bindValue(":id", $id);
            $pupdate->execute();


            //checks to see if it was verified, if not make it unverified (keep it the same)
            if (($_POST["pverified" . $i . ""])!=NULL){
                //$verified = ($_POST["pverified" . $i . ""]);
                $verified = 1;
            }else{
                $verified = 0;
            }

            $sql2 = "UPDATE parkingpermit SET verify=:verified WHERE id=:id";
            $pupdate = $db->prepare($sql2);
            $pupdate->bindValue(":verified", $verified);
            $pupdate->bindValue(":id", $id);
            $pupdate->execute();

            $i++;
        }*/
  //$db=null;
?>