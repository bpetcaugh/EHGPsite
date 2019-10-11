<?php
session_start();
include 'functions.php';
$db = get_database_connection();

if (isset($_GET['remove']) && check_logged_in()) {
    $query = $db->prepare("DELETE FROM announcements WHERE id=:id AND teacher=:teacher");
    $query->bindValue(":id", $_GET['remove']);
    $query->bindValue(":teacher", $_SESSION['name']);
    $query->execute();

    if ($query->rowCount() != 1)
        die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    else
        redirect("readannouncements.php?date=" . $_GET['date']);
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
	<h1 align="center">Daily Announcements</h1>
    <?php
    $date = date('Y-m-d');
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
    }
    echo "<h2 align=center>" . date('l', strtotime($date)) . "<br>" . $date . "</h2>";
    echo "<center><a href=http://www.holyghostprep.org>Holy Ghost Prep Home Page</a></center>";

    echo"<center><form name='theForm' action='readannouncements.php' method='get'><select name='date' onchange='refresh()'>";

    $rows = $db->query("SELECT * FROM announcements ORDER BY date");
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
    echo "</select>&nbsp&nbsp<a href=index.php>Home</a></center><br><hr>";

    $query = $db->prepare("SELECT * FROM announcements WHERE date=:date ORDER BY code");
    $query->bindValue(":date", $date);
    $query->execute();

    while ($row = $query->fetch()) {
        echo "<b>From: " . $row['teacher'] . "<br>";
        echo "To: " . $row['grade'] . "</b><br>";
        echo nl2br($row['announcement']) . "<br>";
        if (isset($_SESSION['name']) && ($_SESSION['name'] == $row['teacher']))
            echo "<a href=readannouncements.php?remove=" . $row['id'] . "&date=" . $date . ">Remove This Announcement</a></td>";
        echo "<hr>";
    }

    if ($query->rowCount() == 0)
        echo "<h3 align=center>No Announcements Today.</h3>";


    $db = null;
    ?>
</body>
</html>