<?PHP
//edited by Vincent Pillinger
session_start();
include 'functions_2.php';
serv_admin_only();
password_protect();
$db = get_database_connection();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $tchdb1 = $db->prepare("SELECT * FROM teacher WHERE username=:username AND password=:password");
    $tchdb1->bindValue(":username", $username);
    $tchdb1->bindValue(":password", $password);
    $tchdb1->execute();
    $tchdbrow = $tchdb1->fetch();

    if ($_SESSION['username'] == $tchdbrow['username'] && $_SESSION['password'] == $tchdbrow['password']) {  
    
        $teacherid = $tchdbrow['id'];
        $print = true;
        include 'includeInc_2.php';
        dohtml_header("Service Verification Form");
        ?>
        <script type='text/javascript'>
            function refresh()
            {
                var formObject = document.forms['theForm'];
                formObject.action = "serviceVerifyS4b_2.php";
                formObject.submit();
            }
        </script>

        <?php
        //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
        $date = date('Y-m-d');
        echo "<table class='centered'><tr><td>";
        echo "<h2>" . date('l', strtotime($date)) . "<br>" . $date . "</h2></td></tr>";
        homeLogoutService();
		tableRowSpace();
        //test remove
        echo "<tr><td>Data for Student ID#: " . $_POST['stid'] . "</td></tr>"; // . " " . $_POST['lastname'] . ", " . $_POST['firstname'];
        echo "</table>";
        ?>
        <br>
        <table class=centered><td>
                <form name='theForm' method='post' action='serviceVerifyS4b_2.php'>
                    <?php
                    echo "<input type='hidden' name='stid' value='" . $_POST['stid'] . "'>"; //Once a form is submitted the POST array is cleared!
                    $stid = $_POST['stid']; //fix here try 3-22-12
                    if (isset($_POST['submit']) && $_POST['submit']) {
                        $_POST['submit'] = NULL;
                        $i = 0;
                        $verified = 0;
                        $stid = $_POST['stid']; //fix here
                        $sql2 = "SELECT * FROM service WHERE verified=:verified AND student=:stid ORDER by date";
                        $servdb1 = $db->prepare($sql2);
                        $servdb1->bindValue(":verified", $verified);
                        $servdb1->bindValue(":stid", $stid);
                        $servdb1->execute();
                        while ($servdbrow1 = $servdb1->fetch()) {
                            $i++;
                            $servid = $servdbrow1['id'];
                            if (((( (isset($_POST["role" . $i . ""])) || (isset($_POST["verifiedValue" . $i . ""]))) || (isset($_POST["hours" . $i . ""])) ) || (isset($_POST["notes" . $i . ""])))) {
                                $servhrsi = $servdbrow1["servicehours"];
                                if (isset($_POST["hours" . $i . ""])) {
                                    $servhrsi = $_POST["hours" . $i . ""];
                                }
                                $rolei = $servdbrow1["role"];
                                if (isset($_POST["role" . $i . ""])) {
                                    $rolei = $_POST["role" . $i . ""];
                                }
                                $notesi = $servdbrow1["notes"];
                                if (isset($_POST["notes" . $i . ""])) {
                                    $notesi = $_POST["notes" . $i . ""];
                                }
                                $verifiedi = $servdbrow1["verified"];
                                if (isset($_POST["verifiedValue" . $i . ""])) {
                                    $verifiedi = $_POST["verifiedValue" . $i . ""];
                                }

                                $sql3 = "UPDATE service SET servicehours=:servhrsi WHERE id=:servid";
                                $servdb2 = $db->prepare($sql3);
                                $servdb2->bindValue(":servhrsi", $servhrsi);
                                $servdb2->bindValue(":servid", $servid);
                                $servdb2->execute();

                                $sql3 = "UPDATE service SET notes=:notesi WHERE id=:servid";
                                $servdb2 = $db->prepare($sql3);
                                $servdb2->bindValue(":notesi", $notesi);
                                $servdb2->bindValue(":servid", $servid);
                                $servdb2->execute();

                                $sql3 = "UPDATE service SET role=:rolei WHERE id=:servid";
                                $servdb2 = $db->prepare($sql3);
                                $servdb2->bindValue(":rolei", $rolei);
                                $servdb2->bindValue(":servid", $servid);
                                $servdb2->execute();

                                $sql3 = "UPDATE service SET verified=:verifiedi WHERE id=:servid";
                                $servdb2 = $db->prepare($sql3);
                                $servdb2->bindValue(":verifiedi", $verifiedi);
                                $servdb2->bindValue(":servid", $servid);
                                $servdb2->execute();
                            } //if one of the POST Values changed
                        }//while of POST submit
                    }//end of if SUBMIT { //of if SUBMIT
                    if (!isset($_POST['stid'])) {
                        $stid = 0;
                    } else {
                        $stid = $_POST['stid'];
                    }
                    $i = 0;
                    if ($stid != 0) {
                        $verified = 0;
                        $servdb3 = $db->prepare("SELECT * FROM service WHERE verified = :verified AND student = :stid ORDER by date");
                        $servdb3->bindvalue(":verified", $verified);
                        $servdb3->bindvalue(":stid", $stid);
                        $servdb3->execute();
                        if ($servdb3->rowCount() > 0) {
                            echo "<center>For this page, do not use the refresh button, it will result in incorrect submissions.</center>";
                            //Table header
                            ?>
                            <table id ="customers" align=center border=1>
                                <tr><th>First Name</th><th>Last Name</th><th>Grade</th>
                                    <th>Date</th><th>Agency/Notes</th><th>Hours</th>
                                    <th>Role</th><th>Verified</th></tr>
                                <?php
                                //Set up more queries for table displays
                                $i = 0;
                                //while ($row = mysql_fetch_array($result))
                                while ($servdbrow2 = $servdb3->fetch()) {
                                    $sid = $servdbrow2['student'];

                                    $sql6 = "SELECT * FROM student WHERE id=:sid";
                                    $studb1 = $db->prepare($sql6);
                                    $studb1->bindvalue(":sid", $sid);
                                    $studb1->execute();
                                    $studbrow1 = $studb1->fetch();
                                    $agidsel = $servdbrow2['agency'];

                                    $sql7 = "SELECT * FROM agencies WHERE id=:agidsel";
                                    $agdb1 = $db->prepare($sql7);
                                    $agdb1->bindvalue(":agidsel", $agidsel);
                                    $agdb1->execute();
                                    $agdbrow1 = $agdb1->fetch();
                                    $nameOfSelected = $agdbrow1['name'];

                                    $i++;
                                    //Display table results
                                    echo "<tr class=alt>";
                                    ?>
                                    <td><?php echo $studbrow1['firstname']; ?></td>
                                    <td><?php echo $studbrow1['lastname']; ?></td>
                                    <td><?php echo $studbrow1['grade']; ?></td>
                                    <td><?php echo $servdbrow2['date']; ?></td>
                                    <td width="150">
                                        <?php
                                        //echo //$row3['name']
                                        echo $nameOfSelected . "<br />";
                                        $notes = $servdbrow2['notes'];
                                        echo "<textarea rows=5 cols=50 name='notes" . $i . "'>" . $servdbrow2['notes'] . "</textarea><br /><br />";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $hours = $servdbrow2['servicehours']; //"hours$i";
                                        echo "<input type=text size=5 name='hours" . $i . "' value='" . $servdbrow2['servicehours'] . "'><br /><br />";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        //Radio Box for Role in service, set them equal to either L, I or B
                                        //Figured out double quotes would make the variable appear and I was doing INSERT instead of UPDATE for my queries
                                        echo "<input type='radio' value = 'L' name='role" . $i . "' >Leadership<br />";
                                        echo "<input type='radio' value = 'I' name='role" . $i . "' > Initiative <br />";
                                        echo "<input type='radio' value = 'B' name='role" . $i . "' > Both <br />";
                                        ?>			</td>
                                    <td>
                                        <?php
                                        //Radio Box for Verification INSERT 1 for verified and 2 for not verified so that each request won't keep appearing even though its already been denied
                                        echo "<input type='radio' value = '1' name='verifiedValue" . $i . "' > Verified <br />";
                                        echo "<input type='radio' value = '2' name='verifiedValue" . $i . "' > Rejected <br />";
                                        ?>                      </td>
                                    <?php
                                    echo "</tr>";
                                } //while for table end
                            } //if data for table
                            else {
                                echo "There are no unverified records for the student you chose.";
                                $print = false;
                            }
                            ?>
                        </table>    <!-- service display table //-->
                        <?php
                    }
                    echo "</table>"; //table that is the page?
                    echo"";
                }//if SESSION
                if ($print) {
                    echo "<center><input type='submit' name='submit' value='Submit'><br /><br /></center>";
                } else {
                    //echo "<center><input type='button' name='home' value='EHGP Home' onclick='homepage()'><br /><br /></center>";
                }
                echo "</form>";
                //}
            } else { //if isset
                redirect("login_2.php?serviceVerifyS4b_2.php");
                //} //if Session
            }//if isset
            $db = null;
            echo "</td></table>";
            dohtml_footer(true);
            ?>


