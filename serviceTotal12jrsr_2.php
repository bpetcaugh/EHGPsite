<?PHP
//Edited by Christian Kardish

session_start();
include 'functions_2.php';
include 'includeInc_2.php';
dohtml_header("Verified and Sufficient Service Summary");
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
        ?><head>
            <link rel="stylesheet" type="text/css" href="css_2.css" />
            <link rel ="stylesheet" type ="text/css" href ="table.css" />
            <script type='text/javascript'>
                function refresh()
                {
                    var formObject = document.forms['theForm'];
                    formObject.action = "serviceSummary12_2.php";
                    formObject.submit();
                }
            </script>
            <title>Service Summary</title>
        </head>
        
        <br>
        <?php
        //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
        $date = date('Y-m-d');
        echo "<h2 align=center>" . date('l', strtotime($date)) . "<br>" . $date . "</h2>";
        echo " ";
        ?>
        <br>
        <table class="centered"><td>
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
//                            function getService() {
//                                $db = get_database_connection();
//                                $servdb = $db->prepare("SELECT * FROM service ORDER BY student, verified, date");
//                                $servdb->execute();
//                                //This should never happen
//                                if ($servdb->rowCount() < 1) {
//                                    echo "ERROR IN DATABASE SELECT";
//                                    return false;
//                                }
//                                return $servdb->fetchAll();
//                            }
//                            function getStudents() {
//                                $db = get_database_connection();
//                                $studb = $db->prepare("SELECT * FROM student WHERE grade>10 ORDER BY grade, lastname, firstname ASC");
//                                $studb->execute();
//                                //This should never happen
//                                if ($studb->rowCount() < 1) {
//                                    echo "ERROR IN DATABASE SELECT";
//                                    return false;
//                                }
//                                return $studb->fetchAll();
//                            }
//                            function getServiceHours($cn2) {
//                                $db = get_database_connection();
//                                $servdb2 = $db->prepare("SELECT sum(servicehours)AS totalHours FROM service WHERE student=:cn AND verified='1'");
//                                $servdb2->bindValue(":cn",$cn2);// GROUP BY :cn
//                                $servdb2->execute();
//                                //This should never happen
//                                if ($servdb2->rowCount() < 1) {
//                                    echo "ERROR IN DATABASE SELECT";
//                                    return false;
//                                }
//                                $tshrow = $servdb2->fetch();
//                                return $tshrow['totalHours'];
//                            }
                    $rows = getService(12);
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
                            } else if ($row['verified'] == 2) {
                                $verified = 'Rejected';
                            }
                        }
                        if (($tshv >= 20) && ($cn < 15000)) {
                            echo "<tr><td>" . $name . "</td><td>" . $sh . "</td><td>" . $sdt . "</td><td>" . $agency . "</td><td>" . $nts . "</td><td>" . $role . "</td><td>" . $verified . "</td><td>" . $tshv;
                            echo "</td></tr>";
                        }
                    }
                    echo "</table>";
                    $rows = getService(11);
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
                            } else if ($row['verified'] == 2) {
                                $verified = 'Rejected';
                            }
                        }
                        if (($tshv >= 20) && (($cn > 14999) && ($cn < 15999))) {
                            echo "<tr><td>" . $name . "</td><td>" . $sh . "</td><td>" . $sdt . "</td><td>" . $agency . "</td><td>" . $nts . "</td><td>" . $role . "</td><td>" . $verified . "</td><td>" . $tshv;
                            echo "</td></tr>";
                        }
                    }
                    echo "</table>";

//                            echo "<br/><br/>The following students have not entered anything into the database: ";
//                            $rowst = getStudents(11);
//                            $entered = true;
//                            echo "<table border=2>";
//                            foreach ($rowst as $row2) {
//                                $cn = $row2['classnum'];
//                                $name = $row2['lastname'] . ", " . $row2['firstname'];
//                                $grade = $row2['grade'];
//                                //echo $cn.$name.$grade;
//                                $servdb3 = $db->prepare("SELECT * FROM service WHERE student=:cn");
//                                $servdb3->bindValue(":cn", $cn);
//                                $servdb3->execute();
//                                //$row3 = $servdb3->fetch();
//                                //echo $row3['student'].$row3[''];
//                                if ($servdb3->rowCount() < 1) {
//                                    echo "<tr><td>" . $name . "</td><td>" . $grade . "</td></tr>";
//                                    $entered = false;
//                                }
//                            }
//                            if ($entered == true) {
//                                echo "<tr><td> Everyone has entered</td><td></td></tr>";
//                            }
//                            echo "</table>";
                }
                ?>
            </td></table><br /><br />
        <?php
    } else { //if isset
        redirect("login_2.php?index_2.php");
    } //if Session
}//if isset
$db = null;
echo "<table class='centered'><td class='centered'>";
homeLogoutService();
echo "</td></table>";
dohtml_footer(true);
//</form>
?>