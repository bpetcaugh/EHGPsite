<?PHP
session_start();
include 'functions.php';
serv_admin_only();
password_protect();
$db = get_database_connection();

$sryrcn=13000;

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
        <h1 align="center">Service Deficiency Summary for Seniors</h1>
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
                            $stidsel = 0; //$servdbrow2['agency'];
                            $firstname = " no assignment ";
                            $lastname = " no assignment ";

                            $grade=12;
                            $rowst2 = getStudents($grade);
//$rows = getService();
                            echo "<table border=1>";
                            foreach ($rowst2 as $row2) {
                                $cn = $row2['classnum'];
                                $tshv = getServiceHours($cn);
                                $name = $row2['lastname'] . ", " . $row2['firstname'];
                                $grade = $row2['grade'];
                                if (!isset($tshv)) $tshv=0;
                                if (($tshv <20) && ($cn>=$sryrcn) && ($cn<($sryrcn+1000))) {
                                    echo "<tr><td>" . $name . "</td><td>" . $tshv;
                                    echo "</td></tr>";
                                }
                            }
                            echo "</table>";
                        }
                        ?>
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