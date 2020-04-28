<?PHP
// edited by vincent Pillinger
session_start();
include 'functions_2.php';
teacher_only();
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
        dohtml_header("Display of All Service");
?>
        <script type='text/javascript'>
            function refresh()
            {
                var formObject = document.forms['theForm'];
                formObject.action="serviceShow_2.php";
                formObject.submit();
            }
        </script>
		<br>
<?php 				   //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
        $date = date('Y-m-d');
        echo "<table class='centered'><tr><td>";
        echo "<h2>" . date('l', strtotime($date)) . "<br>" . $date . "</h2></td></tr>";
        homeLogoutService();
        echo "</table>";
?>		
		
		<table class='centered'><td>
        
		<form name='theForm' method='post' action='serviceShow_2.php'>
<?php 
	//Set up header: date, home page link, EHGP home page, Logout
	//$button = boldbuttons;
	//$pixels = 200;
	//print_header("Service Verify", $pixels, $button);
	//echo "";

//$sql = "UPDATE books SET title=?, author=? WHERE id=?"; $q->execute(array($title,$author,$id));  
	{ //of if SUBMIT
        //Set up query, only display unverified ones
		$verified = 0;	
		//$result = mysql_query("SELECT * FROM service WHERE verified = 0 ORDER by student");
		$servdb3 = $db->prepare("SELECT * FROM service ORDER by student");
		$servdb3->execute();
		//$result = mysql_query("SELECT * FROM service WHERE verified = 0 ORDER by student");
        //if ($row = mysql_fetch_array($result)) 
		if ($servdb3->rowCount()>0) 
		{
            //Table header
?>
			<table id ="customers" class='centered' border=1><tr><th>Class Number</th><th>First Name</th><th>Last Name</th><th>Grade</th><th>Date</th><th>Agency</th><th>Hours</th><th>Notes</th><th>Role</th><th>Verified</th></tr>
<?php
                //Set up more queries for table displays
                $i = 0;
                if (!isset($agid)) $agid = 0;
                //while ($row = mysql_fetch_array($result)) 
				while ($servdbrow2 = $servdb3->fetch())
				{
	                $sid = $servdbrow2['student'];
					$sql6 = "SELECT * FROM student WHERE id=:sid";
					$studb1 = $db->prepare($sql6);
					$studb1->bindvalue(":sid",$sid);
					$studb1->execute();
					$studbrow1 = $studb1->fetch();					

					$agidsel = $servdbrow2['agency'];
					$sql7 = "SELECT * FROM agencies WHERE id=:agidsel";
					$agdb1 = $db->prepare($sql7);
					$agdb1->bindvalue(":agidsel",$agidsel);
					$agdb1->execute();
					$agdbrow1 = $agdb1->fetch();
					$nameOfSelected = $agdbrow1['name'];
					
                    $i++;
					//Display table results
                    echo "<tr class=alt>";
?>
					<td><?php echo $studbrow1['id']; ?></td>
					<td><?php echo $studbrow1['firstname']; ?></td>
					<td><?php echo $studbrow1['lastname']; ?></td>
					<td><?php echo $studbrow1['grade']; ?></td>
					<td><?php echo $servdbrow2['date']; ?></td>
					<td><?php echo $nameOfSelected; ?></td>
<?php               //Not sure if the next two line are necessary, I just left them in in case
                    echo "<input type=hidden value='" . $agid . "' name='agid" . $i . "'>";
                    echo "<input type=hidden value='" . $teacherid . "' name=teacherid>";
?>
                    <td>
<?php 
					echo $servdbrow2['servicehours'];
					//$hours = $servdbrow2['servicehours'];//"hours$i";
                    //echo "<input type=text size=5 name='hours". $i ."' value='" . $servdbrow2['servicehours'] . "'><br><br>";
                    //NEED TO FIX IT SO THAT THE VALUE UPDATED INTO THE DATABASE IS THE PREVIOUS VALUE IF IT REMAINS UNTOUCHED!!!!
?>
					</td>
					<td>
<?php 				echo $servdbrow2['notes'];
					//echo $_POST["submit"] . $_POST["agid"] . $_POST["teacherid"] . $_POST["verfiedValue1"];
?>					</td>
					<td>
<?php
					$tempRole = $servdbrow2['role'];
					if ($tempRole == "L") echo "Leadership"; 
					else if ($tempRole == "B") echo "Both"; 
					else if ($tempRole == "I") echo "Initiative";
                    //Radio Box for Role in service, set them equal to either L, I or B
                    //Figured out double quotes would make the variable appear and I was doing INSERT instead of UPDATE for my queries
                    //echo "<input type='radio' value = 'L' name='role" . $i . "' >Leadership<br>"; 
	 				//echo "<input type='radio' value = 'I' name='role" . $i . "' > Initiative <br>"; 
	 				//echo "<input type='radio' value = 'B' name='role" . $i . "' > Both <br>"; 
?>					</td>
  		            <td>
<?php               
					$tempVerified = $servdbrow2['verified'];
					if ($tempVerified == 0) {
						echo "NOT yet Verified";
					} else {
						if ($tempVerified == 1) {
							echo "Verified";
						} else {
							echo "Rejected";
						}
					}		
						
					//Radio Box for Verification INSERT 1 for verified and 2 for not verified so that each request won't keep appearing even though its already been denied
                    //echo "<input type='radio' value = '1' name='verifiedValue" . $i . "' > Verified <br>"; 
					//echo "<input type='radio' value = '2' name='verifiedValue" . $i . "' > Rejected <br>"; 
?>     	           </td>
<?php
                	echo "</tr>";
	           } //while for table end
		   } //if data for table
?>
            </table>    <!-- service display table //-->
<?php
                echo "</table>"; //table that is the page?
                echo"";
           }
?>
<!--        <center><input type='submit' name='submit' value='submit'><br><br></center> //-->
		</form>
<?php
	} 
	else { //if isset
        redirect('login_2.php?serviceShow_2.php');
	} //if Session
}//if isset
$db = null;
echo "</form></td></table>";
dohtml_footer(true);
?>
        	
		
	