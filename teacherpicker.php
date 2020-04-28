<html>
<head>
	<script>
	function refresh(){
		var formObject = document.forms['theForm'];
		formObject.submit();
	}
	</script>
</head>
</html>
<?php

//Creates a dropdown menu of teachers, with the value of each of them set to their id numbers. Uses $page as the action of the dropdown menu.
function teacherSelector($page){
	$teacher = '';
	
	//If teacher already has a value, set it to that value.
	if (isset($_GET['teacher'])) {
		$teacher = $_GET['teacher'];
	}
	
	//Echos out a dropdown menu That lets you choose a teacher. Uses the php page provided as its action when selected. No teachers are in it yet.
	echo"<form name='theForm' action='$page' method='get'>
	<select name='teacher' onchange='refresh()'>
	<option value = ' '>Choose a teacher</option>";

	$rows = get_teachers();
	
	//Echos out the teachers to be in the dropdown menu from the teacher table. Each teachers value is their id number.
	//The $_GET['teacher] variable will be assigned the id number of the teacher when one is selected.
	foreach ($rows as $row) {
		$name = $row['name'];
		$id = $row['id'];
		echo "<option value=" . $id;
		//Makes sure same teacher is selected on reload of page.
		if ($id == $teacher) {
			echo " selected=selected";
		}
		echo ">" . $name . "</option>";
	}
	
	echo "</select></form>";
	
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
?>