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
        ?> 
        <script type='text/javascript'>
            function refresh()
            {
                var formObject = document.forms['theForm'];
                formObject.action = "serviceVerifyS2b_2.php";
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
        <br />
        <table class='centered'><td>
                <form name='theForm' method='post' action='serviceVerifyS4b_2.php'>
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
        redirect("login_2.php?serviceVerifyS2b_2.php");
    } //if Session
}//if isset
$db = null;
dohtml_footer(true);
?>
