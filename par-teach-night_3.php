<?php
//Much of original code by Liam Cain. Updated and edited by Fred Kummer
session_start();
include 'functions_2.php';
//From regular functions.
password_protect();
include 'includeInc_2.php';
dohtml_header("Parent Teacher Night");
include 'teacherpicker_2.php';//mmm fixed _2

 ?>
 <head>
 	<link rel="stylesheet" type="text/css" href= "parteachcss_2.css" />
</head>
<body bgcolor=#CCCCCC>
<div id="content">
<!-- <h3>Please call the school office at 215-639-2102 to schedule an appointment to see your son's teachers
on Parent-Teacher Night. Thank you.</h3>//-->
<h2>Schedule an appointment with your son's teachers.</h2>
<?php
	$year = date("Y");
 	echo "<h2 class='hide'>The following is your schedule for Holy Ghost Prep's Parent Teacher Night ".$year.".  Please keep this in a safe place.</h2>"
?>


 <?php
	//Shows a disclaimer warning about scheduling times, only appears on the first visit of the session.
	if (!isset($_SESSION['disclaimer'])) {
 		echo "<h4>Disclaimer: All appointments scheduled before the announced signup start date will be voided. While you can schedule 2 teachers back-to-back, we caution you to leave gaps in your schedule to compensate for travel time.  There is no time in between time slots, so if you have to travel a distance (i.e. between buildings), anticipate that it will take a few minutes to get there. <a href=\"#\">Okay!</a></h4>";
 		$_SESSION['disclaimer'] = 1;
 	}
?>

	<!--Link to take user back to the EHGP index page.-->
 <?php

	//Runs when the page loads. For reserving slots. If slot is not 0, which means that someone clicked Reserve on one of the slots, it will use schedule_appointment to reserve that slot.
	$db = get_database_connection();
	if ((isset($_POST['slot'])) && ($_POST['slot'] > 0)) {
		schedule_appointment($db);
		echo "<input type='hidden' name='slot' value=0 />";
	}

	//Runs when page loads. For canceling slots.If removeslot is not 0, which means that someone canceled on one of their slots, it will use remove_appointment to cancel that appointment
	if ((isset($_POST['removeslot'])) && ($_POST['removeslot'] != null)) {
		remove_appointment($db);
		echo "<input type='hidden' name='removeslot' value=null/>";
	}

//Runs the main function, creating the reservation table and schedule along with their buttons.
main($db);

function main($db) {
	//PHP_SELF returns the path from the root folder to this php file, and basename cuts off everything but the file name, so this stores the name of this php file in pagename.
	$pageName = basename($_SERVER['PHP_SELF']);
	echo "<div id='left'>";

	//In teacherpicker.php. Returns a dropdown menu of teachers with their values equal to their id numbers. mmm-seq number
	teacherSelector($pageName);

	//The value of $_GET['teacher'] is the id number of the selected teacher. Assigned to $sel mmm-seq number
	//THIS IS A NOTIFICATION FIX AREA
	$sel = null;
	if(isset($_GET['teacher'])){
		$sel= $_GET['teacher'];
	}

	//Echoes out a table of times, submit buttons, and hidden inputs that hold the slot value. Redoes it each time page is loaded, so when ever the teacher is changed.
	//If the slot is reserved, echoes out "Unavailable"
	echo "<table>";
	$starttime = mktime(16,30,0, 0,0,0);//new DateTime('2015-07-16 16:30'); replaced by Mike Meistering 7-22-15
	//$starttime = new DateTime('4:30 PM');
	for ($i=1; $i <= 18; $i++) {
		echo "<tr><td>(".date('g:i A',$starttime).")";//$starttime->format('h:i A') mmm 7-22-15
		//Checks if this slot is open for this teacher. Function defined below.
		if (slot_is_available($db, $i, $sel)) {
			echo "<form method='post' action='".self_url()."'>
				<input type='submit' value='Reserve'/>
				<input type='hidden' name='slot' value='$i'/>
			</form>";
		} else {
			echo "Unavailable";
		}
		echo "</td></tr>";
		//Increments the time.
		$starttime = date($starttime+600);//mmm 7-22-15
		//$starttime->add(new DateInterval('PT10M'));
	}
	echo "</table></div>";



	echo "<div id='right'>";
	//Gets the teacher id and slot rows corresponding to your student number from the database, arranged by ascending slot number. Defined below
	$appts= get_appts($db);
	echo "<h3>Your Schedule</h3>";
	echo "<table>";

	//Used to indicate which of the appointments in the $appts resource to get, starting with the first appointment
	$cur = 0;
	
	$starttime = mktime(16,30,0, 0,0,0);//new DateTime('2015-07-16 16:30'); replaced by Mike Meistering 7-22-15
	//$starttime = new DateTime('4:30 PM');

	//Print out your schedule of appointments, as well as buttons to cancel appointments.
	for ($i=1; $i <= 18; $i++) {
		echo "<tr><td>";
		$teacher = '';

		//Get one of the appointments out of $appts
		//NOTIFICATION FIX AREA
		$appt = null;
		if(isset($appts[$cur])){
			$appt = $appts[$cur];
		}

		//If the slot of the appointment gotten above matches the slot we are currently trying to print out for ($i), then set $teacher to
		//the teacher in this appointment by using its id and increment $cur to move to the next appointment in $appts
		if ($appt['slot'] == $i){
			//Get teacher resource for this appointment by its id
			$teacher = get_teacher_from_id($db, $appt['teacher']);
			$cur++;
		}

		//Print out teacher and room to this slot in the table.
		if((isset($teacher['name'])) && (isset($teacher['room']))){
			echo $teacher['name']." ".$teacher['room'];
		}

		//Create a remove button to cancel teacher appointments.
		if ((isset($teacher['name'])) && (strlen($teacher['name']) > 1)) {
			//Allows teachers to be removed by setting removeslot to a value when submit button is clicked.
			echo "<form method='post' action='".self_url()."'>
			<input type='submit' value='Remove'>
			<input type='hidden' name='removeslot' value='$i'></form>";
		} else {
			//If there is no teacher in this slot, indicate that it is open.
			echo "Open ";
		}
		//display mmm 7-22-15
		//echo $starttime->format('h:i A')." </td></tr>";
		echo "(" . date('g:i A',$starttime) . ")</td></tr>";
		//Increments the time. mmm 7-22-15
		$starttime = date($starttime+600);
		//$starttime->add(new DateInterval('PT10M'));
	}
//	endAndBeginTable(); ruins print!
//Creates link to print out page.
echo "</table><table class='centered'><tr></tr><tr class='centeredButton'><td width=50%></td>
				<td class='centered' colspan=2><a class='glossy-button blue' id='print' href='#'>Ready to Print</a></td><td width=50%></td>
		</tr>";
	echo "</table>";


	$appts = null;
	$db = null;

}

//Checks whether a slot is available, by checking if there is any appointment for this teacher in this slot or if this student has an appointment in this slot
function slot_is_available($db, $slot, $teacher) {
	$student= get_student_id($_SESSION['username']);
	// $statement = $db->prepare("SELECT id FROM parentteachernight WHERE (teacher=:teacher OR student=:student) AND slot=:slot");
	//First part checks if this teacher is open, and the second part checks whether this student is open.
	$statement = $db->prepare("SELECT id FROM parentteachernight WHERE (teacher=:teacher AND (student=:student OR slot =:slot)) OR (student=:student AND slot=:slot)");
	$statement->bindValue(":teacher", $teacher);
	$statement->bindValue(":student", $student);
	$statement->bindValue(":slot", $slot);
	$statement->execute();

	$val = $statement->fetch();

	//If there is no appointment to fetch, id will be 0, so this slot is available then.
	return ($val == 0);
}

//Returns URL of this page with the proper teacher value set.
function self_url(){
	//NOTIFICATION FIX AREA
	if(isset($_GET['teacher'])){
		return "par-teach-night_3.php?teacher=".$_GET['teacher'];
	}
}

//Gets the room and name of the teacher with $id from the the teacher table.
function get_teacher_from_id($db,$id) {
    $statement = $db->prepare("SELECT name, room FROM teacher WHERE seq=:id");//mmm
    $statement->bindValue(":id", $id);
    $statement->execute();

	$val = $statement->fetch();
	return $val;
}

//Returns the teacher id and slot rows from the parent teacher night table for this student. They are arranged by ascending order by their slot number.
function get_appts($db) {
	$student= get_student_id($_SESSION['username']);
	$statement = $db->prepare("SELECT teacher, slot FROM parentteachernight WHERE student=:student ORDER BY slot");
	$statement->bindValue(":student", $student);
	$statement->execute();
	return $statement->fetchAll();
}

//Schedules the appointment for the selected teacher in the selected slot.
function schedule_appointment($db) {
	//If no teacher has been selected, do nothing.
	if (!isset($_GET['teacher'])) {
		return;
	}

	//Get student's id, teachers id number, and the slot number. These come from the dropdown menu.
	$student= get_student_id($_SESSION['username']);
	$teacher= $_GET['teacher'];
	$slot = $_POST['slot'];

  //Does a secondary check, before inserting into the database to make sure 
  //that the slot is still available [Eric Ghildyal]
  if(slot_is_available($db, $slot, $teacher) == 0) {
    echo "<h4>The slot you chose has already been taken.</h4>";
    
    return;
  }

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

//Removes teacher appointment for this student for the indicated slot.
function remove_appointment($db){
	$removeslot = $_POST['removeslot'];
	$student= get_student_id($_SESSION['username']);

    $statement = $db->prepare("DELETE FROM parentteachernight WHERE student=:student AND slot=:removeslot");
    $statement->bindValue(":student", $student);
    $statement->bindValue(":removeslot", $removeslot);
    $statement->execute();
}
  ?>
 </div>

 <!--Here be JQuery. Should not need to be changed, references a file on the internet.-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
 <script>
     $("h4 a").click(function (event) {
     	event.preventDefault();
     	$(this).parent().hide();
     });
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
