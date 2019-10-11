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
                        formObject.action="serviceVerifyA2b.php";
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
                <form name='theForm' method='post' action='serviceVerifyA4.php'>
                    <?php
                    $agdb2 = $db->prepare("SELECT * FROM agencies ORDER BY name");
                    $agdb2->execute();
                    //This should never happen
                    if ($agdb2->rowCount() < 1)
                        return false;
                    $agidsel = 0;
                    $nameOfSelected = "Select Agency";
                    $agency = "agency";
                    echo "Select:<select name='agid'>";
                    echo "<option value='" . $agidsel . "' >" . $nameOfSelected . "</option>";
                    while ($agdbrow2 = $agdb2->fetch()) {
                        echo "<option value='" . $agdbrow2['id'] . "' ";
                        if (isset($_POST['agid']) && $_POST['agid'] == $agdbrow2['id']) {
                            echo "selected";
                            $agid = $agdbrow2['id'];
                            $agency = $agdbrow2['name'];
                        }
                        echo ">" . $agdbrow2['name'] . "</option>";
                    }
                    echo "</select>";
                    ?>
                    <center><input type='submit' name='submit' value='Submit'><br /><br /></center>
                </form>
            </td></table>
        <?php
                } else { //if isset
                    redirect("login.php?serviceVerifyA2b.php");
                } //if Session
            }//if isset
            $db = null;
        ?>
    </body>
</html>