<?php

//Created and edited by Ricky Wang
session_start();
include 'functions_2.php'; 
password_protect();
error_reporting(0);

$db = get_database_connection();


$header = "ERROR NO INPUT";
$message = null; //message to be displayed in button
$link = null; //link for button
$warningMessage = null;

if ($_POST['deleteptn1']==true){
	$delete_ptn = $_POST['deleteptn1'];
	$query = $db->prepare("DELETE FROM parentteachernight");
	$query->execute();
	$header = "Data Deleted!";
	if (is_teacher($_SESSION['username'], $_SESSION['password'])) {
        $message = "Parent Teacher Night";
        $link = "admin-ts_2.php";
    } else {
		$header = "DELETE Data Failed";
        $warningMessage = "Please see Technology Support.";
	}
}else { //tried to submit "nothing"
    $header = "Failed";
    //$warningMessage = "When filling out this form, be sure to complete all required fields.";
	$warningMessage = "Failed to Delete Parent Teacher Night Data";
}
 
$db = null;
include 'includeInc_2.php';
dohtml_header($header);
echo "<table class=centered>";
if (isset($warningMessage)) {
    echo "<tr><td>" . $warningMessage . "</td></tr>";
}
if (isset($message) && isset($link))
    makeButton($message, $link);
homeLogout();
echo "</table>";
dohtml_footer(true);
?>