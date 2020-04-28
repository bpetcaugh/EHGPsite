<?PHP
session_start();
include 'functions.php';
teacher_only();
password_protect("login.php?test=1");

$db = get_database_connection();

if (isset($_GET['remove'])) {
    $query = $db->prepare("DELETE FROM test WHERE id=:id AND teacher=:teacher");
    $query->bindValue(":id", $_GET['remove']);
    $query->bindValue(":teacher", $_SESSION['name']);
    $query->execute();

    if ($query->rowCount() != 1)
        die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    else
        redirect("test.php?date=" . $_GET['date']);
}
?>
<html>
<head>
<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>
<link rel="stylesheet" type="text/css" href="css.css" />
</head>
<body bgcolor=#CCCCCC>
<h1 align="center">Test Calendar</h1><br>
    <?php

    if (isset($_GET['mydate']))
        $date = $_GET['mydate'];
    else if (isset($_GET['date']))
        $date = $_GET['date'];
    else {
        //TODO fix this up
        $date = date('Y-m-d');
        $rows = $db->query("SELECT * FROM calendar ORDER BY date");
        while (($row = $rows->fetch()) && (strtotime($date) > strtotime($row['date']))) {
            
        }
        $date = $row['date'];
    }

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

    $query = $db->prepare("SELECT * FROM calendar WHERE date=:date");
    $query->bindValue(":date", $date);
    $query->execute();
    
    $row = $query->fetch();
    echo "<h2 align=center>" . $date . "<br>" . $row['letter'] . " Day</h2><br><center><form name='theForm' action=test.php method='get'><select name='mydate' onchange='refresh()'>";

    $query = $db->query("SELECT * FROM calendar ORDER BY date");
    while ($row = $query->fetch()) {
        echo "<option value=" . $row['date'];
        if ($row['date'] == $date) {
            echo " selected=selected";
        }
        echo ">" . $row['date'] . " " . $row['letter'] . " Day</option>";
    }
    echo "</select>&nbsp&nbsp<a href=index.php>Home</a>&nbsp&nbsp<a href=logout.php>Logout</a></center><hr></form>";


    $query = $db->prepare("SELECT * FROM test WHERE date=:date");
    $query->bindValue(":date", $date);
    $query->execute();
    echo "<table border=1 align=center><tr><th>Teacher</th><th>Grade</th><th>Class</th><th>Number</th></tr>";

    echo "<form action=test.php method='get'>";

    while ($row = $query->fetch()) {
        echo "<tr><td>" . $row['teacher'] . "</td><td>" . $row['grade'] . "</td><td>" . $row['subject'] . "</td><td>" . $row['number'] . "</td>";
        if ($_SESSION['name'] == $row['teacher'])
            echo "<td><a href=test.php?remove=" . $row['id'] . "&date=" . $date . ">Remove</a></td>";
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
    echo "</select></td><td><input type=text name=subject></td><td><input type=text name=number size=3></td>";
    echo "<td><input type=hidden name=date value=" . $date . "><input type='submit' name='addtest' value='Submit'></td></tr>";
    echo "</table>";
$db = null;	
    ?>
</body>
</html>
