<?php 
session_start();
include 'functions_2.php';
teacher_only();
password_protect();
include 'includeInc_2.php';
dohtml_header("Parent Teacher Night");
 ?>
 <head>
 	<link rel="stylesheet" type="text/css" href= "parteachcss_2.css" />
 </head>
 <body bgcolor=#CCCCCC>
<div id="content">
 	<h2>Here's your schedule for the day.</h2>
 
 <?php
$db = get_database_connection();

main($db);

function main($db) {
	$pageName = basename($_SERVER['PHP_SELF']);


	$appts= get_appts($db);
	$teacher= get_teacher_id($_SESSION['username']);//mmm added in this spot 10-22-15
	$room = get_teacher_room_from_id($db,$teacher);
	echo "<h3>Your Schedule in Room ". $room ."</h3>";
	echo "<table>";

	$cur = 0;
	$starttime = mktime(16,30,0, 0,0,0);// new DateTime('4:30 PM'); replaced by Mike Meistering 7-19-15
	//$teacher= get_teacher_id($_SESSION['username']);//mmm added
	$sel = $teacher; //mmm added
	for ($i=1; $i <= 18; $i++) {
		echo "<tr><td>(".date('g:i A',$starttime).")";
		$student = '';
		
		$appt=null;
		if(isset($appts[$cur])){
			$appt = $appts[$cur];
		}
		
		if ($appt['slot'] == $i){
			$student = get_student_from_id($db, $appt['student']);
			$cur++;
		}
//mmm removed				
//		if((isset($student['firstname'])) && (isset($student['lastname']))){
//			echo $student['firstname']." ".$student['lastname'];
//		}else{
//			echo "Open";
//		}
		//mmm from admin-ts_2
		if (slot_is_available($db, $i, $sel)) {
			echo "Open";
		} else {
			if((isset($student['firstname'])) && (isset($student['lastname']))){
				echo $student['firstname']." ".$student['lastname'];
			}else{
				echo "Unavailable";
			}
		}
		//from admin-ts_2
		
		echo "</td></tr>";
		
		//incement time
		//added 7-19-15 mmm
		$starttime = date($starttime+600);
		//$starttime->add(new DateInterval('PT10M'));
	}

	//echo "</table>";
	//echo "<br/>	<table class='centered'>
	//		<tr class='centeredButton'>
	//			<td class='centered' colspan=2><a class='glossy-button blue' id='print' href='#'><span>Ready to Print</span></a></td>
	//		</tr>
	//	</table>";
		
	//Creates link to print out page.
	echo "</table><table class='centered'><tr></tr><tr class='centeredButton'><td width=50%></td>
				<td class='centered' colspan=2><a class='glossy-button blue' id='print' href='#'>Ready to Print</a></td><td width=50%></td>
		</tr>";
	echo "</table>";
	
		
	$appts = null;
	$db = null;
}

function self_url() {
	return "parteach-ts_2.php?teacher=".$_GET['teacher'];//used to go to par-teach-night_2.php 7-19-15
}

function get_student_from_id($db,$id) {
    $statement = $db->prepare("SELECT firstname, lastname FROM student WHERE id=:id");
    $statement->bindValue(":id", $id);
    $statement->execute();

	$val = $statement->fetch();
	return $val;
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

function get_appts($db) {
	$teacher= get_teacher_id($_SESSION['username']);
	$val = get_teacher_seq_from_id($db,$teacher);//mmm added
	
	$statement = $db->prepare("SELECT student, slot FROM parentteachernight WHERE teacher=:teacher ORDER BY slot");
	$statement->bindValue(":teacher", $val['seq']);//mmm formerly $teacher 
	$statement->execute();
	return $statement->fetchAll();
}
//
//mmm taken from par-teach-night_2.php

//function get_teachers_appts($db) {
//	if(isset($_GET['teacher'])){
//		$val = get_teacher_seq_from_id($db,$_GET['teacher']);//mmm added
//		$statement = $db->prepare("SELECT student, slot FROM parentteachernight WHERE teacher=:teacher ORDER BY slot");
//		$statement->bindValue(":teacher", $val['seq']);//formerly $_GET['teacher']
//		$statement->execute();
//		return $statement->fetchAll();
//	}
//}

//Gets the seq of the teach from the teacher id in the teacher table.
function get_teacher_seq_from_id($db,$id) {
    $statement = $db->prepare("SELECT * FROM teacher WHERE id=:id");//mmm
    $statement->bindValue(":id", $id);
    $statement->execute();

	$val = $statement->fetch();
	return $val;
}
//Gets the seq of the teach from the teacher id in the teacher table.
function get_teacher_room_from_id($db,$id) {
    $statement = $db->prepare("SELECT * FROM teacher WHERE id=:id");//mmm
    $statement->bindValue(":id", $id);
    $statement->execute();

	$val = $statement->fetch();
	return $val['room'];
}

//ajax address updated 7-19-15 mmm
  ?>
 </div>
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
	 </script>
<!--<table class="centered">//-->

<?php

	echo "</table><br/>";
	echo "<div style='tbody tr:nth-child(odd) {background-color: white;}'><table class='centered'><tr></tr>";
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

	echo "</table></div>";

dohtml_footer(true);
?>

