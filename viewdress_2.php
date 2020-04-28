<?php
//edited by Vincent Pillinger
    //fixed ATT admin not working - May 14, 2013
session_start();
include 'functions_2.php';
teacher_only();
password_protect("login_2.php?dress=2");
$db = get_database_connection();
if ((isset($_GET['remove'])) && (is_att_admin($_SESSION['username'], $_SESSION['password']))) {
    $query = $db->prepare("DELETE FROM dress WHERE id=:id");
    $query->bindValue(":id", $_GET['remove']);
    $query->execute();

    if ($query->rowCount() != 1)
        die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    else
        redirect("viewdress_2.php?date=" . $_GET['date']);
}
if (isset($_GET['remove'])) {
    $query = $db->prepare("DELETE FROM dress WHERE id=:id AND teacher=:teacher");
    $query->bindValue(":id", $_GET['remove']);
    $query->bindValue(":teacher", $_SESSION['name']);
    $query->execute();

    if ($query->rowCount() != 1)
        die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    else
        redirect("viewdress_2.php?date=" . $_GET['date']);
}
include 'includeInc_2.php';
dohtml_header("Dress Code Violations");
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
echo "<form name='theForm' action='viewdress_2.php' method='get'>";
echo "<table class='centered'>";
homeLogout();
echo "</table><table class='centered'><tr><td><h2>" . date('l', strtotime($date)) . "</br>" . $date . "</h2></br>
        <select name='date' onchange='refresh()'>";
$rows = $db->query("SELECT * FROM dress ORDER BY date DESC");
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
echo "</select>";

$query = $db->prepare("SELECT * FROM dress WHERE date=:date ORDER BY grade, name");
$query->bindValue(":date", $date);
$query->execute();

echo "</table><table class='centered' border=1><tr><th>Student</th><th>Grade</th><th>Violation</th><th>Teacher</th><th>Notes</th></tr>";
while ($row = $query->fetch()) {
    echo "<td>" . $row['name'] . "</td><td>" . $row['grade'] . "</td><td>" . $row['violation'] . "</td><td>" . $row['teacher'] . "</td><td>" . $row['notes'] . "</td>";
    if (($_SESSION['name'] == $row['teacher']) || (is_att_admin($_SESSION['username'], $_SESSION['password'])))
        echo "<td><a href=viewdress_2.php?remove=" . $row['id'] . "&date=" . $date . ">Remove</a></td>";
    echo "</tr>";
}
echo "</table>";

if ($query->rowCount() == 0)
    echo "<h3 class='centered'> No Dress Code Violations Today.</h3>";
$db = null;
dohtml_footer(true);
?>