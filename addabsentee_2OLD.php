<?PHP
//edited by Vincent Pillinger
session_start();
include 'functions_2.php';
teacher_only();
password_protect();
$db = get_database_connection();
include 'includeInc_2.php';
dohtml_header("Add Absentees");
?>
<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.action="addabsentee_2.php";
        formObject.submit();
    }
    function send()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>
    <table class='centered'>
            <form name='theForm' method='post' action='submit_2.php'>
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
                            if ($row['lastname']!="Zz"){
								//echo "<option value='" . $row['lastname'] . ", " . $row['firstname'] . "' "; Ricky Wang MMM {} concat 2-25-16
								echo "<option value=\"{$row['lastname']}, {$row['firstname']}\" ";
								//echo "<option value=\"{$row['name']}\" "; echo "<option value=\"{$row['lastname']}, {$row['firstname']}\" ";example
								if (isset($_POST[$absentee]) && $_POST[$absentee] == $row['lastname'] . ", " . $row['firstname'])
									echo "selected";
								//echo ">" . $row['lastname'] . ", " . $row['firstname'] . "</option>";Ricky Wang MMM {} concat 3-2-16
								echo ">{$row['lastname']}, {$row['firstname']}</option>";
							}
                        }
                        echo "</select><br />";
                    }
                }while (isset($_POST[$absentee]));
              ?>
                <br><br>
                <input type='button' value='Submit' onclick='send()'>
                <br /><br /><br />

                
	    </td></tr></form></table>
<?php   $db = null;
dohtml_footer(true);
?>
