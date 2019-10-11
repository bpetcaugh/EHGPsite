<?php
session_start();
include 'functions.php';
att_admin_only();
password_protect();
//Student Infractions Displayed for Dean of Students of this webpage

$db = get_database_connection();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $statement = $db->prepare("SELECT * FROM student WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    $row1 = $statement->fetch();
    if ($_SESSION['username'] == $row1['username'] && $_SESSION['password'] == $row1['password']) {
        $sid = $row1['id'];
        $firstname = $row1['firstname'];
        $lastname = $row1['lastname'];
    }
}
?>
<html>
    <head>
        <script type='text/javascript'>
            function refresh(){
                var formObject = document.forms['theForm'];
                formObject.action="viewStudentInfractions.php";
                formObject.submit();
            }

            function send(){
                var formObject = document.forms['theForm'];
                formObject.submit();
            }
        </script>

        <link rel="stylesheet" type="text/css" href="css.css" />
        <link rel ="stylesheet" type ="text/css" href ="table.css" />

        <title>Student's Infractions</title>
    </head>
<?php
echo "<body bgcolor=#CCCCCC>";
if (check_logged_in ()) {
    $isTeacher = $_SESSION['isTeacher'];
    echo "<center><h1>Welcome " . $_SESSION['name'] . "</h1></center>";
}
echo "<center><h2>View Student's Lates, Absentees, and Infractions</h2></center>";
echo "<center><h3>View student's information below.</h3></center>";
echo "<br/>";

echo "<center><a href=index.php>EHGP Home</a>&nbsp&nbsp<a href=logout.php>Logout</a></center><br />";
echo "<center><a href=http://www.holyghostprep.org>Holy Ghost Prep Home Page</a></center>";
echo "<hr>";

//================
//Selecting students drop down menu
echo "<table align=center><td>";
echo "<form name='theForm' method='post' action='viewStudentInfractions.php'>";
$grade = 9;
if (isset($_GET['grade']))
    $grade = $_GET['grade'];

$statement = $db->prepare("SELECT * FROM student WHERE grade=:grade ORDER BY lastname");
$statement->bindValue(":grade", $grade);
$statement->execute();

$result = $statement->fetch();

do {
    $grade = "grade";
    echo "Grade:<select name='" . $grade . "' onchange='refresh()'>";
    echo "<option value=0>Select Grade</option>";
    echo "<option value=9 ";
    if (isset($_POST[$grade]) && $_POST[$grade] == 9)
        echo "selected";
    echo ">Grade 9</option>";
    echo "<option value=10 ";
    if (isset($_POST[$grade]) && $_POST[$grade] == 10)
        echo "selected";
    echo ">Grade 10</option>";
    echo "<option value=11 ";
    if (isset($_POST[$grade]) && $_POST[$grade] == 11)
        echo "selected";
    echo ">Grade 11</option>";
    echo "<option value=12 ";
    if (isset($_POST[$grade]) && $_POST[$grade] == 12)
        echo "selected";
    echo ">Grade 12</option>";
    echo "</select>";

    if (isset($_POST[$grade])) {
        $statement = $db->prepare("SELECT * FROM student WHERE grade=:grade ORDER BY lastname");
        $statement->bindValue(":grade", $_POST[$grade]);
        $statement->execute();

        echo "Student:<select name='student' onchange='submit()'>";
        echo "<option value=0>Select Student</option>";

        while ($row = $statement->fetch()) {
            echo "<option value='" . $row['lastname'] . ", " . $row['firstname'] . "' ";
            if (isset($_POST[student]) && $_POST[student] == $row['lastname'] . ", " . $row['firstname'])
                echo "selected";
            echo ">" . $row['lastname'] . ", " . $row['firstname'] . "</option>";
        }
        echo "</select>";
    }
}while (isset($_POST[student]) & $_POST[student] != 0);

echo "</form> </td></table>";


$tempStudentName = $_POST[student]; //Assign $tempStudentName to the student selected
$grade2 = $_POST['grade'];
if (isset($tempStudentName)) {

    echo "<center><b>Now Viewing:<br><i>" . $tempStudentName . "</i></b></center><br>";
    echo "<hr>";
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Lates displayed here
    echo "<center><b> Lates.</b></center><br/>";
    $query = $db->prepare("SELECT * FROM late WHERE name LIKE :nm AND grade LIKE :gr2");
    $query->bindValue(":nm", $tempStudentName);
    $query->bindValue(":gr", $grade2);
    $query->execute();
    echo "<table align=center border=1><tr><th>Teacher</th><th>Period</th><th>Minutes Late</th><th>Date</th></tr>";
    while ($row = $query->fetch()) {
        $tempRowName = $row['name'];
        if (strcmp($tempStudentName, $tempRowName) == 0) {
            echo "<tr><td>" . $row['teacher'] . "</td><td>" . $row['period'] . "</td><td>" . $row['minutes'] . "</td><td>" . $row['date'] . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    echo "<hr>";
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Absences displayed here
    echo "<center><b>Absences</b></center><br/>";
    $query = $db->prepare("SELECT * FROM absentee WHERE name LIKE :nm AND grade LIKE :gr2");
    $query->bindValue(":nm", $tempStudentName);
    $query->bindValue(":gr", $grade2);
    $query->execute();
    echo "<table align=center border=1><tr><th>Teacher</th><th>Notes</th><th>Date</th></tr>";
    while ($row = $query->fetch()) {
        $tempRowName = $row['name'];
        if (strcmp($tempStudentName, $tempRowName) == 0) {
            echo "<tr><td>" . $row['teacher'] . "</td><td>" . $row['notes'] . "</td><td>" . $row['date'] . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    echo "<hr>";
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Dress code violations displayed here
    echo "<center><b>Dress Code Violations.</b></center><br/>";
    $query = $db->prepare("SELECT * FROM dress WHERE name LIKE :nm AND grade LIKE :gr2");
    $query->bindValue(":nm", $tempStudentName);
    $query->bindValue(":gr", $grade2);
    $query->execute();
    echo "<table align=center border=1><tr><th>Violation</th><th>Teacher</th><th>Notes</th><th>Date</th></tr>";
    while ($row = $query->fetch()) {
        $tempRowName = $row['name'];
        if (strcmp($tempStudentName, $tempRowName) == 0) {
            //echo "i got here<br/>";
            echo "<td>" . $row['violation'] . "</td><td>" . $row['teacher'] . "</td><td>" . $row['notes'] . "</td><td>" . $row['date'] . "</td>";
            echo "</tr>";
        }
    }

    echo "</table>";
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
}
$db = null;
?>

</body>
</html>