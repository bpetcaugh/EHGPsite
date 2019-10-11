<?php
session_start();
include 'functions.php';
teacher_only();
password_protect("login.php?lockdown=2");
$db = get_database_connection();

if (isset($_GET['remove'])) {
    $query = $db->prepare("DELETE FROM lockdown WHERE id=:id AND teacher=:teacher");
    $query->bindValue(":id", $_GET['remove']);
    $query->bindValue(":teacher", $_SESSION['name']);
    $query->execute();

    if ($query->rowCount() != 1)
        die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    else
        redirect("viewlockdown.php?date=" . $_GET['date']);
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
<h1 align="center">Lockdowns</h1><br>
    <?php
    $date = date('Y-m-d');
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
    }

    echo "<h2 align=center>" . date('l', strtotime($date)) . "<br>" . $date . "</h2><br><center>
        <form name='theForm' action='viewlockdown.php' method='get'><select name='date' onchange='refresh()'>";

    $rows = $db->query("SELECT * FROM lockdown ORDER BY date");
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
    echo "</select>&nbsp&nbsp<a href=index.php>Home</a>&nbsp&nbsp<a href=logout.php>Logout</a><br><hr></center>";

    $lockdownQuery = $db->prepare("SELECT * FROM lockdown WHERE date=:date ORDER BY grade, name");
    $lockdownQuery->bindValue(":date", $date);
    $lockdownQuery->execute();
    
    //TODO combine the query
    if ($lockdownQuery->rowCount() != 0) {
        if (is_admin($_SESSION['username'], $_SESSION['password'])) {
            $studentQuery = $db->query("SELECT * FROM student ORDER BY grade, lastname");
            echo "<center>These are the students that are missing.<br><br></center><table align=center border=1><tr><th>Name</th><th>Grade</th></tr>";
            while ($student = $studentQuery->fetch()) {
                $studentName = $student['lastname'] . ", " . $student['firstname'];
                $missingQuery = $db->prepare("SELECT * FROM lockdown WHERE date=:date AND name=:name");
                $missingQuery->bindValue(":date", $date);
                $missingQuery->bindValue(":name", $studentName);
                $missingQuery->execute();
                
                if ($missingQuery->rowCount() == 0)
                    echo "<tr><td>" . $student['lastname'] . ", " . $student['firstname'] . "</td><td>" . $student['grade'] . "</td></tr>";
            }
            echo "</table><br><br>";

            echo "<center>These are the teachers that are missing.<br><br></center><table align=center border=1><tr><th>Name</th></tr>";
            $teacherQuery = $db->query("SELECT * FROM teacher ORDER BY name");
            while ($teacher = $teacherQuery->fetch()) {
                $missingQuery = $db->prepare("SELECT * FROM lockdown WHERE date=:date AND name=:teacher");
                $missingQuery->bindValue(":date", $date);
                $missingQuery->bindValue(":teacher", $teacher['name']);
                $missingQuery->execute();
                
                if ($missingQuery->rowCount() == 0)
                    echo "<tr><td>" . $teacher['name'] . "</td></tr>";
            }
        }
        else {
            $teacherQuery = $db->prepare("SELECT * FROM lockdown WHERE date=:date AND teacher=:teacher ORDER BY grade, name");
            $teacherQuery->bindValue(":date", $date);
            $teacherQuery->bindValue(":teacher", $_SESSION['name']);
            $teacherQuery->execute();
            
            echo "<center>These are the students and faculty that are entered.<br><br></center><table align=center border=1><tr><th>Name</th><th>Grade</th><th>Teacher</th><th>Notes</th></tr>";
            while ($row = $teacherQuery->fetch()) {
                echo "<tr><td>" . $row['name'] . "</td><td>" . $row['grade'] . "</td><td>" . $row['teacher'] . "</td><td>" . "</td>";
                if ($_SESSION['name'] == $row['teacher'])
                    echo "<td><a href=viewlockdown.php?remove=" . $row['id'] . "&date=" . $date . ">Remove</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    
    if ($lockdownQuery->rowCount() == 0)
        echo "<h3 align=center> No lockdowns Today.</h3>";
    $db = null;
	?>
</body>
</html>