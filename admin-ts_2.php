<?php
//Created and edited by Fred Kummer 
//modified for new server by Mr. Meistering/Jacobs 7-16-15
//line 244 uses illegal student number
session_start();
include 'functions_2.php';
password_protect();
admin_only();
include 'includeInc_2.php';
include 'teacherpicker_2.php';
//dohtml_header("Parent Teacher Night"); actually placed in document due to css
echo "<html>";
?>
   
   
        <!-- holyghostprep.org/ehgp -->

        <!--[if lt IE 7]> <html class="no-js ie6 ie" lang="en"> <![endif]-->
        <!--[if IE 7]>    <html class="no-js ie7 ie" lang="en"> <![endif]-->
        <!--[if IE 8]>    <html class="no-js ie8 ie" lang="en"> <![endif]-->
        <!--[if IE 9 ]>   <html class="no-js ie9 ie" lang="en"> <![endif]-->
        <!--[if gt IE 9]> <html class="no-js" lang="en"> <![endif]-->
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
            <title><?php echo "$title"; ?></title>
            <style type="text/css">
                @import url(css_2.css);
            </style>    

            <script type="text/javascript">
           //     function refresh(form)
            //    {
           //         form.submit();
           //     }
				function refresh(){
		var formObject = document.forms['theForm'];
		formObject.submit();
	}
            </script>
			<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <link rel="stylesheet" type="text/css" href="css_2.css" />
			<link rel="stylesheet" type="text/css" href= "parteachcss_2.css" />
        </head>
        <body>
            <table class='centered'>
                <tr>
                    <td class='headerLeft'> 
                    </td>
                    <td class='headerCenter'>
                
                    <img src="Header1.jpg" class="headerMap" usemap="#headermap" alt="Holy Ghost Prep"/>
                    <map name="headermap">
                        <area shape="rect" coords="225,34,615,123" href="http://www.holyghostprep.org" alt="HGP Home" />
                        <area shape="circle" coords="161,70,65" href="http://www.holyghostprep.org" alt="HGP Home" /> <!--coordinates of center then radius of circle//-->

                        <area shape="rect" coords="695,9,788,24" href="http://www.holyghostprep.org/page.cfm?p=317" alt="News And Events" />
                        <area shape="rect" coords="815,9,909,24" href="http://www.holyghostprep.org/page.cfm?p=76" alt="Donate to HGP" />
                        <area shape="rect" coords="931,9,988,24" href="http://www.holyghostprep.org/page.cfm?p=299" alt="Calender" />

                        <area shape="rect" coords="644,125,715,144" href="http://www.holyghostprep.org/page.cfm?p=2" alt="About HGP" />
                        <area shape="rect" coords="740,125,808,144" href="http://www.holyghostprep.org/page.cfm?p=3" alt="Academics" />
                        <area shape="rect" coords="837,125,906,144" href="http://www.holyghostprep.org/page.cfm?p=4" alt="Admissions" />
                        <area shape="rect" coords="933,125,1008,144" href="http://www.holyghostprep.org/page.cfm?p=7" alt="Campus Life" />
                        <area shape="rect" coords="1028,125,1135,144" href="http://www.holyghostprep.org/page.cfm?p=5" alt="Alunmi & Parents" />
                    </map>
            </td>
            
            <td class='headerRight'></td>
        </tr>
        <tr>
            <td></td>
            <td class="centered">
                <?php
                //echo"<h1 align='center'>$title</h1>"
                ?>
            </td>
            <td></td>
        </tr>
    </table>
          <?php  $title="Parent Teacher Night";
		  echo" <h1 class='centered'>$title</h1>"
                  ?>

<div id="content">
 	<h2>Here's the schedule for this teacher.</h2>
 
 <?php
 
	//Runs when the page loads. For reserving slots. If slot is not 0, which means that someone clicked Reserve on one of the slots, it will use schedule_appointment to reserve that slot.
	$db = get_database_connection();
	if ((isset($_POST['slot'])) && ($_POST['slot'] > 0)) {
		$slot=$_POST['slot'];
		$teacher= $_GET['teacher'];
		if ((slot_is_available($db, $slot, $teacher))){//mmm 7-21-15 added slot is available call
			schedule_appointment($db);
		}
		echo "<input type='hidden' name='slot' value=0 />";
	}

	//Runs when page loads. For canceling slots.If removeslot is not 0, which means that someone canceled on one of their slots, it will use remove_appointment to cancel that appointment
	if ((isset($_POST['removeslot'])) && ($_POST['removeslot'] != null)) {
		unblock_appointment($db);
		echo "<input type='hidden' name='removeslot' value=null/>";
	}
	
main($db); //okay to leave as is

function main($db) {
	$pageName = basename($_SERVER['PHP_SELF']);
	if(!isset($_GET['teacher'])){
		echo "<form method='get'>
			<input type='hidden' name='teacher' value=''/>
		</form>";
	}
	
	teacherselector($pageName);
	
	
	$sel = null;
	if(isset($_GET['teacher'])){
		$sel= $_GET['teacher'];
	}
	
	$appts= get_teachers_appts($db);
	echo "<h3>Your Schedule</h3>";
	echo "<table>";
	$cur = 0;
	
	$starttime = mktime(16,30,0, 0,0,0);//new DateTime('2015-07-16 16:30'); replaced by Mike Jacobs/Meistering 7-16-15
	
	for ($j=1; $j <= 18; $j++) {
		echo "<tr><td>(".date('g:i A',$starttime).")";//(".$starttime->format('h:i A').")";
		$student =  '';
		
		$appt=null;
		if(isset($appts[$cur])){
			$appt = $appts[$cur];
		}
		
		if ($appt['slot'] == $j){
			$student = get_student_from_id($db, $appt['student']);
			$cur++;
		}
		
		if (slot_is_available($db, $j, $sel)) {
			echo "Open";
			echo "<form method='post' action='".self_url()."'>
				<input type='submit' value='Block'/>
				<input type='hidden' name='slot' value='$j'/>
			</form>";
		} else {
			if((isset($student['firstname'])) && (isset($student['lastname']))){
				echo $student['firstname']." ".$student['lastname'];
				echo "<form method='post' action='".self_url()."'>
				<input type='submit' value='Unblock'/>
				<input type='hidden' name='removeslot' value='$j'/>
			</form>";
			}else{
				echo "Unavailable";
				echo "<form method='post' action='".self_url()."'>
				<input type='submit' value='Unblock'/>
				<input type='hidden' name='removeslot' value='$j'/>
			</form>";
			}
		}
		
		echo "</td></tr>";
		
		$starttime = date($starttime+600);//The Mikes 7-16-15
	}

//	echo "</table>";
	//Creates link to print out page.
//	echo "<br />	<table class='centered'>
//			<tr class='centeredButton'><td width=50%></td>
//				<td class='centered' colspan=2><a class='glossy-button blue' id='print' href='#'><span>Ready to Print</span></a></td>
//			<td width=50%></td>
//			</tr>
//		</table>";
	
	//
	echo "</table><table class='centered'><tr></tr><tr class='centeredButton'><td width=50%></td>
				<td class='centered' colspan=2><a class='glossy-button blue' id='print' href='#'>Ready to Print</a></td><td width=50%></td>
		</tr>";
	echo "</table>";

	
	//
	$appts = null;
	$db = null;
}

function get_student_from_id($db,$id) {
    $statement = $db->prepare("SELECT firstname, lastname FROM student WHERE id=:id");
    $statement->bindValue(":id", $id);
    $statement->execute();
	$val = $statement->fetch();
	return $val;
}
//mmm taken from par-teach-night_2.php
//Gets the room and name of the teacher with $id from the the teacher table.
function get_teacher_seq_from_id($db,$id) {
    $statement = $db->prepare("SELECT * FROM teacher WHERE seq=:id");//mmm
    $statement->bindValue(":id", $id);
    $statement->execute();

	$val = $statement->fetch();
	return $val;
}


function get_teachers_appts($db) {
	if(isset($_GET['teacher'])){
		$val = get_teacher_seq_from_id($db,$_GET['teacher']);//mmm added
		$statement = $db->prepare("SELECT student, slot FROM parentteachernight WHERE teacher=:teacher ORDER BY slot");
		$statement->bindValue(":teacher", $val['seq']);//formerly $_GET['teacher']
		$statement->execute();
		return $statement->fetchAll();
	}
}

function slot_is_available($db, $slot, $teacher) {
	// $statement = $db->prepare("SELECT id FROM parentteachernight WHERE (teacher=:teacher OR student=:student) AND slot=:slot");
	//First part checks if this teacher is open, and the second part checks whether this student is open.
	$val = get_teacher_seq_from_id($db,$teacher);//mmm added
	$statement = $db->prepare("SELECT id FROM parentteachernight WHERE teacher=:teacher AND slot =:slot");
	$statement->bindValue(":teacher", $val['seq']);//mmm changed from $teacher
	$statement->bindValue(":slot", $slot);
	$statement->execute();

	$val = $statement->fetch();
	
	//If there is no appointment to fetch, id will be 0, so this slot is available then.
	return ($val == 0);
}

//Schedules the appointment for the selected teacher in the selected slot. Used here to block off appointments.
function schedule_appointment($db) {
		//If no teacher has been selected, do nothing.
	if (!isset($_GET['teacher'])) {
		return;
	}
		
	//Get student's id, teachers id number, and the slot number. These come from the dropdown menu.
	$student= 99498; //non-existent at all student so that Unavailable gets displayed using the same query as if a student was assigned
	$teacher= $_GET['teacher'];
	$slot = $_POST['slot'];

	$val = get_teacher_seq_from_id($db,$teacher);//mmm added
	//Inserts a new row into the table with the student id, teacher id, and slot number of the appointment.
    $statement = $db->prepare("INSERT IGNORE INTO parentteachernight (student, teacher, slot) VALUES (:student, :seq, :slot)");//mmm changed to :seq from :teacher
    $statement->bindValue(":student", $student);
    $statement->bindValue(":seq", $val['seq']);//mmm changed from :teacher and $teacher to $val['seq']
    $statement->bindValue(":slot", $slot);
    $statement->execute();
//for ($i=1; $i<= 1118; $i++) {echo "if block hit"};
	//Void out $slot and $teacher so that it can be reasssigned properly on the next go around.
    $slot = null;
    $teacher = null;
}

//Blocks teacher appointment for this teacher for the indicated slot by removing the reservation.
function unblock_appointment($db){
	
	$removeslot = $_POST['removeslot'];
	$teacher = $_GET['teacher'];
	$val = get_teacher_seq_from_id($db,$teacher);//mmm added
	$statement = $db->prepare("DELETE FROM parentteachernight WHERE teacher=:teacher AND slot=:removeslot");
	$statement->bindValue(":teacher", $val['seq']);//changed from $teacher
	$statement->bindValue(":removeslot", $removeslot);
	$statement->execute();

}

function self_url(){
	//NOTIFICATION FIX AREA
	if(isset($_GET['teacher'])){
		return "admin-ts_2.php?teacher=".$_GET['teacher'];
	}
}
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	 <script>
		 $("#print").click(function (event) {
			event.preventDefault();
			$("h2, #left, h4, input").toggle();
			$(".hide").show();
			var $url = window.location;
			window.print();
			window.location = $url;
			$("h2, #left, .hide, input").toggle();
		 });
	 </script><br />
<table class="centered">
<?php

echo "</table><br/>";
	echo "<div style='tbody tr:nth-child(odd) {background-color: white;}'>";
	echo "<table class='centered'><tr></tr>";
	
//homeLogout();//to get rid of blue shadow, change this to add an extra row by including the code here and not calling the method	
echo '<tr class="centeredButton"><td width="50%"></td>
			
			<td class="centered" colspan=2><a class="glossy-button blue" href="index_2.php">Home</a></td>
			<td width="50%"></td>
			
		</tr><tr></tr>';
	//skip a row to get rid of coloring
	echo '
		<tr class="centeredButton"><td width="50%"></td>

			<td class="centered" colspan=2><a class="glossy-button blue" href="logout_2.php">Logout</a></td>
			<td width="50%"></td>
			
		</tr>';
	echo "</table></div></div>";


dohtml_footer(true);
?>