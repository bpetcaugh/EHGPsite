<?php 
session_start();
include 'functions.php';
password_protect();
admin_only();
echo "<!DOCTYPE>";
include 'teacherpicker.php';
 ?>
 
 <html>
 <head>
 	<title>Parent Teacher Night</title>
 	<link rel="stylesheet" type="text/css" href= "parteachcss.css" />
 </head>
 <body bgcolor=#CCCCCC>
<div id="content">
 	<h1>Parent Teacher Night</h1>
 	<h2>Here's the schedule for this teacher.</h2>
 	<a href= "<?php echo base_url() ?>" >Back to EHGP</a><br/><br/>
 
 <?php
 
	//Runs when the page loads. For reserving slots. If slot is not 0, which means that someone clicked Reserve on one of the slots, it will use schedule_appointment to reserve that slot.
	$db = get_database_connection();
	if ((isset($_POST['slot'])) && ($_POST['slot'] > 0)) {
		schedule_appointment($db);
		echo "<input type='hidden' name='slot' value=0 />";
	}

	//Runs when page loads. For canceling slots.If removeslot is not 0, which means that someone canceled on one of their slots, it will use remove_appointment to cancel that appointment
	if ((isset($_POST['removeslot'])) && ($_POST['removeslot'] != null)) {
		unblock_appointment($db);
		echo "<input type='hidden' name='removeslot' value=null/>";
	}
	
main($db);

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
	$starttime = new DateTime('4:30 PM');
	for ($i=1; $i <= 18; $i++) {
		echo "<tr><td>(".$starttime->format('h:i A').")";
		$student = '';
		
		$appt=null;
		if(isset($appts[$cur])){
			$appt = $appts[$cur];
		}
		
		if ($appt['slot'] == $i){
			$student = get_student_from_id($db, $appt['student']);
			$cur++;
		}
		
		if (slot_is_available($db, $i, $sel)) {
			echo "Open";
			echo "<form method='post' action='".self_url()."'>
				<input type='submit' value='Block'/>
				<input type='hidden' name='slot' value='$i'/>
			</form>";
		} else {
			if((isset($student['firstname'])) && (isset($student['lastname']))){
				echo $student['firstname']." ".$student['lastname'];
				echo "<form method='post' action='".self_url()."'>
				<input type='submit' value='Unblock'/>
				<input type='hidden' name='removeslot' value='$i'/>
			</form>";
			}else{
				echo "Unavailable";
				echo "<form method='post' action='".self_url()."'>
				<input type='submit' value='Unblock'/>
				<input type='hidden' name='removeslot' value='$i'/>
			</form>";
			}
		}
		
		echo "</td></tr>";
		
		
		$starttime->add(new DateInterval('PT10M'));
	}

	echo "</table>";
	//Creates link to print out page.
	echo "<br/><a id='print' href='#'>Ready to Print?</a></div>";
	
 
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

function get_teachers_appts($db) {
	if(isset($_GET['teacher'])){
		$statement = $db->prepare("SELECT student, slot FROM parentteachernight WHERE teacher=:teacher ORDER BY slot");
		$statement->bindValue(":teacher", $_GET['teacher']);
		$statement->execute();
		return $statement->fetchAll();
	}
}

function slot_is_available($db, $slot, $teacher) {
	// $statement = $db->prepare("SELECT id FROM parentteachernight WHERE (teacher=:teacher OR student=:student) AND slot=:slot");
	//First part checks if this teacher is open, and the second part checks whether this student is open.
	$statement = $db->prepare("SELECT id FROM parentteachernight WHERE teacher=:teacher AND slot =:slot");
	$statement->bindValue(":teacher", $teacher);
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
	$student= 0;
	$teacher= $_GET['teacher'];
	$slot = $_POST['slot'];

	//Inserts a new row into the table with the student id, teacher id, and slot number of the appointment.
    $statement = $db->prepare("INSERT IGNORE INTO parentteachernight (student, teacher, slot) VALUES (:student, :teacher, :slot)");
    $statement->bindValue(":student", $student);
    $statement->bindValue(":teacher", $teacher);
    $statement->bindValue(":slot", $slot);
    $statement->execute();

	//Void out $slot and $teacher so that it can be reasssigned properly on the next go around.
    $slot = null;
    $teacher = null;
}

//Blocks teacher appointment for this teacher for the indicated slot by removing the reservation.
function unblock_appointment($db){
	
	$removeslot = $_POST['removeslot'];
	$teacher = $_GET['teacher'];
	$statement = $db->prepare("DELETE FROM parentteachernight WHERE teacher=:teacher AND slot=:removeslot");
	$statement->bindValue(":teacher", $teacher);
	$statement->bindValue(":removeslot", $removeslot);
	$statement->execute();

}

function self_url(){
	//NOTIFICATION FIX AREA
	if(isset($_GET['teacher'])){
		return "admin-ts.php?teacher=".$_GET['teacher'];
	}
}
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
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
</body>
</html>
