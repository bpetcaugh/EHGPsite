<!--
Usage:
#include(dataselectorlate.php);
#$pageName = basename($_SERVER[PHP_SELF]); (php)
#dateSelectorLate($pageName);
#$date = $_GET['date'];
-->
<head>
	<script>
	function refresh(){
		var formObject = document.forms['theForm'];
		formObject.submit();
	}
	</script>
</head>
<?php
function dateSelectorLate($page){
	$date = date('Y-m-d');
	if (isset($_GET['date'])) {
		$date = $_GET['date'];
	}
	echo"<form name='theForm' action='$page' method='get'>
	<select name='date' onchange='refresh()'>";

	$rows = get_dates();
	$temp = 0;
	foreach (array_reverse($rows) as $row) {
		if ($temp != $row['date']) { //remove duplicate dates
			$temp = $row['date'];
			echo "<option value=" . $temp;
			if ($temp == $date) {
				echo " selected=selected";
			}
			echo ">" . $temp . "</option>";
		}
	}
	echo "</select></form>";
}
function get_dates(){
	$db = get_database_connection();
    $statement = $db->prepare("SELECT * FROM late ORDER BY date");
    $statement->execute();
	$db= null;
	return $statement->fetchAll();
}
?>