<?php 
//edited by Vincent Pilinger
session_start();
include 'functions_2.php';
password_protect();
att_admin_only();//Mr. Chapman


//Student id where note is going to be changed
$id = $_POST['id'];

$db = get_database_connection();//use function_2.php
$statement = $db->prepare("SELECT * FROM absentee WHERE id=:id");//gets current note
$statement->bindValue(":id", $id);
$statement->execute();
$record = $statement->fetch();
$submitname = (strlen($record['notes'])>0) ?"Change Note" :"Add Note";
$prevPage= "editabsentee_2.php?date=".$_POST['date'];
include 'includeInc_2.php';
dohtml_header($submitname);

echo "<table class = centered>";
homeLogout();
echo "<tr><td>";
echo "Student: ".$record['name'];
//htmlspecialchars filters out code injections
echo "<form action='$prevPage' method='post'>
		Note: <input id='inputtext' type='text' name='note'value='".htmlspecialchars($record['notes'], ENT_QUOTES, 'UTF-8'). "'/>";
echo "<input type='hidden' name='id' value='" .$id. "'><br/>";
echo "<input type='button' value='Cancel' onclick='self.location ='" . $prevPage . "'/>";
echo "<input class='button' type='submit' value='$submitname'/>";
echo "</td></tr></form>";
 ?>
