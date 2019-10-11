<?PHP
session_start();
include 'functions.php';
teacher_only();
password_protect();
$db = get_database_connection();
?>
<html>
<head>
<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.action="addabsentee.php";
        formObject.submit();
    }
    function send()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>
<link rel="stylesheet" type="text/css" href="css.css" />
</head>
<body bgcolor=#CCCCCC>
    <h1 align=center>Add Absentee</h1>
    <table align=center><td>
            <form name='theForm' method='post' action='submit.php'>
                <?php
                if (isset($_POST['date'])) {
                    echo "Date:<input type=text name=date value='" . $_POST['date'] . "'><br><br>";
                } else {
                    echo "Date:<input type=text name=date value='" . date('Y-m-d') . "'><br><br>";
                }
                $i = 0;
                do {
                    $i = $i + 1;
                    $grade = "grade" . $i;
                    $absentee = "absentee" . $i;
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

                        echo "Student:<select name='" . $absentee . "' onchange='refresh()'><option value=0>Select Student</option>";

                        while ($row = $statement->fetch()) {
                            echo "<option value='" . $row['lastname'] . ", " . $row['firstname'] . "' ";
                            if (isset($_POST[$absentee]) && $_POST[$absentee] == $row['lastname'] . ", " . $row['firstname'])
                                echo "selected";
                            echo ">" . $row['lastname'] . ", " . $row['firstname'] . "</option>";
                        }
                        echo "</select><br>";
                    }
                }while (isset($_POST[$absentee]));
              ?>
                <br><br>
                <input type='button' value='Submit' onclick='send()'>
                <br><br><br>

                <a href=index.php>Home</a>
            </form>
            <a href=logout.php>Logout</a>
	    </td></table>
<?php   $db = null;
?>
    </body>
</html>
