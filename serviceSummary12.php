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
        //database access working check     echo $username,$teacherid;
?>
        <html>
            <head>
                <link rel="stylesheet" type="text/css" href="css.css" />
                <link rel ="stylesheet" type ="text/css" href ="table.css" />
                <script type='text/javascript'>
                    function refresh()
                    {
                        var formObject = document.forms['theForm'];
                        formObject.action="serviceSummary12.php";
                        formObject.submit();
                    }
                </script>
                <title>Service Summary</title>
            </head>
            <body bgcolor=#CCCCCC>
                <h1 align="center">Service Summary</h1>
                <br>
        <?php
        //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
        $date = date('Y-m-d');
        echo "<h2 align=center>" . date('l', strtotime($date)) . "<br>" . $date . "</h2>";
        echo "<center><a href=http://www.holyghostprep.org>Holy Ghost Prep Home Page</a></center>";
        echo "<center>&nbsp&nbsp<a href=index.php>EHGP Home</a></center>";
        echo "<center>&nbsp&nbsp<a href=logout.php>Logout</a></center><br><br>";
        echo " ";
        ?>
        <br>
        <table align=center><td>
                <!--        <form name='theForm' method='post' action='serviceVerifyS4.php'>//-->

                <?php { //of if SUBMIT
                    //Drop down for agencies list ?????????????????????????????????
                    $stidsel = 0; //$servdbrow2['agency'];
                    $firstname = " no assignment ";
                    $lastname = " no assignment ";

                    //$sql7 = "SELECT * FROM agencies WHERE id=:agidsel";
                    //$agdb1 = $db->prepare($sql7);
                    //$agdb1->bindvalue(":agidsel",$agidsel);
                    //$agdb1->execute();
                    //$agdbrow1 = $agdb1->fetch();
                    //$nameOfSelected = "Select Student";//$agdbrow1['name'];
                    //$agid = 0;
                    //$agency = "agency";
                    //$i = 0;
                    function getService() {
                        $db = get_database_connection();
                        $servdb = $db->prepare("SELECT * FROM service ORDER BY student, verified, date");
                        $servdb->execute();
                        //This should never happen
                        if ($servdb->rowCount() < 1) {
                            echo "ERROR IN DATABASE SELECT";
                            return false;
                        }
                        return $servdb->fetchAll();
                    }
                    function getServiceHours($cn2) {
                        $db = get_database_connection();
                        $servdb2 = $db->prepare("SELECT sum(servicehours)AS totalHours FROM service WHERE student=:cn AND verified='1'");
                        $servdb2->bindValue(":cn",$cn2);// GROUP BY :cn
                        $servdb2->execute();
                        //This should never happen
                        if ($servdb2->rowCount() < 1) {
                            echo "ERROR IN DATABASE SELECT";
                            return false;
                        }
                        $tshrow = $servdb2->fetch();
                        return $tshrow['totalHours'];
                    }
                    $rows = getService();
                    echo "<table border=1>";
                    foreach ($rows as $row) {
                        $sh = $row['servicehours'];
                        $cn = $row['student'];
                        $tshv = getServiceHours($cn);
                        $sdt = $row['date'];
                        $nts = $row['notes'];
                        //need student and agency lookups, role and verified translated
                        $studb = $db->prepare("SELECT * FROM student WHERE classnum=:cn");
                        $studb->bindValue(":cn", $cn);
                        $studb->execute();
                        $rowst = $studb->fetch();
                        //student has classnum, lastname, firstname, grade

                        $agdb = $db->prepare("SELECT * FROM agencies WHERE id=:agid");
                        $agdb->bindValue(":agid", $row['agency']);
                        $agdb->execute();
                        $rowag = $agdb->fetch();
                        //agency has id and name

                        $name = $rowst['lastname'] . ", " . $rowst['firstname'];
                        $grade = $rowst['grade'];
                        $agency = $rowag['name'];
                        $role = "";
                        if ($row['role'] != NULL) {
                            if ($row['role'] == 0) {
                                $role = 'Initiative';
                            } else if ($row['role'] == 1) {
                                $role = 'Leadership';
                            } else if ($row['role'] == 2) {
                                $role = 'Both';
                            }
                        }
                        $verified = "";
                        if (isset($row['verified'])) {
                            if ($row['verified'] == 0) {
                                $verified = 'Not Verified';
                            } else if ($row['verified'] == 1) {
                                $verified = 'Verified';
                            } else if ($row['verified'] == 2){
                                $verified = 'Rejected';
                            }
                        }
                        echo "<tr><td>" . $name . "</td><td>" . $sh . "</td><td>" . $sdt . "</td><td>" . $agency . "</td><td>" . $nts . "</td><td>" . $role . "</td><td>" . $verified ."</td><td>" . $tshv;
                        echo "</td></tr>";
                    }
                    echo "</table>";
//	echo "Select:<select name='stid'>";
//        echo "<option value='" . $stidsel . "' >" . $nameOfSelected . "</option>";
//        while ($stdbrow2 = $stdb2->fetch()) {
//            //$i++;
//            echo "<option value='" . $stdbrow2['id'] . "' ";
//            if (isset($_POST['stid']) && $_POST['stid'] == $stdbrow2['id']) {   //?1
//                echo "selected";
//                $stid = $stdbrow2['id'];
//                $firstname = $stdbrow2['firstname']; // sets $sss5
//		$lastname = $stdbrow2['lastname']; // sets $sss5
//						//$agencyupdate = "agid";
//            }
//            echo ">" . $stdbrow2['lastname'] . ", " . $stdbrow2['firstname'] . "</option>";
//        }
//        echo "</select>";
                    //Not sure if the next two line are necessary, I just left them in in case
                    //echo $_POST['agid'];
//        echo "<input type=hidden value='Wajda' name='lastname'>";
//    echo "<input type=hidden value='Alexander' name='firstname'>";
                }
                //echo "<input type=hidden value='" . $lastname . "' name='lastname'>";
                //echo "<input type=hidden value='" . $firstname . "' name='firstname'>";
                ?>

<!--            <center><input type='submit' name='submit' value='Submit'><br><br></center>
		</form> //-->

            </td></table>

<?php
            } else { //if isset
                redirect("login.php?index.php");
            } //if Session
        }//if isset
        $db = null;
//</form>
?>

    </body>
</html>