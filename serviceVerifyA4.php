<?PHP
session_start();
include 'functions.php';
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
       //database access working check  echo $username,$teacherid;
?>
        <html>
            <head>
                <link rel="stylesheet" type="text/css" href="css.css" />
                <link rel ="stylesheet" type ="text/css" href ="table.css" />
                <script type='text/javascript'>
                    function refresh()
                    {
                        var formObject = document.forms['theForm'];
                        formObject.action="serviceVerifyA4.php";
                        formObject.submit();
                    }
                </script>
                <title>Service Verification Form</title>
            </head>
            <body bgcolor=#CCCCCC>
                <h1 align="center">Service Verification Form</h1>
                <br>
        <?php
        //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
        $date = date('Y-m-d');
        echo "<h2 align=center>" . date('l', strtotime($date)) . "<br>" . $date . "</h2>";
        echo "<center><a href='http://www.holyghostprep.org'>Holy Ghost Prep Home Page</a></center>";
        echo "<center>&nbsp&nbsp<a href=index.php>EHGP Home</a></center>";
        echo "<center>&nbsp&nbsp<a href=logout.php>Logout</a></center><br><br>";
        echo " ";
        ?>
        <br>
        <table align=center><td>
                <form name='theForm' method='post' action='serviceVerifyA4.php'>
                    <?php
                    if (isset($_POST['submit']) && $_POST['submit']) { //problem could be here
                        //echo "submittedsubmittedsubmittedsubmittedsubmittedsubmitted";
                        $_POST['submit'] = NULL;
                        $i = 0;
                        $verified = 0;
                        $agency = $_POST['agid']; //fix here
                        $sql2 = "SELECT * FROM service WHERE verified=:verified AND agency=:agency ORDER by student";
                        $servdb1 = $db->prepare($sql2);
                        $servdb1->bindValue(":verified", $verified);
                        $servdb1->bindValue(":agency", $agency);
                        $servdb1->execute();
                        while ($servdbrow1 = $servdb1->fetch()) { //$row = mysql_fetch_array($result)) {
                            //echo "Yo just after submit loop";
                            $i++;
                            $servid = $servdbrow1['id'];
                            if (((( (isset($_POST["role" . $i . ""])/* && $_POST["role" . $i . ""] */)
                                    || (isset($_POST["verifiedValue" . $i . ""])/* && $_POST["verifiedValue" . $i . ""] */))
                                    || (isset($_POST["hours" . $i . ""])/* && $_POST["hours" . $i . ""] */) )
                                    || (isset($_POST["notes" . $i . ""])/* && $_POST["notes" . $i . ""] */))) {
                                //new data - PROBLEM HERE fixed?2-5-12
                                //echo "Yo just after if isset (){} submit loop";
                                $servhrsi = $servdbrow1["servicehours"];
                                if (isset($_POST["hours" . $i . ""])) {
                                    //if ($_POST["hours" . $i .""]!=NULL) {
                                    $servhrsi = $_POST["hours" . $i . ""];
                                    //}
                                }
                                $rolei = $servdbrow1["role"];
                                if (isset($_POST["role" . $i . ""])) {
                                    //if ($_POST["role" . $i . ""]!=NULL) {
                                    $rolei = $_POST["role" . $i . ""];
                                    //}
                                }
                                $notesi = $servdbrow1["notes"];
                                if (isset($_POST["notes" . $i . ""])) {
                                    //if ($_POST["notes" . $i . ""]!=NULL) {
                                    $notesi = $_POST["notes" . $i . ""];
                                    //}
                                }
                                $verifiedi = $servdbrow1["verified"];
                                if (isset($_POST["verifiedValue" . $i . ""])) {
                                    //if ($_POST["verifiedValue" . $i . ""]!=NULL) {
                                    $verifiedi = $_POST["verifiedValue" . $i . ""];
                                    //}
                                }
                                //echo $servid . "service ID ";
                                //echo $servhrsi;
                                //$agencyi = (${$agid . $i});
                                //query

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

                                //temp check of agencyi
                                //$agencyi=50;
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
                    //Drop down for agencies list ?????????????????????????????????
                    $agidsel = $_POST['agid']; //$servdbrow2['agency'];
                    //$sql7 = "SELECT * FROM agencies WHERE id=:agidsel";
                    //$agdb1 = $db->prepare($sql7);
                    //$agdb1->bindvalue(":agidsel",$agidsel);
                    //$agdb1->execute();
                    //$agdbrow1 = $agdb1->fetch();
                    $nameOfSelected = "AARP"; //$agdbrow1['name'];
                    //$agid = 0;
                    if (!isset($agid)) {
                        $agid = 0;
                    }
                    //$agency = "agency";
                    $i = 0;
                    //$agdb2 = $db->prepare("SELECT * FROM agencies");
                    //$agdb2->execute();
                    //This should never happen
                    //if ($agdb2->rowCount() < 1) return false;
                    //Not sure if the next two line are necessary, I just left them in in case

                    echo "<input type=hidden value='" . $agency . "' name='agid'>";
                    echo "<input type=hidden value='" . $teacherid . "' name=teacherid>";
                    //echo $_POST['agid'];echo $agidsel;
                    if ($agidsel != 0) {
                        //echo "Yo just after POST agency";
                        ////Set up query, only display unverified ones for a particular agency
                        $verified = 0;
                        $agency = $agidsel;
                        //$result = mysql_query("SELECT * FROM service WHERE verified = 0 ORDER by student");
                        $servdb3 = $db->prepare("SELECT * FROM service WHERE verified = :verified AND agency = :agency ORDER by student");
                        $servdb3->bindvalue(":verified", $verified);
                        $servdb3->bindvalue(":agency", $agency);
                        $servdb3->execute();
                        //$result = mysql_query("SELECT * FROM service WHERE verified = 0 ORDER by student");
                        //if ($row = mysql_fetch_array($result))
                        if ($servdb3->rowCount() > 0) {
                            echo "<center>For this page, do not use the refresh button, it will result in incorrect submissions.</center>";
                            //Table header
                    ?>
                            <table id ="customers" align=center border=1><tr><th>First Name</th><th>Last Name</th><th>Grade</th><th>Date</th><th>Agency/Notes</th><th>Hours</th><th>Role</th><th>Verified</th></tr>
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
                                //$student = mysql_query("SELECT * FROM student WHERE id = $servdbrow[student]. ");
                                //$row2 = mysql_fetch_array($student);
                                $agidsel = $servdbrow2['agency'];
                                $sql7 = "SELECT * FROM agencies WHERE id=:agidsel";
                                $agdb1 = $db->prepare($sql7);
                                $agdb1->bindvalue(":agidsel", $agidsel);
                                $agdb1->execute();
                                $agdbrow1 = $agdb1->fetch();
                                $nameOfSelected = $agdbrow1['name'];

                                //$agency = mysql_query("SELECT * FROM agencies WHERE id = $servdbrow[agency]. ");
                                //$row3 = mysql_fetch_array($agency);
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
                                echo $nameOfSelected . "<br>";
                                $notes = $servdbrow2['notes'];
                                echo "<textarea rows=5 cols=50 name='notes" . $i . "'>" . $servdbrow2['notes'] . "</textarea><br><br>";
                            ?>
                            </td>
                            <td>
                            <?php
                                $hours = $servdbrow2['servicehours']; //"hours$i";
                                echo "<input type=text size=5 name='hours" . $i . "' value='" . $servdbrow2['servicehours'] . "'><br><br>";
                            ?>
                            </td>
                            <td>
                            <?php
                                //Radio Box for Role in service, set them equal to either L, I or B
                                //Figured out double quotes would make the variable appear and I was doing INSERT instead of UPDATE for my queries
                                echo "<input type='radio' value = 'L' name='role" . $i . "' >Leadership<br>";
                                echo "<input type='radio' value = 'I' name='role" . $i . "' > Initiative <br>";
                                echo "<input type='radio' value = 'B' name='role" . $i . "' > Both <br>";
                            ?>			</td>
                            <td>
                            <?php
                                //Radio Box for Verification INSERT 1 for verified and 2 for not verified so that each request won't keep appearing even though its already been denied
                                echo "<input type='radio' value = '1' name='verifiedValue" . $i . "' > Verified <br>";
                                echo "<input type='radio' value = '2' name='verifiedValue" . $i . "' > Rejected <br>";
                            ?>                      </td>
                        <?php
                                echo "</tr>";
                            } //while for table end
                        } //if data for table
                        else
                            echo "There are no unverified records for the agency you chose.";
                        ?>
                    </table>    <!-- service display table //-->
                    <?php
                    }
                    echo "</table>"; //table that is the page?
                    echo"";
                }
                //added 2-5-12 - problem?
                /*$verified = 0;
                $agency = $_POST['agid'];
                $servdb3 = $db->prepare("SELECT * FROM service WHERE verified = :verified AND agency = :agency ORDER by student");
                $servdb3->bindvalue(":verified", $verified);
                $servdb3->bindvalue(":agency", $agency);
                $servdb3->execute();*/
                //if ($servdb3->rowCount() > 0) {
                    ?>
                    <center><input type='submit' name='submit' value='Submit'><br><br></center>
                </form>
                <?php
                //}
            } else { //if isset
                redirect("login.php?serviceVerifyA4.php");
                //} //if Session
            }//if isset
            $db = null;
//</form>
                ?>

            </td></table>
    </body>
</html>