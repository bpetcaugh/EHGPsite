<html>
<head>
	<script>
	function refresh(){
		var formObject = document.forms['theFormTS'];
		formObject.submit();
	}
	</script>
</head>
</html>
<?php

//Creates a dropdown menu of teachers, with the value of each of them set to their id numbers. Uses $page as the action of the dropdown menu.
function teachStuSelector($page){
	$teacher = '';
	$student = '';
	//If teacher already has a value, set it to that value.
	if (isset($_GET['teacher'])) {
		$teacher = $_GET['teacher'];
	}
	if (isset($_GET['student'])){
		$student = $_GET['student'];
	}
	
	//Echos out a dropdown menu That lets you choose a teacher. Uses the php page provided as its action when selected. No teachers are in it yet.
	echo"<form name='theFormTS' action='$page' method='get'>
	<span id='leftsel'><select name='teacher' onchange='refresh()'>
	<option value = ' '>Choose a teacher</option>";

	$rowsT = get_teachers();
	
	//Echos out the teachers to be in the dropdown menu from the teacher table. Each teachers value is their id number.
	//The $_GET['teacher] variable will be assigned the id number of the teacher when one is selected.
	foreach ($rowsT as $row) {
		$name = $row['name'];
		$id = $row['id'];
		echo "<option value=" . $id;
		//Makes sure same teacher is selected on reload of page.
		if ($id == $teacher) {
			echo " selected=selected";
		}
		echo ">" . $name . "</option>";
	}
	echo "</select></span>";
	
	//Create a dropdown for students.
	echo "<span id='rightsel'><select name='student' onchange='refresh()'>
	<option value = ' '>Choose a student</option>";

	$rowsS = get_students();
	
	foreach ($rowsS as $row) {
		$lastname = $row['lastname'];
		$firstname = $row['firstname'];
		$classnum = $row['classnum'];
		echo "<option value=" . $classnum;
		if ($classnum == $student) {
			echo " selected=selected";
		}
		echo ">" . $lastname .", ". $firstname . "</option>";
	}
	echo "</select></span>";
	echo "</form>";
	
	//Presumably, this is some of Liam's old test code.
	// foreach ($rows as $row) {
	// 	echo $row['name'];
	// }
}

//Gets the name and id rows from the teacher table of the database.
function get_teachers(){
	$db = get_database_connection();
    $statement = $db->prepare("SELECT name, id FROM teacher");
    $statement->execute();
	$db= null;
	return $statement->fetchAll();
}

function get_students(){
	$db = get_database_connection();
    $statement = $db->prepare("SELECT firstname,lastname,classnum FROM student");
    $statement->execute();
	$db= null;
	return $statement->fetchAll();
}
?>