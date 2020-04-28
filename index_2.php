<?php  //redone to add functions for buttons and admin index by mmm 7-25-15
session_start();
include 'functions_2.php';
//if(isMobile())
//    header('Location: https://ehgp.holyghostprep.org/m/index_2.php');     //change for electronichgp CK
$db = get_database_connection(); 

$doneButtons = false; 
$title="EHGP"; 
include 'includeInc_2.php';
dohtml_header("EHGP"); 

               
if (check_logged_in()) {
    $isTeacher = $_SESSION['isTeacher'];
    endAndBeginTable();
	insertInRow("<h3>Welcome " . $_SESSION['name']."</h3>");
	endAndBeginTable();

    if (is_admin($_SESSION['username'], $_SESSION['password'])) { //changed by CK 2/2014, mmm 7-25-15 
		makeTwoButtons("Change My Password","chgpass_2.php","Administrator Tools Menu","indexAdmin_2.php");//added 7-24-15 mmm
	} else if ($isTeacher){
		makeButton("Change My Password","chgpass_2.php");//mmm changed 7-31-15
	}	

	if ($isTeacher){ 
		//makeButton("Change My Password","chgpass_2.php");
		makeTwoButtons("Request Tech Help","support.php","View Support Tickets","viewtickets.php");
        makeTwoButtons("Facility Maintenance Request","maintenancerequest.php","View Maintenance Requests","viewmaintenance.php");
		makeButton("Add/Read Announcements","announcements.php");
		//makeTwoButtons("Add Announcement","login_2.php?announcement=1","Read Announcements","readannouncements_2.php");
		makeTwoButtons("Add Absentee","login_2.php?absentee=1","View Absentees","viewabsentee_2.php");
		makeTwoButtons("Add Late","login_2.php?late=1","View Lates","viewlate_2.php");
		makeTwoButtons("Add a Violation","login_2.php?dress=1","View Violations","viewdress_2.php");
		//makeTwoButtons("Add Lockdown","login_2.php?lockdown=1","View Lockdowns","viewlockdown_2.php");
		makeTwoButtons("Schedule Computer Labs","login_2.php?scheduleRoom=1","Schedule Meeting Rooms","login_2.php?scheduleMeeting=1");
		makeTwoButtons("Test Calendar","login_2.php?test=1","View Parent-Teacher Schedule","parteach-ts_2.php");
        makeTwoButtons("Student Directory","directory_2.php","NHS Tutor Availability","https://docs.google.com/spreadsheets/d/15webY16mjp2SZ2bTY7fOVud15e7JeqG4cp8ijI2eBZg/edit?usp=sharing");
		makeButton("Observed Behaviors Report","https://forms.gle/4Er31Q5giiTfrSKe9");
		makeButton("Bell Schedules","BellSchedules.pdf");
     } else {  //not a Teacher but logged in
            makeButton("Announcements","announcements.php");
			//makeButton("Read Announcements","readannouncements_2.php");
			makeButton("View My Schedule","stusched_2.php");
			makeButton("Computer Lab Usage","scheduleViewS_2.php");
            makeButton("Student Directory","directory_2.php");
			makeButton("Bell Schedules","BellSchedules.pdf");
			//tableRowSpace();
			//makeButton("Parent-Teacher Night Signup","par-teach-night_3.php");
			//insertInRow("Parent-Teacher Night Appointment Signup");
			//insertInRow("[button available after each completed progress period]");//change what's commented for the night itself 7-30-15
			tableRowSpace();
		    //makeButton("Request an NHS Tutor","NHSTutorRequest_2.php");
			makeButton("Register Vehicle/Request Permit","parkingpermitInstruct_2.php");
    		makeButton("See Vehicle(s)/Permit(s)","viewmypermit_2.php");
			makebutton("Request an NHS tutor", "NHSTutorRequest_2.php");
  
     } //isTeacher
     makeButton("Service Menu","indexService_2.php");
     makeButton("Logout","logout_2.php");
	echo "<br />";
	tableRowSpace();
	
	//Display student links next
	if (!is_teacher($_SESSION['username'], $_SESSION['password'])){
		$grade = get_student_grade($_SESSION['username']);
		switch($grade){
			case 9:
				$grade = "grade=9 OR grade=1 OR grade=2";
				break;
			case 10:
				$grade = "grade=10 OR grade=1 OR grade=2";
				break;
			case 11:
				$grade = "grade=11 OR grade=1 OR grade=3";
				break;
			case 12:
				$grade = "grade=12 OR grade=1 OR grade=3";
				break;
		}
		
		$query = $db->prepare("SELECT * FROM links WHERE " . $grade . " ORDER BY grade");
		$query->execute();
		echo "<table align=center style='margin-left: auto; margin-right: auto;'>";
		while ($row = $query->fetch()) {
			//echo "<tr><td align=center><a href=" . $row["link"] . " target=_blank>" . $row["text"] . "</a></td></tr>";
			$buttonName = "" . $row["text"];//added 03-26-15
			$buttonLink = "" . $row["link"];//added 03-26-15
			//echo $buttonName . $buttonLink;//added 03-26-15
			makeButton($buttonName,$buttonLink);//added 03-26-15
		}
		echo "</table>";
	}
	
	echo "<br /><br />";
    echo "</table>";
    $doneButtons = true;
} //logged in

//when not logged in
if (!$doneButtons) {
    echo "<table class='centered' align=center style='margin-left: auto; margin-right: auto;'>";
	//makeButton("Read Announcements","readannouncements_2.php");
	makeButton("Announcements","announcements.php");
	makeButton("Bell Schedules","BellSchedules.pdf");
    makeButton("Computer Lab Usage","scheduleViewS_2.php");
	//makeButton("Semester 1 Exam Schedule","2017-2018S1ExamSchedule.pdf");
    tableRowSpace();
	makeButton("Login","login_2.php?home=1");
    echo "<br />";
	tableRowSpace();
	echo "</table>";
	
}

//Display calendar at bottom below

//This puts the day, month, and year in seperate variables
$day = date('d');
$month = date('m');
$year = date('Y');
$day_of_week = date('D');

//Here we generate the first day of the week
$minus = 0;
switch ($day_of_week) {
    case "Mon": $minus = 1;
        break;
    case "Tue": $minus = 2;
        break;
    case "Wed": $minus = 3;
        break;
    case "Thu": $minus = 4;
        break;
    case "Fri": $minus = 5;
        break;
    case "Sat": $minus = 6;
        break;
}

//This counts the days in the week, up to 7 and calendar days up to 28
$day_count = 0;
$cal_count = 0;
?>
<table border=1  class="calendar">
    <tr><th class="weekDays">Sunday</th><th class="weekDays">Monday</th><th class="weekDays">Tuesday</th><th class="weekDays">Wednesday</th><th class="weekDays">Thursday</th><th class="weekDays">Friday</th><th class="weekDays">Saturday</th></tr>
    <?php
    //Keep going while there are days in the month or we haven't completed a full week
    echo "<tr>";
    while ($day_count < 7 && $cal_count < 28) {
        echo "<td class='valign'>";
        $current = mktime(0, 0, 0, $month, $cal_count + $day - $minus, $year);
        if (date('d', $current) == date('d')) {
            echo "<b>" . date('d') . "</b>";
        } else {
            echo date('d', $current) . "<br>";
        }

        $date = date("Y-m-d", $current);
        $sql = "SELECT * FROM calendar WHERE date=:date";
        $query = $db->prepare($sql);
        $query->bindValue(":date", $date);
        $query->execute();

        if ($query->rowCount() == 0) {
            echo "<p></p>";
        } else {
            echo "<p>";
            echo $query->fetchObject()->letter;
            echo "</p>";
        }

        $query = null;
        echo "</td>";
        $day_count++;
        $cal_count++;

        //Make sure we start a new row every week
        if ($day_count > 6) {
            $day_count = 0;
            echo "</tr>";
            if($cal_count <28){
                echo "<tr>";
            }
        }
    }
    $db = null;
    ?>
</table>
<?php
dohtml_footer(true);
?>