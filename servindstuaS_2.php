<?php
//edited by Vincent Pillinger
session_start();
include 'functions_2.php';
password_protect();
?>

<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.action = "servindstuaS_2.php";
        formObject.submit();
    }

    function displayGrade() {
        alert($GET_['grade']);
        tBox.focus();
    }

    function send()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }

</script>


<?php
$db = get_database_connection();

if (isset($_SESSION['username'])) {
    include 'includeInc_2.php';
    dohtml_header("View All Reported  Service");
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $statement = $db->prepare("SELECT * FROM student WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    $row1 = $statement->fetch();
    if ($_SESSION['username'] == $row1['username'] && $_SESSION['password'] == trim($row1['password'])) {//csath added 4-7-16 trim for md5 hash with trailing space
        $sid = $row1['id'];
        $firstname = $row1['firstname'];
        $lastname = $row1['lastname'];
        //database access working check echo $username,$teacherid;	
      
        //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
        $date = date('Y-m-d');
        echo "<h2 class='centered'>" . date('l', strtotime($date)) . "<br />";
		echo $date . "</h2>";
        echo "<table class='centered'>";
		homeLogout();
		tableRowSpace();
		echo "</table>";
  		echo "<form name='theForm' method='post' action='submit_2.php'>";
        //Not sure if the next two line are necessary, I just left them in in case
        echo "<input type=hidden value='" . $sid . "' name=stuid>";
        //echo "<input type=hidden value='" . $teacherid . "' name=teacherid>";
        //old end of php
        //echo "<input type='submit' name='submit' value='submit'><br><br>";
//ADD A TO THE PAGE A DROP DOWN THAT LET'S YOU JUST SEE THE HOURS FOR EACH GRADE LEVEL IN ASCENDING ORDER
//WHOSE FULFILLED REQUIREMENTS
//ADD A DROP DOWN FOR REASONS WHY THEY WERE REJECTED
//DATABASE DUMP ORDERED BY GRADE: FIRST/LAST/TOTAL SERVICE HOURS
        //Set up queries for all my table displays and set variable values
        $i = 0;
        $totalhours = 0;
        //$verified = 1;  
        //$agid=4; //temporary hardcoding //darn Vince Pillinger moved total lines here! variables don't have values yet!!! ARGH!!!!
       
		echo "<table class='centered' border=1>";
        echo "<tr><th>Agency Name</th><th>Date</th><th>Hours</th><th>Description/Notes</th><th>Status</th></tr>";
        //$result = mysql_query("SELECT * FROM service WHERE agency = $agid AND verified = 1 ORDER by date");
        $sth2 = $db->prepare("SELECT * FROM service WHERE student = :sid  ORDER by date");
        //$sth2 = $db->prepare("SELECT * FROM service WHERE agency = :agency ORDER by date");
        $sth2->bindValue(":sid", $sid);
        //$sth2->bindValue(":verified", $verified);
        $sth2->execute();

        while ($servdbrow = $sth2->fetch()) {
            //$student = mysql_query("SELECT * FROM student WHERE id = $row[student].");
            //$sid = $servdbrow['student'];
            $sth3 = $db->prepare("SELECT * FROM agencies WHERE id = :agid");
            $sth3->bindValue(":agid", $servdbrow['agency']);
            $sth3->execute();
            $agdbrow = $sth3->fetch(); //mysql_fetch_array($student);
            //Display the table and track total hours for the agency
            ?>
            <tr>
                <td><?php echo $agdbrow['name']; ?></td>
                <td><?php echo $servdbrow['date']; ?></td>
                <td><?php echo $servdbrow['servicehours']; ?></td>
                <td width="150"><?php echo $servdbrow['notes']; ?></td>
                <td><?php
//echo $servdbrow['verified'];
            $tempVerified = $servdbrow['verified'];
            if ($tempVerified == 0) {
                echo "NOT yet Verified";
            } else {
                if ($tempVerified == 1) {
                    echo "Verified";
                } else {
                    echo "Rejected";
                }
            }
            ?></td>
            </tr>	
                    <?php
                    $totalhours = $totalhours + $servdbrow['servicehours'];
                    $i++;
                }
                echo "<p>";//below moved here to fix hours totalling 10-03-13
 echo "<table class='centered'>";
		tableRowSpace();
		echo "<tr><td>";
		echo $firstname . " " . $lastname . " has volunteered " . $i . " times performing a total of " . $totalhours . " hours.";
        echo "<br/>Note that all of the reported service may not be verified. <br/><br/>Choose the 'View Verified Service' button to see the service hours reported <br />";
        echo "which have been approved for credit toward required hours.";
        tableRowSpace();
		echo "</td></tr></table>";                
                echo "</p></table>";
            }
            ?>
    </form>
    <?php
} else {
    redirect("login_2.php?servindstuaS");
}
$db = null;
dohtml_footer(true);
?>

