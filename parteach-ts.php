<?php 
session_start();
include 'functions.php';
teacher_only();
password_protect();
echo "<!DOCTYPE>";
 ?>
 <html>
 <head>
 	<title>Parent Teacher Night</title>
 	<link rel="stylesheet" type="text/css" href= "parteachcss.css" />
 </head>
 <body bgcolor=#CCCCCC>
<div id="content">
 	<h1>Parent Teacher Night</h1>
 	<h2>Here's Your schedule for the day.</h2>
 	<a href= "<?php echo base_url() ?>" >Back to EHGP</a><br/><br/>
 
 <?php
$db = get_database_connection();

main($db);

function main($db) {
	$pageName = basename($_SERVER['PHP_SELF']);

/*	echo "<pre align='left'>";
	print_r(get_appts($db));
	echo "</pre>";*/


	$appts= get_appts($db);
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
		
		if((isset($student['firstname'])) && (isset($student['lastname']))){
			echo $student['firstname']." ".$student['lastname'];
		}else{
			echo "Open";
		}
		
		
		echo "</td></tr>";
		
		
		$starttime->add(new DateInterval('PT10M'));
	}

	echo "</table>";
	echo "<br/><a id='print' href='#'>Ready to Print?</a></div>";
	$appts = null;
	$db = null;
}

function self_url() {
	return "par-teach-night.php?teacher=".$_GET['teacher'];
}

function get_student_from_id($db,$id) {
    $statement = $db->prepare("SELECT firstname, lastname FROM student WHERE id=:id");
    $statement->bindValue(":id", $id);
    $statement->execute();

	$val = $statement->fetch();
	return $val;
}

function get_appts($db) {
	$teacher= get_teacher_id($_SESSION['username']);
	$statement = $db->prepare("SELECT student, slot FROM parentteachernight WHERE teacher=:teacher ORDER BY slot");
	$statement->bindValue(":teacher", $teacher);
	$statement->execute();
	return $statement->fetchAll();
}

  ?>
 </div>
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

