<?php 
session_start();
include 'functions.php';
password_protect();
att_admin_only();//Mr. Chapman
 ?>
<!DOCTYPE>
<html>
<head>
	<title>Edit Note - EHGP</title>
	<style type="text/css">
		#content { height:180px; width:250px; margin: 5% auto; padding: 20px 10px; text-align: center; border: 2px dotted #999;}
		table {margin: 0 auto; }
		td {text-align: left; }
		input {margin-left: 20px; margin-top: 15px;}
	</style>
</head>

<body bgcolor=#CCCCCC>
<div id="content">
<h1>Edit Note</h1>
<?php
//Student id where note is going to be changed
$id = $_POST['id'];

$db = get_database_connection();//use function.php
$statement = $db->prepare("SELECT * FROM absentee WHERE id=:id");//gets current note
$statement->bindValue(":id", $id);
$statement->execute();
$record = $statement->fetch();
$submitname = (strlen($record['notes'])>0) ?"Change Note" :"Add Note";
$prevPage= "editabsentee.php?date=".$_POST['date'];

echo "Student: ".$record['name'];
//htmlspecialchars filters out code injections
echo "<form action='$prevPage' method='post'>
		Note: <input id='inputtext' type='text' name='note'value='".htmlspecialchars($record['notes'], ENT_QUOTES, 'UTF-8'). "'/>";
echo "<input type='hidden' name='id' value='" .$id. "'><br/>";
echo "<a href='$prevPage'>Cancel</a>";
echo "<input class='button' type='submit' value='$submitname'/>";
echo "</form>";
 ?>
 </div>
 </body>
 </html>