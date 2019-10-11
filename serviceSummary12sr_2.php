<?PHP
//Edited by Christian Kardish

session_start();
include 'functions_2.php';
include 'includeInc_2.php';
dohtml_header('Service Deficiency Summary for Seniors');
serv_admin_only();
password_protect();
$db = get_database_connection();

global $thisgradyear;
$sryrcn = $thisgradyear;      //change this every year

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
        <table class='centered'><td width ='33%'></td><td width='33%' class='centered'>
                <!--        <form name='theForm' method='post' action='serviceVerifyS4.php'>//-->

                <?php { //of if SUBMIT
                    $stidsel = 0; //$servdbrow2['agency'];
                    $firstname = " no assignment ";
                    $lastname = " no assignment ";

                    $grade = 12;
                    $rowst2 = getStudents($grade);
//$rows = getService();
                    echo "<table class='centered' border=1>";
                    foreach ($rowst2 as $row2) {
                        $cn = $row2['classnum'];
                        $tshv = getServiceHours($cn);
                        $name = $row2['lastname'] . ", " . $row2['firstname'];
                        $grade = $row2['grade'];
                        if (!isset($tshv))
                            $tshv = 0;
                        if (($tshv < 20) && ($cn >= $sryrcn) && ($cn < ($sryrcn + 1000))) {
                            echo "<tr><td>" . $cn . "</td><td>" . $name . "</td><td>" . $tshv;
                            echo "</td></tr>";
                        }
                    }
                    echo "</table>";
                }
                ?>
            </td><td width='33%'></td></table> <br /> <br />  
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