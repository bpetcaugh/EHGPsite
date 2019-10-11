<?php
session_start();
include 'functions_2.php';
include 'includeInc_2.php';
echo "<table class='centered'><tr><td>";
dohtml_header("Upload Attendance File");
teacher_only();
password_protect("login_2.php");
$db = get_database_connection();

$date = date('m-j-Y');

$FileType = pathinfo(basename($_FILES["attendancefile"]["name"]),PATHINFO_EXTENSION);
$target_dir = "AttendanceFiles/";
$target_file = $target_dir . basename($_FILES["attendancefile"]["name"], ".txt") . $_SESSION['username'] . ".txt";
$uploadOk = 1;

if ($_FILES["attendancefile"]["size"] > 10000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
if($FileType != "txt") {
    echo "Sorry, only txt files are allowed.";
    $uploadOk = 0;
}
if(basename($_FILES["attendancefile"]["name"], ".txt") != $date) {
    echo "Sorry, the file date does not match today's date.";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	$data = file_get_contents($_FILES["attendancefile"]["tmp_name"]);
    if (move_uploaded_file($_FILES["attendancefile"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["attendancefile"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$bom = pack('H*','EFBBBF');
$data = preg_replace("/^$bom/", '', $data);

foreach(preg_split("/((\r?\n)|(\r\n?))/", $data) as $line){
	$student = $db->prepare("SELECT * FROM student WHERE accessID=:accessID");
    $student->bindValue(":accessID", $line);
    $student->execute(); 
	$row = $student -> fetch();
	echo $row['firstname'] . " " . $row['lastname'] . " " . $row['accessID'] . "<br>";
} 

echo "<br><br>";
homeLogout();
echo "</table>";
dohtml_footer(true);

?>