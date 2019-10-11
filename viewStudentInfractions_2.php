<?php
//done by ? Raiker?  fix attempt by mmm 7-31-15
session_start();
include 'functions_2.php';
include 'includeInc_2.php';
password_protect();
att_admin_only();
dohtml_header("View Student Infractions");

//Student Infractions Displayed for Dean of Students on this webpage

//$db = get_database_connection(); moved from here

//for student to view his own infractions?
/*if (isset($_SESSION['username'])) {
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
} */


?>
    <head>
        <script type='text/javascript'>
            function refresh(){
                var formObject = document.forms['theForm'];
                formObject.action="viewStudentInfractions_2.php";
                formObject.submit();
            }

            function send(){
                var formObject = document.forms['theForm'];
                formObject.submit();
            }
        </script>

        <link rel="stylesheet" type="text/css" href="css_2.css" />
        <link rel ="stylesheet" type ="text/css" href ="table_2.css" />

        <!--<title> css above missing Student's Infractions</title>//-->
    </head>
<?php
if (check_logged_in ()) {
    $isTeacher = $_SESSION['isTeacher'];
    echo "<center><h3>Welcome " . $_SESSION['name'] . "</h3></center>";
$db = get_database_connection();//} shouldn't be here to end the logged in check
echo "<center><h4>View Student's Lates, Absentees, and Infractions below.";
//echo "View student's information below.</h4></center>";
echo "<br/>";
endAndBeginTable();
//tableRowSpace();
tableRowSpace();
endAndBeginTable();
echo "<table class='centered'>";
homeLogout();
echo "</table>";

echo "<hr />";

//================
//Selecting students drop down menu
echo "<table align='center'><td>";
echo "<form name='theForm' method='post' action='viewStudentInfractions_2.php'>";
$grade = 9;
if (isset($_GET['grade']))
    $grade = $_GET['grade'];

$statement2 = $db->prepare("SELECT * FROM student WHERE grade=:grade ORDER BY lastname");
$statement2->bindValue(":grade", $grade);
$statement2->execute();

$result = $statement2->fetch();

do {
    $grade = "grade";
	if (isset($_POST['student'])){
    	$student = $_POST['student'];
	}// else {
	//	$_POST['student'] = 0;//??
	//}
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
        $statement3 = $db->prepare("SELECT * FROM student WHERE grade=:grade ORDER BY lastname");
        $statement3->bindValue(":grade", $_POST[$grade]);
        $statement3->execute();

        echo "Student:<select name='student' onchange='submit()'>";
        echo "<option value=0>Select Student</option>";

        while ($row = $statement3->fetch()) {
            echo "<option value='" . $row['lastname'] . ", ". $row['firstname'] . "' ";
            if (isset($_POST[student]) && $_POST[student] == $row['lastname'] . ", " . $row['firstname'])
                echo "selected";
            echo ">" . $row['lastname'] . ", " . $row['firstname'] . "</option>";
        }
        echo "</select>";
    }
}while (isset($_POST[student]) && $_POST[student] != 0);

echo "</form> </td></table>";


$tempStudentName = $_POST[student]; //Assign $tempStudentName to the student selected
$grade2 = $_POST['grade'];
if (isset($tempStudentName)) {

    echo "<center><br/><b>Now Viewing:<br /><i>" . $tempStudentName . "</i></b></center><br />";
}    
echo "<hr />";
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Lates displayed here
    echo "<center><b> Lates.</b></center><br/>";
    $query = $db->prepare("SELECT * FROM late WHERE name LIKE :nm AND grade LIKE :gr2");
    $query->bindValue(":nm", $tempStudentName);
    $query->bindValue(":gr2", $grade2);
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
    echo "<hr />";
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Absences displayed here
    echo "<center><b>Absences</b></center><br/>";
    $query2 = $db->prepare("SELECT * FROM absentee WHERE name LIKE :nm AND grade LIKE :gr2");
    $query2->bindValue(":nm", $tempStudentName);
    $query2->bindValue(":gr2", $grade2);
    $query2->execute();
    echo "<table align=center border=1><tr><th>Teacher</th><th>Notes</th><th>Date</th></tr>";
    while ($row = $query2->fetch()) {
        $tempRowName = $row['name'];
        if (strcmp($tempStudentName, $tempRowName) == 0) {
            echo "<tr><td>" . $row['teacher'] . "</td><td>" . $row['notes'] . "</td><td>" . $row['date'] . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    echo "<hr />";
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Dress code violations displayed here
    echo "<center><b>Dress Code Violations.</b></center><br/>";
    $query3 = $db->prepare("SELECT * FROM dress WHERE name LIKE :nm AND grade LIKE :gr2");
    $query3->bindValue(":nm", $tempStudentName);
    $query3->bindValue(":gr2", $grade2);
    $query3->execute();
    echo "<table align=center border=1><tr><th>Violation</th><th>Teacher</th><th>Notes</th><th>Date</th></tr>";
    while ($row = $query3->fetch()) {
        $tempRowName = $row['name'];
        if (strcmp($tempStudentName, $tempRowName) == 0) {
            //echo "i got here<br/>";
            echo "<td>" . $row['violation'] . "</td><td>" . $row['teacher'] . "</td><td>" . $row['notes'] . "</td><td>" . $row['date'] . "</td>";
            echo "</tr>";
        }
    }

    echo "</table>";
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

}//check logged in
$db = null;
dohtml_footer(true);

?>