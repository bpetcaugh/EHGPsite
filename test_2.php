<?PHP

//edited by Vincent Pillinger
session_start();
include 'functions_2.php';
teacher_only();
password_protect("login_2.php?test=1");

$db = get_database_connection();

if (isset($_GET['remove'])) {
    $query = $db->prepare("DELETE FROM test WHERE id=:id AND teacher=:teacher");
    $query->bindValue(":id", $_GET['remove']);
    $query->bindValue(":teacher", $_SESSION['name']);
    $query->execute();

    if ($query->rowCount() != 1)
        die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    else
        redirect("test_2.php?date=" . $_GET['date']);
}
include 'includeInc_2.php';
dohtml_header("Test Calendar");
echo "<table class='centered'>";
homeLogout();
echo "</table>";

echo "<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>";

//echo "<h1>".$date."yo</h2>";

//be sure $date gets a value!!!
if (isset($_GET['mydate']))
    $date = $_GET['mydate'];
else if (isset($_GET['date']))
    $date = $_GET['date'];
else {
    $rows = $db->prepare("SELECT * FROM calendar ORDER BY date DESC");
    $rows->execute();
    if ($rows->rowCount() < 1){
         $date = date('Y-m-d');
    }
    else{
        $row = $rows->fetch();
        $date = $row['date'];
    }
 }

//insert recently added test
if (isset($_GET['addtest'])) {
    $query = $db->prepare("SELECT * FROM teacher WHERE id=:id");
    $query->bindValue(":id", $_SESSION['id']);
    $query->execute();

    $row = $query->fetch();
    if ($_GET['number'] && $_GET['subject']) {
        $query = $db->prepare("INSERT INTO test (teacher, date, number, subject, grade) VALUES (:teacher, :date, :number, :subject, :grade)");
        $query->bindValue(":teacher", $row['name']);
        $query->bindValue(":date", $_GET['date']);
        $query->bindValue(":number", $_GET['number']);
        $query->bindValue(":subject", $_GET['subject']);
        $query->bindValue(":grade", $_GET['grade']);
        $query->execute();
    }
}

//display date picker options
$query = $db->prepare("SELECT * FROM calendar WHERE date=:date");
$query->bindValue(":date", $date);
$query->execute();
$row = $query->fetch();

echo "<table class='centered'>";
echo "<form name='theForm' action='test_2.php' method='get'>";
echo "<tr><td><h3>" . $date . "</h3><h3>" . $row['letter'] . " Day</h3></td></tr>";
echo "<tr><td><select name='mydate' onchange='refresh()'>";

$query = $db->prepare("SELECT * FROM calendar ORDER BY date DESC");
$query->execute();
while ($row = $query->fetch()) {
    echo "<option value=" . $row['date'];
    if ($row['date'] == $date) {
        echo " selected=selected";
    }
    echo ">" . $row['date'] . " " . $row['letter'] . " Day</option>";
}
echo "</td></tr><tr></tr></form>";
tableRowSpace();
echo "</table>";


$query = $db->prepare("SELECT * FROM test WHERE date=:date");
$query->bindValue(":date", $date);
$query->execute();
echo "<table class='centered' border=1><tr><th>Teacher</th><th>Grade</th><th>Class</th><th>Number</th></tr>";

echo "<form action='test_2.php' method='get'>";

while ($row = $query->fetch()) {
    echo "<tr><td>" . $row['teacher'] . "</td><td>" . $row['grade'] . "</td><td>" . $row['subject'] . "</td><td>" . $row['number'] . "</td>";
    if ($_SESSION['name'] == $row['teacher'])
        echo "<td><a href=test_2.php?remove=" . $row['id'] . "&date=" . $date . ">Remove</a></td>";
    echo "</tr>";
}

echo "<tr><td>" . $_SESSION['name'] . "</td><td><select name='grade'>";
echo "<option value='Freshman'>Freshman</option>";
echo "<option value='Sophomore'>Sophomore</option>";
echo "<option value='Freshman-Sophomore'>Freshman-Sophomore</option>";
echo "<option value='Junior'>Junior</option>";
echo "<option value='Senior'>Senior</option>";
echo "<option value='Junior-Senior'>Junior-Senior</option>";
echo "<option value='All Grades'>All Grades</option>";
echo "<option value='Sophomore-Junior-Senior'>Sophomore-Junior-Senior</option>";
echo "<option value='Sophomore-Junior'>Sophomore-Junior</option>";
echo "<option value='Freshman-Sophomore-Junior'>Freshman-Sophomore-Junior</option>";
echo "</select></td><td><input type='text' name='subject'></td><td><input type='text' name='number' size='3'></td>";
echo "<td><input type=hidden name='date' value=" . $date . "><input type='submit' name='addtest' value='Submit'></td></tr>";
echo "</form></table>";
$db = null;
dohtml_footer(true);
?>

