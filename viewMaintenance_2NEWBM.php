<?php           //CK 3/10/14
session_start();
include 'includeInc_2.php';
include 'functions_2.php';
dohtml_header("View Submitted Requests");
teacher_only(); 
$filename = "viewMaintenance_2NEWBM.php";
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
        
		$headings[0] = "Date";
        $headings[1] = "Request Location";
        $headings[2] = "Urgency Level";
        $headings[3] = "Status";
        $headings[4] = "Ticket No.";
		$headings[5] = "Teacher";//more headings added 5-26-16 BM with MMM
		$headings[6] = "Ticket Description";
		$headings[7] = "Comments";
        $id = $row1['id'];
        $name = $row1['name'];
		
        //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
        $date = date('Y-m-d');
        echo "<table class='centered'><tr><td>";
        echo "<h2>" . date('l', strtotime($date)) . "<br />" . $date . "</h2></td></tr>";
        homeLogout();
        
		echo "<form name='theForm' method='post' action=$filename>";
		echo "<tr><td> View By: <select name='view' onchange='refresh()'>";
		
        if(isset($_POST['statEdit'])){          //if admin has submitted a new status, update 
            $statusLevel = $_POST['statusChange'];
            $probID = $_POST['probID'];
            $sth5 = $db->prepare("UPDATE mainrequest SET status=:status WHERE id=:id");
            $sth5->bindValue(":status", $statusLevel);
            $sth5->bindValue(":id", $probID);
            $sth5->execute();                        
        }
		//Added by BM
		if(isset($_POST['addComments'])){  //if admin has submitted a new comment, update 
			$commentsName =  $_POST['editComments'];
			$probID = $_POST['probID'];
			$sth6 = $db->prepare("UPDATE mainrequest SET comments=:comments WHERE id=:id");
			$sth6->bindValue(":comments", $commentsName);
			$sth6->bindValue(":id", $probID);
			$sth6->execute();
		
        }

        $isView = false;        
        if(isset($_POST['view'])){          //if page has been refreshed
            $isView = true;
        }
         
	$view = 0;
	        for ($i = 0; $i < sizeof($headings); $i++) {
            echo "<option value='$i'";
                 if ($isView && $_POST['view'] == $i) { //if refreshed or if refreshed after admin has changed a status, and view by is set
				echo " selected=selected";
                $view = $i;
            }
            echo ">" . $headings[$i] . "</option>";
        }
        echo "</select></td></tr></form></table><br /><br />";

        //Set up queries for all my table displays and set variable values
        echo "<table class='centered' border=1>";   //get this below
 //       echo "<tr><th>$headings[4]</th><th>Teacher</th><th>$headings[1]</th><th>Ticket Description</th><th>$headings[2]</th><th>$headings[0]</th><th>$headings[3]</th><th>Comments</th></tr></tr>"; //added Comments row, BM
        echo "<tr><th>$headings[4]</th><th>$headings[5]</th><th>$headings[1]</th><th>$headings[6]</th><th>$headings[2]</th><th>$headings[0]</th><th>$headings[3]</th><th>$headings[7]</th></tr></tr>"; //added Comments row, BM
    
        $needBind = false;
         if (!is_req_admin($username, $password)) {     //$viewing == 0) {        //if not an admin or if viewing is not set
            $ticketView = ("SELECT * FROM mainrequest WHERE teacher = :id ");   
            $needBind = true;
        } else {
            $ticketView = ("SELECT * FROM mainrequest ");       //if admin wants to view all
        }        
        
        if ($view == 0) {      //if view by date is selected or none is
            $ticketOrder = ("ORDER by date DESC");        
        } else if ($view == 1) {               //if view by request is selected
            $ticketOrder = ("ORDER by request");
        } else if ($view == 2) {           //if view by urgency is selected
            $ticketOrder = ("ORDER by urgency");
        } else if ($view == 3){         //if view by status is selected
            $ticketOrder = ("ORDER by status");
        }else{              //if view by ticket no. is selected
            $ticketOrder = ("WHERE status !=2 ORDER by id");    //select all that aren't complete first
            }                        
         //   if ($needBind) {
         //       $extraTicks->bindValue(":id", $id);
         //   }   extra???? mmm
           }        
		$sqlCommand = "{$ticketView}{$ticketOrder}";
        $sth2 = $db->prepare($sqlCommand);
        if ($needBind) {
            $sth2->bindValue(":id", $id);
        }
        $sth2->execute();
        requestsDisplay($sth2, $username, $password); //$viewers $view      //display first set of data
        echo "</form>";
} else {
    redirect("login_2.php"); //wrong file name
}
function requestsDisplay($statement, $username, $password){ //$viewers $view        //added by CK 3/10/14
    $db = get_database_connection(); 
	global $filename;
    while ($tickets = $statement->fetch()) {      //while there are still support tickets, Display the table
            $probID = $tickets['id'];
            $probNum = $tickets['request'];
            $sth = $db->prepare("SELECT * FROM requests WHERE id = :id");
            $sth->bindValue(":id", $probNum);
            $sth->execute();
            $problem = $sth->fetch();       //the list of problems in the database to compare to the ticket

            $sth2 = $db->prepare("SELECT * FROM teacher WHERE id = :id");
            $sth2->bindValue(":id", $tickets['teacher']);
            $sth2->execute();
            $teachers = $sth2->fetch();
            $teacher = $teachers['name'];               //display name of teacher's ticket
            if ($_SESSION['name'] == $teacher) {
                $teacher = "Me";
            }

            $urgency = $tickets['urgency'];         //urgency level of the ticket
            if ($urgency == 1) {
                $urgLevel = "High";
            } else if ($urgency == 2) {
                $urgLevel = "Medium";
            } else {
                $urgLevel = "Low";
            }

            $statusLevel = $tickets['status'];              //status level of the ticket
            $statuses[0] = "Pending";
            $statuses[1] = "In Progress";
            $statuses[2] = "Completed";
            $status = $statuses[$statusLevel];              //display name of status
           
            if($statusLevel != 2){                  //if status is not completed, find it's ticket no.
                $ticks = $db->prepare("SELECT * FROM mainrequest ORDER BY id");
                $ticks->execute();
                $tickNum = 1;
                while(($ticket = $ticks->fetch()) && ($ticket['id'] != $probID)){       //while it is still checking and the current ticket is not up, add to tickno. counter
                    if($ticket['status']!=2){
                       $tickNum++;
                    }   
                }
            }else{ $tickNum = "--"; }           //already completed, no ticket number
            
            echo "<tr>";
                echo"<td>$tickNum</td>";
                echo"<td>$teacher</td>";
                echo"<td>{$problem['name']}</td>";
                echo"<td>{$tickets['notes']}</td>";
                echo"<td>$urgLevel</td>";
                echo"<td>{$tickets['date']}</td>";
                echo"<td>";
            if (is_req_admin($username, $password)) {             //ability to edit status level if admin
                echo "<form action={$filename} method='post'>";
                echo "<select name='statusChange'>";
                for($i = 0; $i <sizeof($statuses); $i++){           //pending, in progress, completed
                    echo "<option value='$i'";
                    if ($i == $statusLevel)  {      //select the ticket's current status level
                        echo " selected=selected";
                    }
                    echo ">" . $statuses[$i] . "</option>";                   
                }
                echo "</select>";
                echo "<input type='hidden' name='probID' value='" . $probID ."'>";       //hidden inputs for
																						//the viewtickets page
																					   //to have the correct
                echo "<input type='submit' name='statEdit' value='Submit'>";          //selections when page is refreshed
                echo "</form>";
            } else {
                echo $status;       //if not admin, just display ticket status level
           }            
            echo"</td>";
			echo"<td>";  //added by BM
		   $commentsName = $tickets['comments'];
			if (is_req_admin($username, $password)) {  //ability to add comment about status if admin
				echo "<form action ={$filename} method='post'>";
				echo "<input type='text' name='editComments' value='" . $commentsName . "'>";
				echo "<input type='hidden' name='probID' value='" . $probID ."'>";         //hidden inputs for
                                                                                          //the viewtickets page
                                                                                         //to have the correct
                echo "<input type='submit' name='addComments' value='Submit'>";         //selections when page is refreshed
                echo "</form>";
			} else {
				echo $commentsName; //if not admin, just display comments
			}
			echo"</td>";
            echo"</tr>";
       
        }
}
$db = null;
echo "</td></table>";
dohtml_footer(true);
?>