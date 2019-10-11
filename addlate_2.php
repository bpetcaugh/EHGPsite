<?php
//edited by Vincent Pilligner
session_start();
include 'functions_2.php';
teacher_only();
password_protect("login_2.php?late=1");
include 'includeInc_2.php';
dohtml_header("Add Late");
$db = get_database_connection();
?>
<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.action = "addlate_2.php";
        formObject.submit();
    }
    function send()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>
<form name='theForm' method='post' action='submit_2.php'>
    <table class='centered'>

            <?php
            homeLogout();
            echo "</table><table class='centered'><tr><td>";
            if (isset($_POST['date'])) {
                echo "Date:<input type=text name=date value='" . $_POST['date'] . "'><br><br>";
            } else {
                echo "Date:<input type=text name=date value='" . date('Y-m-d') . "'><br><br>";
            }

            $i = 0;
            do {
                $i = $i + 1;
                $grade = "grade" . $i;
                $late = "late" . $i;
                $period = "period" . $i;
                $minutes = "minutes" . $i;
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
                    $gradeQuery = $db->prepare("SELECT * FROM student WHERE grade=:grade ORDER BY lastname");
                    $gradeQuery->bindValue(":grade", $_POST[$grade]);
                    $gradeQuery->execute();

                    echo "Student:<select name='" . $late . "' onchange='refresh()'><option value=0>Select Student</option>";

                    while ($row = $gradeQuery->fetch()) {
                        //echo "<option value='" . $row['lastname'] . ", " . $row['firstname'] . "' ";
                        echo "<option value=\"{$row['lastname']}, {$row['firstname']}\" ";
                        if (isset($_POST[$late]) && $_POST[$late] == $row['lastname'] . ", " . $row['firstname'])
                            echo "selected";
                        echo ">" . $row['lastname'] . ", " . $row['firstname'] . "</option>";
                    }
                    echo "</select>";
                }


                if (isset($_POST[$late])) {
                    echo "Period:<select name='" . $period . "' onchange='refresh()'>";
                    echo "<option value=0>Select Period</option>";
                    echo "<option value=1st ";
                    if (isset($_POST[$period]) && $_POST[$period] == "1st")
                        echo "selected";
                    echo ">1st</option>";
                    echo "<option value=2nd ";
                    if (isset($_POST[$period]) && $_POST[$period] == "2nd")
                        echo "selected";
                    echo ">2nd</option>";
                    echo "<option value=4th ";
                    if (isset($_POST[$period]) && $_POST[$period] == "4th")
                        echo "selected";
                    echo ">4th</option>";
                    echo "<option value=5th ";
                    if (isset($_POST[$period]) && $_POST[$period] == "5th")
                        echo "selected";
                    echo ">5th</option>";
                    echo "<option value=6/7th ";
                    if (isset($_POST[$period]) && $_POST[$period] == "6/7th")
                        echo "selected";
                    echo ">6/7th</option>";
                    echo "<option value=7/8th ";
                    if (isset($_POST[$period]) && $_POST[$period] == "7/8th")
                        echo "selected";
                    echo ">7/8th</option>";
                    echo "<option value=9th ";
                    if (isset($_POST[$period]) && $_POST[$period] == "9th")
                        echo "selected";
                    echo ">9th</option>";
                    echo "<option value=10th ";
                    if (isset($_POST[$period]) && $_POST[$period] == "10th")
                        echo "selected";
                    echo ">10th</option>";
                    echo "</select>";
                }
                if (isset($_POST[$minutes])) {
                    $tempminutes = $_POST[$minutes];
                } else {
                    $tempminutes = "";
                }
                if (isset($_POST[$period]) && isset($minutes)) {
                    echo "Minutes late:<input type=text size=4 name=" . $minutes . " value=" . $tempminutes . "><br />";
                }
            } while (isset($_POST[$period]));
            ?>
            <br><br>
            <input type='button' value='Submit' onclick='send()'>
            <br><br><br>

        </td></tr></table>
</form>
<?php
dohtml_footer(true);
$db = null;
?>
            

