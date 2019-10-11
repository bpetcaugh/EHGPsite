<?php
session_start();
include 'functions.php';
teacher_only();
password_protect("login.php?dress=2");
$db = get_database_connection();
if (isset($_GET['remove'])) {
    $query = $db->prepare("DELETE FROM dress WHERE id=:id AND teacher=:teacher");
    $query->bindValue(":id", $_GET['remove']);
    $query->bindValue(":teacher", $_SESSION['name']);
    $query->execute();

    if ($query->rowCount() != 1)
        die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    else
        redirect("viewdress.php?date=" . $_GET['date']);
}
if ((isset($_GET['remove'])) && (is_att_admin($_SESSION['username'],$_SESSION['password']))){
    $query = $db->prepare("DELETE FROM dress WHERE id=:id");
    $query->bindValue(":id", $_GET['remove']);
    $query->execute();

    if ($query->rowCount() != 1)
        die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    else
        redirect("viewdress.php?date=" . $_GET['date']);
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
<h1 align="center">Dress Code Violations</h1><br>
    <?php
    $date = date('Y-m-d');
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
    }

    echo "<h2 align=center>" . date('l', strtotime($date)) . "<br>" . $date . "</h2><br><center><form name='theForm' action='viewdress.php' method='get'><select name='date' onchange='refresh()'>";

    $rows = $db->query("SELECT * FROM dress ORDER BY date");
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
    echo "</select>&nbsp&nbsp<a href=index.php>Home</a>&nbsp&nbsp<a href=logout.php>Logout</a></center><br><hr>";

    $query = $db->prepare("SELECT * FROM dress WHERE date=:date ORDER BY grade, name");
    $query->bindValue(":date", $date);
    $query->execute();

    echo "<table align=center border=1><tr><th>Student</th><th>Grade</th><th>Violation</th><th>Teacher</th><th>Notes</th></tr>";
    while ($row = $query->fetch()) {
        echo "<td>" . $row['name'] . "</td><td>" . $row['grade'] . "</td><td>" . $row['violation'] . "</td><td>" . $row['teacher'] . "</td><td>" . $row['notes'] . "</td>";
        if (($_SESSION['name'] == $row['teacher']) || (is_att_admin($_SESSION['username'], $_SESSION['password'])))
            echo "<td><a href=viewdress.php?remove=" . $row['id'] . "&date=" . $date . ">Remove</a></td>";
        echo "</tr>";
    }
    echo "</table>";

    if ($query->rowCount() == 0)
        echo "<h3 align=center> No Dress Code Violations Today.</h3>";
$db = null;    
?>
</body>
</html>