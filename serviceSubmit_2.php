<?php

session_start();
include 'functions_2.php'; 
password_protect();
error_reporting(0);
//require_once "Mail.php";

$db = get_database_connection();

if (isset($_POST['servicehours']) && $_POST['servicehours']) {
    $sql = "INSERT INTO service (student, servicehours, date, agency, notes, verified) VALUES (:student, :servicehours, :date, :agency, :notes, :verified)";
    $query = $db->prepare($sql);
    $query->bindValue(":student", $_SESSION['id']);
	$query->bindValue(":servicehours", $_POST['servicehours']);
	$query->bindValue(":date", $_POST['date']);
	$query->bindValue(":agency", $_POST['agency']);
	$query->bindValue(":notes", $_POST['notes']);
	$query->bindValue(":verified", 0);
    $query->execute();
    $header = "Service Added";
    
} else { //tried to submit "nothing"
    $header = "Failed";
    $warningMessage = "When filling out this form, be sure to complete all required fields.";
}
 
$db = null;
include 'includeInc_2.php';
dohtml_header($header);
echo "<table class=centered>";
homeLogout();
echo "</table>";
dohtml_footer(true);
?>