<?php
	//Edited by Fred
	session_start();
	include 'functions_2.php';
	teacher_only();
	password_protect();
	$stu= $_GET['stu'];
	include 'includeInc_2.php';
	dohtml_header("Student Absentees");
 ?>

 <body>
 <h1>Results for "<?php echo $stu; ?>"</h1>
 <style>
 form{display:inline}
 body {text-align: center;}
 table {	border-width:1px;
 		border-bottom-color: #999;
 		margin: 0 auto;
 }
 #return{
	margin-left: auto;
	margin-right: auto;
 }
 td {padding: 2px 10px;}
 </style>
 <body>

 <?php 
 $data= get_data($stu);
 if (isset($_GET['date'])) {
     $prevPage= "editabsentee_2.php?date=".$_GET['date'];
 }else{
     $prevPage= "editabsentee_2.php";
 }
 
 echo "<table class='centered' border='1'><tr class='centered'><td class='centered'><b>Date</b></td><td class='centered'><b>Name</b></td><td class='centered'><b>Note</b></td></tr>";
 foreach($data as $info){
 	echo "<tr>";
	echo "<td>".$info['date']."</td>";
 	echo "<td>".$info['name']."</td>";
 	echo "<td>".$info['notes']."</td>";
 	echo "</tr>";
 }
 
 echo "<tr class='centered><td class='centered><a id='return' href='$prevPage'>Back to Absentee List</a></td></tr>";
 echo "</table>";
 
 function get_data($stu){
 	$db = get_database_connection();
     $statement = $db->prepare("SELECT * FROM absentee WHERE name LIKE CONCAT('%',:stu,'%')");
     $statement->bindValue(":stu", $stu);
     $statement->execute();
 	$db= null;
 	return $statement->fetchAll();
 }
  ?>
<table class="centered">
<?php
tableRowSpace();
homeLogout();
?>
</table>
<?php 
dohtml_footer(true);
?>