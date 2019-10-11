<html>
    <head>
        <script type="text/javascript">
			function refresh(form)
			{
				form.submit();
			}
		</script>
		<link rel="stylesheet" type="text/css" href="css.css" />
    </head>
    <body bgcolor=#CCCCCC>
		<center><h1>EHGP</h1></center>
		<center><a href=http://www.holyghostprep.org>Holy Ghost Prep Home Page</a></center>
<?php 
	include 'functions.php';

	$db = get_database_connection();

	$doneButtons = false;
	if (check_logged_in()) {
		$isTeacher = $_SESSION['isTeacher'];
		echo "<center><h3>Welcome " . $_SESSION['name'] . "</h3></center>";
		echo "<table border=0 align=center>";
		if ($isTeacher) { 
?>	
			<tr>
				<td align=center width=200px><a class='boldbuttons' href='login.php?announcement=1'><span>Add Announcement</span></a></td>
				<td align=center width=200px><a class="boldbuttons" href="readannouncements.php"><span>Read Announcements</span></a></td>
			</tr>
			<tr>
				<td align=center width=200px><a class="boldbuttons" href="login.php?absentee=1"><span>Add Absentee</span></a></td>
				<td align=center width=200px><a class="boldbuttons" href="viewabsentee.php"><span>View Absentees</span></a></td>
			</tr>
			<tr>
				<td align=center width=200px><a class="boldbuttons" href="login.php?late=1"><span>Add Late</span></a></td>
				<td align=center width=200px><a class="boldbuttons" href="viewlate.php"><span>View Lates</span></a></td>
			</tr>
			<tr>
				<td align=center width=200px><a class="boldbuttons" href="login.php?dress=1"><span>Add Dress Violation</span></a></td>
				<td align=center width=200px><a class="boldbuttons" href="viewdress.php"><span>View Dress Violations</span></a></td>
			</tr>
			<tr>
				<td align=center width=200px><a class="boldbuttons" href="login.php?lockdown=1"><span>Add Lockdown</span></a></td>
				<td align=center width=200px><a class="boldbuttons" href="viewlockdown.php"><span>View Lockdowns</span></a></td>
			</tr>
			<tr>
				<td align=center width=200px><a class="boldbuttons" href="login.php?test=1"><span>Test Calendar</span></a></td>
				<td align=center width=200px><a class="boldbuttons" href="login.php?scheduleRoom=1"><span>Schedule Computer Labs</span></a></td>
			</tr>
			<tr>
				<td align=center width=200px><a class="boldbuttons" href="serviceAgencies.php"><span>View Agency Activity</span></a></td> 
				<td align=center width=200px><a class="boldbuttons" href="login.php?scheduleMeeting=1"><span>Schedule Meeting Rooms</span></a></td>
			</tr>
<?php 
			if (is_admin($_SESSION['username'], $_SESSION['password'])){ 
				if (serv_admin_only()) {
?>					<tr>
						<td align=center width=200px><a class="boldbuttons" href="servindstu.php"><span>View Reported Service</span></a></td> 
						<td align=center width=200px><a class="boldbuttons" href="servindstuv.php"><span>View Verified Service</span></a></td> 
					</tr>
					<tr>
						<td align=center width=200px><a class="boldbuttons" href="serviceReporting.php"><span>Report Service</span></a></td> 
						<td align=center width=200px><a class="boldbuttons" href="serviceVerify.php"><span>Verify Reported Service</span></a></td> 
					</tr>
					<tr>
						<td align=center width=200px><a class="boldbuttons" href="addAgency.php"><span>Add Service Agency</span></a></td> 
						<td align=center width=200px><a class="boldbuttons" href="serviceShow.php"><span>Show All Service Records</span></a></td> 
					</tr>

<?php			} //service only
				if (super_admin_only()){
?>					<tr>
						<td align=center width=200px><a class="boldbuttons" href="login.php?calendar=1"><span>Add Calendar Days</span></a></td>
						<td align=center width=200px><a class="boldbuttons" href="login.php?rcalendar=1"><span>Remove Calendar Days</span></a></td>
					</tr>
<?php 			}//super only
			} //isAdmin
		}else {  //not a Teacher 
?>
			<tr>
				<td align=center width=200px><a class="boldbuttons" href="readannouncements.php"><span>Read Announcements</span></a></td>
				<td align=center width=200px><a class="boldbuttons" href="scheduleViewS.php"><span>Computer Lab Usage</span></a></td>
			</tr>
			<tr>
				<td align=center colspan=2><a class="boldbuttons" href="TimeSchedules.pdf"><span>Bell Schedules</span></a></td>
			</tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
			<tr>ALL service should be reported below, even service done through a school sponsored function.
			For school sponsored functions, such as the Cares Walk, the sponsoring teacher will verify your service, so 
			no Service Verification Form is needed to be turned in to Mr. Fitzpatrick. ALL other service reported online 
			must also have a Service Verification Form turned in to Mr. Fitzpatrick to verify the service performed. Note also that for service performed at the same site on multiple days, you need only enter the last date service was performed, enter the total hours for all dates, and submit the required Service Verification Form to Mr. Fitzpatrick.
                        </tr>
			<tr>
				<td align=center width=200px><a class="boldbuttons" href="serviceReportPageS.php"><span>Report Your Service</span></a></td> 
				<td align=center width=200px><a class="boldbuttons" href="servindstuaS.php"><span>View All Reported Service</span></a></td> 
			</tr>
			<tr>
				<td align=center width=200px><a class="boldbuttons" href="servindstuvS.php"><span>View Verified Service</span></a></td> 
				<td align=center width=200px><a class="boldbuttons" href="servindsturS.php"><span>View Rejected Service</span></a></td> 
			</tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
			<tr>
				<td align=center width=200px><a class="boldbuttons" href="http://www.holyghostprep.org/uploaded/documents/Service_Documents/CSPVerify.pdf"><span>Service Verification Form</span></a></td>
				<td align=center width=200px><a class="boldbuttons" href="http://www.holyghostprep.org/uploaded/documents/Service_Documents/ServiceWebsites.pdf"><span>Service Site Links</span></a></td>
			</tr>
			<tr>
				<td align=center width=200px><a class="boldbuttons" href="http://www.holyghostprep.org/uploaded/documents/Service_Documents/CSPproj0809.pdf"><span>Service Opportunities</span></a></td>
				<td align=center width=200px><a class="boldbuttons" href="http://www.holyghostprep.org/uploaded/documents/Service_Documents/CSPbro0809.pdf"><span>Service Handbook</span></a></td>
			</tr>
			<tr>
				<td align=center colspan=2><a class="boldbuttons" href="http://www.holyghostprep.org/page.cfm?p=298"><span>Christian Service Program Home Page</span></a></td>
			</tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
<?php 
		} //isTeacher
?>
		<tr>
			<td align=center colspan=2><a class="boldbuttons" href="logout.php"><span>Logout</span></a></td>
		</tr>
		<tr>
			<td align=center colspan=2><a href=chgpass.php>Change Password</a></td>
		</tr>
		</table>
<?php
		$doneButtons = true;
	} //logged in
	if (!$doneButtons) {
?>
		<table border=0 align=center>
		<tr>
			<td align=center width=200px><a class="boldbuttons" href="readannouncements.php"><span>Read Announcements</span></a></td>
		</tr>
		<tr>
			<td align=center colspan=2><a class="boldbuttons" href="login.php?home=1"><span>Login</span></a></td>
		</tr>
		</table>
		<br><br>
		
<?php 
	}
	
	//This puts the day, month, and year in seperate variables
	$day = date('d');
	$month = date('m');
	$year = date('Y');
	$day_of_week = date('D');

	//Here we generate the first day of the week
	switch($day_of_week)
	{
		case "Mon": $minus = 1; break;
		case "Tue": $minus = 2; break;
		case "Wed": $minus = 3; break;
		case "Thu": $minus = 4; break;
		case "Fri": $minus = 5; break;
		case "Sat": $minus = 6; break;
	}
	
	//This counts the days in the week, up to 7 and calendar days up to 28
	$day_count = 0;
	$cal_count = 0;
	
?>
		<table border=1 align=center>
		<tr><th width=90>Sunday</th><th width=90>Monday</th><th width=90>Tuesday</th><th width=90>Wednesday</th><th width=90>Thursday</th><th width=90>Friday</th><th width=90>Saturday</th></tr>
<?php
		//Keep going while there are days in the month or we haven't completed a full week
		while ($day_count < 7  && $cal_count < 28)
		{
			echo "<td valign=top>";
			$current = mktime(0, 0, 0, $month, $cal_count+$day-$minus, $year);
			if (date('d', $current) == date('d')){ 
				echo "<b>" . date('d') . "</b>";
			}else {
				echo date('d', $current) . "<br>";
			}
			
			$date = date("Y-m-d", $current);
			$sql = "SELECT * FROM calendar WHERE date=:date";
			$query = $db->prepare($sql);
			$query->bindValue(":date", $date);
			$query->execute();
			
			if ($query->rowCount() == 0){
				echo "<p></p>";
			}else {
				echo "<p>";
				echo $query->fetchObject()->letter;
				echo "</p>";
			}
			
			$query = null;
			echo "</td>";
			$day_count++;
			$cal_count++;
	
			//Make sure we start a new row every week
			if ($day_count > 6)
			{
				$day_count = 0;
				echo "</tr>";
			}
		}
$db = null;
?>
		</tr>
		</table>
	</body>
</html>