<?PHP
//Edited by Christian Kardish

session_start();
include 'functions_2.php';
include 'includeInc_2.php';
dohtml_header("Add Lockdown");
teacher_only();
password_protect("login_2.php?lockdown=1");
$db = get_database_connection();
?>
    <head>
        <script type='text/javascript'>
            function refresh()
            {
                var formObject = document.forms['theForm'];
                formObject.action = "addlockdown_2.php";
                formObject.submit();
            }
            function send()
            {
                var formObject = document.forms['theForm'];
                formObject.submit();
            }
        </script>
        <link rel="stylesheet" type="text/css" href="css_2.css" />
    </head>
    <body bgcolor=#CCCCCC>
        <table class="centered"><tr><td>Please enter all of the students and faculty that are locked in with you in addition to yourself.</td></tr>
                <tr><td>
				<form name='theForm' method='post' action='submit_2.php'>
                    <input type=hidden value=1 name='isLockdown'>

                    <?php
                    $date = date('Y-m-d');
                    if (isset($_POST['date'])) {
                        echo "Date:<input type=text name=date value='" . $_POST['date'] . "'><br><br>";
                    } else {
                        echo "Date:<input type=text name=date value='" . date('Y-m-d') . "'><br><br>";
                    }
echo "</td></tr><tr><td>";
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
                        echo "<option value=0 ";
                        if (isset($_POST[$grade]) && $_POST[$grade] == 0)
                            echo "selected";
                        echo ">Faculty</option>";
                        echo "</select>";

                        if (isset($_POST[$grade])) {

                            //if faculty selected, has to pull from different database
                            if ($_POST[$grade] == 0) {
                                $query = $db->prepare("SELECT * FROM teacher ORDER BY name");
                            } else {
                                $query = $db->prepare("SELECT * FROM student WHERE grade=:grade ORDER BY lastname");
                            }
                            
                            $lockdownQuery = $db->prepare("SELECT * FROM lockdown WHERE grade=:grade AND date=:date  ORDER BY name");

                            $query->bindValue(":grade", $_POST[$grade]);
                            $query->execute();

                            $lockdownQuery->bindValue(":date", $date);
                            $lockdownQuery->bindValue(":grade", $_POST[$grade]);
                            $lockdownQuery->execute();

                            echo "Student:<select name='" . $lockdown . "' onchange='refresh()'><option value=0>Select Person</option>";

                            $lockNumRows = $lockdownQuery->rowCount();
                            if ($lockNumRows > 0) {       //if there are rows to check in the lockdownQuery                               
                                $lockRow = $lockdownQuery->fetch();
                                $firstCheck = true;     //first time checking
                            } else {
                                $lockNumRows = -1;         //no rows to check in the lockdownQuery
                            }


                            while ($row = $query->fetch()) {
                                $found = false;
                                if ($lockNumRows != -1) {     //if there are any rows left to check in the lockdownQuery
                                    if ($firstCheck == true) {    //if first time checking (necessary to prevent off by one error)
                                        $lockNumRows = $lockNumRows - 1;    //1 less row left to check
                                        $firstCheck = false;
                                    }
                                    //if faculty, needs different data
                                    if ($_POST[$grade] == 0) {
                                        $rowName = $row['name'];
                                    } else {  //students
                                        $rowLName = $row['lastname'];   //last name field
                                        $rowLastName = trim($rowLName);     //removes spaces from last name
                                        $rowFName = $row['firstname'];  //first name field
                                        $rowFirstName = trim($rowFName);    //removes spaces from first name
                                        $rowName = $rowLastName . ", " . $rowFirstName;     //concatenates first and last name
                                    }
                                    if ($lockRow['name'] == $rowName) {  //check lockrow with row
                                        $found = true;           //person already checked in and is found  
                                        if ($lockNumRows > 0) {  //if rows left to check
                                            $lockRowOld = $lockRow['name'];
                                            $lockRow = $lockdownQuery->fetch();
                                            $lockNumRows = $lockNumRows - 1;    //one less row left to check                                            
                                            while($lockRowOld == $lockRow['name']){      //if there are duplicates in database, skip over until next "new" name
                                                 $lockRow = $lockdownQuery->fetch();
                                                 $lockNumRows = $lockNumRows - 1;   //one less row left to check
                                            }
                                        } else {    //else no rows left to check
                                            $lockNumRows = -1;
                                        }
                                    } 
                                }
                                if ($found == false) {      //if person not already found, print out the name, else, name is not printed out
                                    if ($_POST[$grade] == 0) {
                                        //echo "<option value='" . $row['name'] . "' "; MMM Ricky Wang {} concat try 2-19-16
                                        echo "<option value=\"{$row['name']}\" ";
                                        if (isset($_POST[$lockdown]) && $_POST[$lockdown] == $row['name']) {
                                            echo "selected";
                                        }
                                        echo ">" . $row['name'] . "</option>";
                                    } else {
                                        //echo "<option value='" . $row['lastname'] . ", " . $row['firstname'] . "' ";MMM Ricky Wang {} concat try 2-19-16
                                        echo "<option value=\"{$row['lastname']}, {$row['firstname']}\" ";
                                        if (isset($_POST[$lockdown]) && $_POST[$lockdown] == $row['lastname'] . ", " . $row['firstname'])
                                            echo "selected";
                                        echo ">" . $row['lastname'] . ", " . $row['firstname'] . "</option>";
                                    }
                                }
                            }
                            echo "</select><br />";
                        }
                    }while (isset($_POST[$lockdown]));
                    ?>
                    <br /><br />
                    <input type='button' value='Submit' onclick='send()'>
                    <br /><br /><br /></td></tr>
                </form></td></tr></table><table class="centered">
                <?php $db = null;
                homeLogout(); ?>
            </table>
        <?php dohtml_footer(true); ?>
