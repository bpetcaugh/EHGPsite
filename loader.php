<?php
session_start();
include 'functions_2.php';
if ($_SESSION['isTeacher'] == true){ 
    redirect("index_2.php"); 
}
if ($_SESSION['isTeacher'] ==  false) {
    redirect("StudentLandingPage.php");
}
?>

<!-- are all admins teachers?-->