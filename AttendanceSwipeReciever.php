<?php
session_start();
include 'functions_2.php';
include 'includeInc_2.php';
$db = get_database_connection();

$date = date('m-j-Y');

$student = $db->prepare("SELECT * FROM student WHERE accessID=:accessID");
$student->bindValue(":accessID", $_POST["idnum"]);
$student->execute();
if($student->rowCount() > 0){
	$row = $student -> fetch();
	echo $row['firstname'] . " " . $row['lastname'];
}
else
	echo "ID Not Found"
	
?>