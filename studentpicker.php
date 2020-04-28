<head>
	<script>
	function refresh(){
		var formObject = document.forms['theForm'];
		formObject.submit();
	}
	</script>
</head>
<?php
function studentSelector($page){
	$student = '';
	if (isset($_GET['student'])) {
		$student = $_GET['student'];
	}
	echo"<form name='theForm' action='$page' method='get'>
	<select name='student' onchange='refresh()'>
	<option value = ' '>Choose a student</option>";

	$rows = get_students();
	foreach ($rows as $row) {
		$lastname = $row['lastname'];
		$firstname = $row['firstname'];
		$classnum = $row['classnum'];
		echo "<option value=" . $classnum;
		if ($classnum == $student) {
			echo " selected=selected";
		}
		echo ">" . $lastname .", ". $firstname . "</option>";
	}
	echo "</select></form>";
	// foreach ($rows as $row) {
	// 	echo $row['name'];
	// }
}

function get_students(){
	$db = get_database_connection();
    $statement = $db->prepare("SELECT firstname,lastname,classnum FROM student ORDER BY lastname");
    $statement->execute();
	$db= null;
	return $statement->fetchAll();
}
?>