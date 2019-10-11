<?php           //CK 3/10/14
session_start();
include 'includeInc_2.php';
include 'functions_2.php';
dohtml_header("View Submitted Support Tickets");
teacher_only(); 
?>

<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
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
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $statement = $db->prepare("SELECT * FROM teacher WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    $row1 = $statement->fetch();
    if ($username == $row1['username'] && $password == $row1['password']) {
             
        $id = $row1['id'];
        $name = $row1['name'];
        echo "<form name='theForm' method='post' action='viewtickets.php'>";
        //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
        $date = date('Y-m-d');
        echo "<table class='centered'><tr><td>";
        echo "<h2>" . date('l', strtotime($date)) . "<br />" . $date . "</h2></td></tr>";
        homeLogout();
        
        if(isset($_POST['statEdit'])){          //if admin has submitted a new status, update 
            $statusLevel = $_POST['statusChange'];
            $probID = $_POST['probID'];
			$comments = $_POST['comm'];
            $sth5 = $db->prepare("UPDATE support SET status=:status, comments=:comments WHERE id=:id");
            $sth5->bindValue(":status", $statusLevel);
			$sth5->bindValue(":comments", $comments);
            $sth5->bindValue(":id", $probID);
            $sth5->execute();                        
        }

        
        $viewers = true;

        $headings[0] = "Date";
        $headings[1] = "Problem Type";
        $headings[2] = "Urgency Level";
        $headings[3] = "Status";
        $headings[4] = "Ticket No.";
        
        $isView = false;        
        if(isset($_POST['view'])){          //if page has been refreshed
            $isView = true;
        }
        $isViews = false;
        if(isset($_POST['views'])){         //if page has been refreshed after admin changed a status
            $isViews = true;
        }
        
        echo "<tr><td> View By: <select name='view' onchange='refresh()'>";
        
	$view = 0;
	if (is_super_admin($username, $password)){
		$view = 4;
	}
	
        for ($i = 0; $i < 5; $i++) {
            echo "<option value='$i'";
            if (($isView && $_POST['view'] == $i) || ($isViews && $_POST['views'] == $i)) {  //if refreshed or if refreshed after admin has changed a status, and view by is set
                echo " selected=selected";
                $view = $i;
            }
            echo ">" . $headings[$i] . "</option>";
        }
        $views = $view;
        echo "</select></td></tr></table></form><br /><br />";

        //Set up queries for all my table displays and set variable values
        echo "<table class='centered' border=1>";   //get this below
        echo "<tr><th>$headings[4]</th><th>Teacher</th><th>$headings[1]</th><th>Ticket Description</th><th>$headings[2]</th><th>$headings[0]</th><th>$headings[3]</th></tr>";
    
        $needBind = false;
        $needExtras = false;
        $viewing=1;
         if (!is_super_admin($username, $password)) {     //$viewing == 0) {        //if not an admin or if viewing is not set
            $ticketView = ("SELECT * FROM support WHERE teacher = :id ");   
            $needBind = true;
        } else {
            $ticketView = ("SELECT * FROM support ");       //if admin wants to view all
        }        
        
        if ($view == 0) {      //if view by date is selected or none is
            $ticketOrder = ("ORDER by id ASC");        
        } else if ($view == 1) {               //if view by problem is selected
            $ticketOrder = ("ORDER by problem");
        } else if ($view == 2) {           //if view by urgency is selected
            $ticketOrder = ("ORDER by urgency");
        } else if ($view == 3){         //if view by status is selected
            $ticketOrder = ("ORDER by status");
        }else{              //if view by ticket no. is selected
            $needExtras = true;
            if($viewing == 0){
                $ticketOrder = ("AND status !=3 ORDER by id ASC");      //select all that aren't complete first
                $extraTicks = $db->prepare($ticketView . "AND status = 3"); //ORDER by id");     //select all that are completed
            }else{
                $ticketOrder = ("WHERE status !=3 ORDER by id ASC");    //select all that aren't complete first
                $extraTicks = $db->prepare($ticketView . "WHERE status = 3 ORDER by date ASC"); //ORDER by id");   //select all that are completed
            }                        
            if ($needBind) {
                $extraTicks->bindValue(":id", $id);
            }
            $extraTicks->execute();
        }        

        $sth2 = $db->prepare($ticketView . $ticketOrder);
        if ($needBind) {
            $sth2->bindValue(":id", $id);
        }
        $sth2->execute();
        ticketsDisplay($sth2, $username, $password, $viewers, $views);      //display first set of data
        if($needExtras){
            ticketsDisplay($extraTicks, $username, $password, $viewers, $views);        //if view by tick. no, display second set of data       
        }        
    }
    
    ?>
    </form>
    <?php
} else {
    redirect("login_2.php");
}
$db = null;
echo "</td></table>";
dohtml_footer(true);
?>