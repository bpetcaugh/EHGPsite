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
        include 'includeInc_2.php';
        dohtml_header("Service Verification Form");
        //database access working check     echo $username,$teacherid;	
        ?>
        <script type='text/javascript'>
            function refresh()
            {
                var formObject = document.forms['theForm'];
                formObject.action = "serviceVerifyA2b_2.php";
                formObject.submit();
            }
        </script>

        <?php
        //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
        $date = date('Y-m-d');
        echo "<table class='centered'><tr><td>";
        echo "<h2>" . date('l', strtotime($date)) . "<br />" . $date . "</h2></td></tr>";
        homeLogoutService();
        echo "</table>";
        ?>
        <table class='centered'><td>
                <form name='theForm' method='post' action='serviceVerifyA4_2.php'>
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
        redirect("login_2.php?serviceVerifyA2b_2.php");
    } //if Session
}//if isset
$db = null;
dohtml_footer(true);
?>
