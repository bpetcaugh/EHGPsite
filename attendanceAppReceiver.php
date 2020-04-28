<?php
session_start();
include 'functions_2.php';
include 'includeInc_2.php';
$db = get_database_connection();

$date = date('m-j-Y');

$user = $_POST["user"];
$password = $_POST["password"];
$fileText = $_POST["file"];

$teacher = $db->prepare("SELECT * FROM teacher WHERE username=:user");
$teacher->bindValue(":user", $user);
$teacher->execute(); 
$row = $teacher -> fetch();
if ($row['password'] == $password && $password != null)
{
	$count=1;
	while (file_exists("AttendanceFiles/" . $date . $user . $count . ".txt"))
	{
		$count++;
	}
	$f=fopen("AttendanceFiles/" . $date . $user . $count . ".txt","w+");
	
	fwrite($f,"$fileText");
	
	fclose($f);
	
	echo "Upload Successful";
}
else
	echo "Login Failed";
	
?>