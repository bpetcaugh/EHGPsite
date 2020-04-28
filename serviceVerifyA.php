<?PHP
include 'functions.php';
serv_admin_only();
password_protect();
$db = get_database_connection();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $tchdb1 = $db->prepare("SELECT * FROM teacher WHERE username=:username AND password=:password");
    $tchdb1->bindValue(":username", $username);
    $tchdb1->bindValue(":password", $password);
    $tchdb1->execute();
    $tchdbrow = $tchdb1->fetch();
    
    if ($_SESSION['username'] == $tchdbrow['username'] && $_SESSION['password'] == $tchdbrow['password']) {
         $teacherid = $tchdbrow['id'];
	//database access working check     echo $username,$teacherid;	
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css.css" />
    <link rel ="stylesheet" type ="text/css" href ="table.css" />
    <script type='text/javascript'>
        function refresh()
        {
            var formObject = document.forms['theForm'];
            formObject.action="serviceVerifyA.php";
            formObject.submit();
        }
    </script>
    <title>Service Verification Form</title>
</head>
<body bgcolor=#CCCCCC>
    <h1 align="center">Service Verification Form</h1>
    <br>
<?php 				   //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
    $date = date('Y-m-d');
    echo "<h2 align=center>" . date('l', strtotime($date)) . "<br>" . $date . "</h2>";
    echo "<center><a href=http://www.holyghostprep.org>Holy Ghost Prep Home Page</a></center>";
    echo "<center>&nbsp&nbsp<a href=index.php>EHGP Home</a></center>";
    echo "<center>&nbsp&nbsp<a href=logout.php>Logout</a></center><br><br>";
    echo " ";
?>
    <br>
    <table align=center><td>
        <form name='theForm' method='post' action='serviceVerifyA.php'>
<?php 
            if ($_POST["submit"]) {
		echo "Yo just after submit";
                $_POST["submit"] = NULL;
		$i = 0;
		$verified = 0;
                $agency = $_POST['agid'];
		$sql2 = "SELECT * FROM service WHERE verified=:verified AND agency=:agency ORDER by student";
		$servdb1 = $db->prepare($sql2);
		$servdb1->bindValue(":verified",$verified);
                $servdb1->bindValue(":agency",$agency);
                $servdb1->execute();
		while ($servdbrow1 = $servdb1->fetch()){ //$row = mysql_fetch_array($result)) {
			echo "Yo just after submit loop";
                        $i++;
			$servid = $servdbrow1['id'];
			if (	((
				(
				($_POST["role" . $i . ""])  
				|| ($_POST["verifiedValue" . $i . ""])	) 
				|| ($_POST["hours" . $i . ""])		) 
				|| ($_POST["notes" . $i . ""])		) ) {
					//new data
					if ($_POST["hours" . $i .""]!=NULL) $servhrsi = ($_POST["hours" . $i .""]); else $servhrsi = $servdbrow1["servicehours"];
					if ($_POST["role" . $i . ""]!=NULL) $rolei=$_POST["role" . $i . ""]; else $rolei = $servdbrow1["role"];
					if ($_POST["notes" . $i . ""]!=NULL) $notesi=$_POST["notes" . $i . ""]; else $notesi = $servdbrow1["notes"];
					if ($_POST["verifiedValue" . $i . ""]!=NULL) $verifiedi = ($_POST["verifiedValue" . $i .""]); else $verifiedi = $servdbrow1["verified"];
					//echo $servid . "service ID ";
					//$agencyi = (${$agid . $i});
					//query

					$sql3 = "UPDATE service SET servicehours=:servhrsi WHERE id=:servid";
					$servdb2 = $db->prepare($sql3);
					$servdb2->bindValue(":servhrsi", $servhrsi);
					$servdb2->bindValue(":servid", $servid);
					$servdb2->execute();
					
					$sql3 = "UPDATE service SET notes=:notesi WHERE id=:servid";
					$servdb2 = $db->prepare($sql3);
					$servdb2->bindValue(":notesi", $notesi);
					$servdb2->bindValue(":servid", $servid);
					$servdb2->execute();

					//temp check of agencyi
					//$agencyi=50;
					$sql3 = "UPDATE service SET role=:rolei WHERE id=:servid";
					$servdb2 = $db->prepare($sql3);
					$servdb2->bindValue(":rolei", $rolei);
					$servdb2->bindValue(":servid", $servid);
					$servdb2->execute();
					
					$sql3 = "UPDATE service SET verified=:verifiedi WHERE id=:servid";
					$servdb2 = $db->prepare($sql3);
					$servdb2->bindValue(":verifiedi", $verifiedi);
					$servdb2->bindValue(":servid", $servid);
					$servdb2->execute();
			} //if one of the POST Values changed				  
		}//while of POST submit
    }//end of if SUBMIT
    { //of if SUBMIT
    	//Drop down for agencies list ?????????????????????????????????
        $agidsel = 0;//$servdbrow2['agency'];
        //$sql7 = "SELECT * FROM agencies WHERE id=:agidsel";
        //$agdb1 = $db->prepare($sql7);
        //$agdb1->bindvalue(":agidsel",$agidsel);
        //$agdb1->execute();
        //$agdbrow1 = $agdb1->fetch();
        $nameOfSelected = "Select Agency";//$agdbrow1['name'];

        //$agid = 0;
        $agency = "agency";
        $i = 0;
        $agdb2 = $db->prepare("SELECT * FROM agencies");
        $agdb2->execute();
        //This should never happen
        if ($agdb2->rowCount() < 1) return false;
	echo "Select:<select name='agency' onchange='refresh()'>";
        echo "<option value='" . $agidsel . "' >" . $nameOfSelected . "</option>";
        while ($agdbrow2 = $agdb2->fetch()) {
            $i++;
            echo "<option value='" . $agdbrow2['id'] . "' ";
            if ($_POST['agid'] == $agdbrow2['id']) {   //?1
                echo "selected";
                $agid = $agdbrow2['id'];
                $agency = $agdbrow2['name']; // sets $sss5
						//$agencyupdate = "agid";
            }
            echo ">" . $agdbrow2['name'] . "</option>";
        }
        echo "</select>";
        //Not sure if the next two line are necessary, I just left them in in case
        echo "<input type=hidden value='" . $agid . "' name='agid'>";
        echo "<input type=hidden value='" . $teacherid . "' name=teacherid>";
	echo $_POST['agid'];
	if ($_POST['agid']!=0){
		echo "Yo just after POST agency";
                ////Set up query, only display unverified ones for a particular agency
		$verified = 0;
                $agency = $_POST['agid'];
		//$result = mysql_query("SELECT * FROM service WHERE verified = 0 ORDER by student");
		$servdb3 = $db->prepare("SELECT * FROM service WHERE verified = :verified AND agency = :agency ORDER by student");
		$servdb3->bindvalue(":verified",$verified);
		$servdb3->bindvalue(":agency",$agency);
		$servdb3->execute();
		//$result = mysql_query("SELECT * FROM service WHERE verified = 0 ORDER by student");
        //if ($row = mysql_fetch_array($result)) 
		if ($servdb3->rowCount()>0) 
		{
                    echo "<center>For this page, do not use the refresh button, it will result in incorrect submissions.</center>";
                    //Table header
?>
                    <table id ="customers" align=center border=1><tr><th>First Name</th><th>Last Name</th><th>Grade</th><th>Date</th><th>Agency/Notes</th><th>Hours</th><th>Role</th><th>Verified</th></tr>
<?php
                    //Set up more queries for table displays
                    $i = 0;
                    //while ($row = mysql_fetch_array($result))
                    while ($servdbrow2 = $servdb3->fetch())
                    {
                        $sid = $servdbrow2['student'];
			$sql6 = "SELECT * FROM student WHERE id=:sid";
			$studb1 = $db->prepare($sql6);
			$studb1->bindvalue(":sid",$sid);
			$studb1->execute();
			$studbrow1 = $studb1->fetch();					
			//$student = mysql_query("SELECT * FROM student WHERE id = $servdbrow[student]. ");
                	//$row2 = mysql_fetch_array($student);
			$agidsel = $servdbrow2['agency'];
			$sql7 = "SELECT * FROM agencies WHERE id=:agidsel";
			$agdb1 = $db->prepare($sql7);
			$agdb1->bindvalue(":agidsel",$agidsel);
			$agdb1->execute();
			$agdbrow1 = $agdb1->fetch();
			$nameOfSelected = $agdbrow1['name'];
					
			//$agency = mysql_query("SELECT * FROM agencies WHERE id = $servdbrow[agency]. ");
        	        //$row3 = mysql_fetch_array($agency);
                        $i++;
			//Display table results
                        echo "<tr class=alt>";
?>
			<td><?php echo $studbrow1['firstname']; ?></td>
			<td><?php echo $studbrow1['lastname']; ?></td>
			<td><?php echo $studbrow1['grade']; ?></td>
			<td><?php echo $servdbrow2['date']; ?></td>
			<td width="150">
<?php //echo //$row3['name']
                        echo $nameOfSelected . "<br>";
                        $notes = $servdbrow2['notes'];
                        echo "<textarea rows=5 cols=50 name='notes". $i ."'>".$servdbrow2['notes']."</textarea><br><br>";
	
?>
			</td>
                        <td>
<?php 
			$hours = $servdbrow2['servicehours'];//"hours$i";
                        echo "<input type=text size=5 name='hours". $i ."' value='" . $servdbrow2['servicehours'] . "'><br><br>";
?>
			</td>
			<td>
<?php
                        //Radio Box for Role in service, set them equal to either L, I or B
                        //Figured out double quotes would make the variable appear and I was doing INSERT instead of UPDATE for my queries
                        echo "<input type='radio' value = 'L' name='role" . $i . "' >Leadership<br>";
	 		echo "<input type='radio' value = 'I' name='role" . $i . "' > Initiative <br>";
	 		echo "<input type='radio' value = 'B' name='role" . $i . "' > Both <br>"; 
?>			</td>
                        <td>
<?php                   //Radio Box for Verification INSERT 1 for verified and 2 for not verified so that each request won't keep appearing even though its already been denied
                        echo "<input type='radio' value = '1' name='verifiedValue" . $i . "' > Verified <br>";
			echo "<input type='radio' value = '2' name='verifiedValue" . $i . "' > Rejected <br>";
?>                      </td>
<?php
                	echo "</tr>";
                    } //while for table end
                } //if data for table
?>
            </table>    <!-- service display table //-->
<?php       }
                echo "</table>"; //table that is the page?
                echo"";
           }
?>
            <center><input type='submit' name='submit' value='Submit'><br><br></center>
		</form>
<?php
	} 
	else { //if isset
            redirect("login.php?serviceVerifyA.php");
	} //if Session
}//if isset
$db = null;
//</form>
?>
        	
		</td></table>
	</body>
</html>