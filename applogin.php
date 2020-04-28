<?php
$_SESSION = array();
session_start();

include 'functions_2.php';

$db = get_database_connection();
if (login($_GET['username'], md5($_GET['password'])))
	echo "Login Successful";
else
	echo "Login Failed";
?>