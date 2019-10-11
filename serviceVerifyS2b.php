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
?>
        <html>
            <head>
                <link rel="stylesheet" type="text/css" href="css.css" />
                <link rel ="stylesheet" type ="text/css" href ="table.css" />
                <script type='text/javascript'>
                    function refresh()
                    {
                        var formObject = document.forms['theForm'];
                        formObject.action="serviceVerifyS2b.php";
                        formObject.submit();
                    }
                </script>
                <title>Service Verification Form</title>
            </head>
            <body bgcolor=#CCCCCC>
                <h1 align="center">Service Verification Form</h1>
                <br />
        <?php
        //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
        $date = date('Y-m-d');
        echo "<h2 align=center>" . date('l', strtotime($date)) . "<br />" . $date . "</h2>";
        echo "<center><a href=http://www.holyghostprep.org>Holy Ghost Prep Home Page</a></center>";
        echo "<center>&nbsp&nbsp<a href=index.php>EHGP Home</a></center>";
        echo "<center>&nbsp&nbsp<a href=logout.php>Logout</a></center><br /><br />";
        echo " ";
        ?>
        <br />
        <table align=center><td>
                <form name='theForm' method='post' action='serviceVerifyS4b.php'>
                    <?php
                    $stdb2 = $db->prepare("SELECT * FROM student ORDER BY lastname, firstname");
                    $stdb2->execute();
                    //This should never happen
                    if ($stdb2->rowCount() < 1)
                        return false;
                   
                    $firstname = " no assignment ";
                    $lastname = " no assignment ";
                    
                    $stidsel = 0;
                    $nameOfSelected = "Select Student";
                    echo "Select:<select name='stid'>";
                    echo "<option value='" . $stidsel . "' >" . $nameOfSelected . "</option>";
                    while ($stdbrow2 = $stdb2->fetch()) {
                        echo "<option value=" . $stdbrow2['id'] . " ";
                        if (isset($_POST['stid']) && $_POST['stid'] == $stdbrow2['id']) {  
                            echo "selected";
                            $stid = $stdbrow2['id'];
                            $firstname = $stdbrow2['firstname'];
                            $lastname = $stdbrow2['lastname'];
                        }
                        echo ">" . $stdbrow2['lastname'] . ", " . $stdbrow2['firstname'] . "</option>";
                    }
                    echo "</select>";
                    //Not sure if the next two line are necessary, I just left them in in case
                    //echo "<input type=hidden value='Wajda' name='lastname'>";
                    //echo "<input type=hidden value='Alexander' name='firstname'>";
                    //echo "<input type=hidden value='" . $lastname . "' name='lastname'>";
                    //echo "<input type=hidden value='" . $firstname . "' name='firstname'>";
                    ?>
                    <center><input type='submit' name='submit' value='Submit'><br /><br /></center>
                </form>
            </td></table>
        <?php
                } else { //if isset
                    redirect("login.php?serviceVerifyS2b.php");
                } //if Session
            }//if isset
            $db = null;
        ?>

    </body>
</html>