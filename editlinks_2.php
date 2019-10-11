<?php
session_start();
include 'functions_2.php';
teacher_only();
password_protect();

$db = get_database_connection();

if (isset($_GET['remove'])) {
    $query = $db->prepare("DELETE FROM links WHERE id=:id");
    $query->bindValue(":id", $_GET['remove']);
    $query->execute();

    if ($query->rowCount() != 1)
        die("Something went wrong. Please report this incident to the webmaster.");
    else
        redirect("editlinks_2.php" . $_GET['date']);
}
include 'includeInc_2.php';
dohtml_header("Edit Links");
?>


<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>
<?php

//Table containing all header information for the Data containing table below
echo "<table class='centered'>";
homeLogout();
echo "</table><form name='theForm' action='editlinks_2.php' method='get'>";
echo "<br>";

$query = $db->prepare("SELECT * FROM links ORDER BY grade");
$query->execute();

echo "<table class='centered' border='1'><tr><th>Text</th><th>Link</th><th>Grade</th><th>Options</th></tr>";
while ($row = $query->fetch()) {
    echo "<tr><td>" . $row['text'] . "</td><td style='word-wrap: break-word;'><a href='" . $row['link'] . "' target=_blank>" . $row['link'] . "</a></td><td>";
	switch($row['grade']){
		case 1:
			echo "All Grades";
			break;
		case 2:
			echo "9th and 10th";
			break;
		case 3:
			echo "11th and 12th";
			break;
		case 9:
			echo "9th";
			break;
		case 10:
			echo "10th";
			break;
		case 11:
			echo "11th";
			break;
		case 12:
			echo "12th";
			break;
	}		
	echo "</td><td><a href=editlinks_2.php?remove=" . $row['id'] . ">Remove</a></td>";
    echo "</tr>";
}
echo "</table>";
if ($query->rowCount() == 0)
    echo "<h3 class='centered'>No Links</h3>";
echo "</form>";

echo "<br>";
echo "<table align=center><form action=submit_2.php method=post>";
echo "<tr><td>Text:</td><td><input type=text name=text></td></tr>";
echo "<tr><td>Link:</td><td><input type=text name=link value=http://></td></tr>";
echo "<tr><td>Grade:</td><td><select name=grade>";
echo "<option value=1>All Grades</option>";
echo "<option value=2>9th and 10th</option>";
echo "<option value=3>11th and 12th</option>";
echo "<option value=9>9th</option>";
echo "<option value=10>10th</option>";
echo "<option value=11>11th</option>";
echo "<option value=12>12th</option></select></td></tr>";
echo "<tr><td colspan=2><input type=submit value='Add Link'></td></tr>";

echo "</form></table>";
$db = null;
dohtml_footer(true);
?>