<?php 
	session_start();
	include 'functions.php';
	teacher_only();
	password_protect();
	$stu= $_GET['stu'];
 ?>
 <!Doctype>
 <html>
 <head>
 <body bgcolor=#CCCCCC>
 <h1>Results for "<?php echo $stu; ?>"</h1>
 	<title>Student Lates</title>
 </head>
 <style>
 form{display:inline}
 body {text-align: center;}
 table {	border-width:1px;
 		border-bottom-color: #999;
 		margin: 0 auto;
 }
 td {padding: 2px 10px;}
 </style>
 <body>

 <?php 
 $data= get_data($stu);
 if (isset($_GET['date'])) {
     $prevPage= "editlate.php?date=".$_GET['date'];
 }else{
     $prevPage= "editlate.php";
 }
 
 echo "<table border='1'><tr><td align='center'><strong>Date</strong></td><td align='center'><strong>Name</strong></td><td align='center'><strong>Note</strong></td></tr>";
 foreach($data as $info){
 	echo "<tr>";
	echo "<td>".$info['date']."</td>";
 	echo "<td>".$info['name']."</td>";
 	echo "<td>".$info['notes']."</td>";
 	echo "</tr>";
 }
 echo "</table>";
 echo "<a href='$prevPage'>Back to Late List</a>";

 function get_data($stu){
 	$db = get_database_connection();
     $statement = $db->prepare("SELECT * FROM late WHERE name LIKE CONCAT('%',:stu,'%')");
     $statement->bindValue(":stu", $stu);
     $statement->execute();
 	$db= null;
 	return $statement->fetchAll();
 }
  ?>