<?php 
//edited by Vincent Pillinger
	session_start();
	include 'functions_2.php';
	teacher_only();
	password_protect();
	$stu= $_GET['stu'];
        include 'includeInc_2.php';
dohtml_header('Results for "' . $stu . '"');
  
 $data= get_data($stu);
 if (isset($_GET['date'])) {
     $prevPage= "editlate_2.php?date=".$_GET['date'];
 }else{
     $prevPage= "editlate_2.php";
 }
 echo "<table class='centered'>";
 homeLogout();
 tableRowSpace();
 makeButton("Edit Lates", "editlate_2.php");
 tableRowSpace();
 echo "</table>";
 
 echo "<table class='centered' border='1'><tr>
     <th>Date</th><th>Name</th><th>Note</th></tr>";
 foreach($data as $info){
 	echo "<tr>";
	echo "<td>".$info['date']."</td>";
 	echo "<td>".$info['name']."</td>";
 	echo "<td>".$info['notes']."</td>";
 	echo "</tr>";
 }
 echo "</table>";

 function get_data($stu){
 	$db = get_database_connection();
     $statement = $db->prepare("SELECT * FROM late WHERE name LIKE CONCAT('%',:stu,'%')");
     $statement->bindValue(":stu", $stu);
     $statement->execute();
 	$db= null;
 	return $statement->fetchAll();
 }
  ?>