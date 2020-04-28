<?PHP
session_start();
include 'functions.php';
teacher_only();
password_protect("login.php?lockdown=1");
$db = get_database_connection();
?>
<html>
<head>
<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.action="addlockdown.php";
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
    <h1 align=center>Add Lockdown</h1>
    <table align=center><td>Please enter all of the students that are locked in with you.  Hit Submit if you are by yourself.
            <form name='theForm' method='post' action='submit.php'>
                <input type=hidden value=1 name='isLockdown'>

                <?php
                if (isset($_POST['date'])) {
                    echo "Date:<input type=text name=date value='" . $_POST['date'] . "'><br><br>";
                } else {
                    echo "Date:<input type=text name=date value='" . date('Y-m-d') . "'><br><br>";
                }
                
                //puts dropdown menus on page
                $i = 0;
                do {
                    $i = $i + 1;
                    $grade = "grade" . $i;
                    $lockdown = "lockdown" . $i;
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
                        $query = $db->prepare("SELECT * FROM student WHERE grade=:grade ORDER BY lastname");
                        $query->bindValue(":grade", $_POST[$grade]);
                        $query->execute();

                        echo "Student:<select name='" . $lockdown . "' onchange='refresh()'><option value=0>Select Student</option>";

                        while ($row = $query->fetch()) {
                            echo "<option value='" . $row['lastname'] . ", " . $row['firstname'] . "' ";
                            if (isset($_POST[$lockdown]) && $_POST[$lockdown] == $row['lastname'] . ", " . $row['firstname'])
                                echo "selected";
                            echo ">" . $row['lastname'] . ", " . $row['firstname'] . "</option>";
                        }
                        echo "</select><br>";
                    }
                }while (isset($_POST[$lockdown]));
                ?>
                <br><br>
                <input type='button' value='Submit' onclick='send()'>
                <br><br><br>

                <a href=index.php>Home</a>
            </form>
            <?php $db = null; ?>
            <a href=logout.php>Logout</a>
    </td></table>
</body>
</html>
