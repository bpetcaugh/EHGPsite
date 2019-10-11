<script>
	//Edited for redesign by Fred Kummer
	function refresh(){
		var formObject = document.forms['theForm'];
		formObject.submit();
	}
</script>

<?php
function teacherSelector($page){
	$teacher = '';
	if (isset($_GET['teacher'])) {
		$teacher = $_GET['teacher'];
	}
	echo"<form name='theForm' action='$page' method='get'>
	<select name='teacher' onchange='refresh()'>
	<option value = ' '>Choose a teacher</option>";

	$rows = get_teachers();
	foreach ($rows as $row) {
		$name = $row['name'];
		$id = $row['seq'];
		if ($id>0) {
			echo "<option value=" . $id;
			if ($id == $teacher) {//mmm  adjustment to make teacher id coordinate to sequence id
				echo " selected=selected";
			}
			echo ">" . $name . "</option>";
		}
	}
	echo "</select></form>";
}
function get_teachers(){
	$db = get_database_connection();
    $statement = $db->prepare("SELECT name, id, seq FROM teacher ORDER BY seq");
    $statement->execute();
	$db= null;
	return $statement->fetchAll();
}
?>