<?php

//Edited by Vincent Pillinger
session_start();
include 'functions_2.php';

password_protect();

$db = get_database_connection();

if (isset($_GET['remove'])) {
    $query = $db->prepare("DELETE FROM absentee WHERE id=:id AND teacher=:teacher");
    $query->bindValue(":id", $_GET['remove']);
    $query->bindValue(":teacher", $_SESSION['name']);
    $query->execute();

    if ($query->rowCount() != 1)
        die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    else
        redirect("viewabsentee_2.php?date=" . $_GET['date']);
}
include 'includeInc_2.php';
dohtml_header("Absentees");
?>


<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>
<?php

$date = date('Y-m-d');
if (isset($_GET['date'])) {
    $date = $_GET['date'];
}
//Table containing all header information for the Data containing table below
echo "<table class='centered'>";
homeLogout();
echo "<tr class='centered'><td>" . date('l', strtotime($date)) . "</td></tr><tr><td>" . $date . "</td></tr>";
//centerText(date('l', strtotime($date)));
//centerText($date); 
//echo "</table><table class='centered' border=1><tr class='centeredbutton'><td class='centered'><form name='theForm' action='viewabsentee_2.php' method='get'><select name='date' onchange='refresh()'>";
echo "</table><form name='theForm' action='viewabsentee_2.php' method='get'><center><select name='date' onchange='refresh()'>";
$rows = $db->query("SELECT * FROM absentee ORDER BY date DESC");
$temp = 0;
echo "<option value=''></option>";
foreach ($rows as $row) {
    if ($temp != $row['date']) {
        $temp = $row['date'];
        echo "<option value=" . $temp;
        if ($temp == $date) {
            echo " selected=selected";
        }
        echo ">" . $temp . "</option>";
    }
}

echo "</select></center>";

$query = $db->prepare("SELECT * FROM absentee WHERE date=:date ORDER BY grade, name");
$query->bindValue(":date", $date);
$query->execute();
echo "<table class='centered' border='1'><tr><th>Student</th><th>Grade</th><th>Teacher</th><th>Notes</th></tr>";
while ($row = $query->fetch()) {
    echo "<tr><td>" . $row['name'] . "</td><td>" . $row['grade'] . "</td><td>" . $row['teacher'] . "</td><td>" . $row['notes'] . "</td>";
    if ($_SESSION['name'] == $row['teacher'])
        echo "<td><a href=viewabsentee_2.php?remove=" . $row['id'] . "&date=" . $date . ">Remove</a></td>";
    echo "</tr>";
}
echo "</table>";
if ($query->rowCount() == 0)
    echo "<h3 class='centered'> No Absentees Today.</h3>";

$db = null;
dohtml_footer(true);
?>
