<?php
session_start();
include 'functions.php';
password_protect();

$db = get_database_connection();

if (isset($_POST['announcement']) && $_POST['announcement'] !== null) {
    if ($_POST['announcement'] !== "") {
        if ($_POST['grade'] == "Faculty")
            $code = 0;
        else if ($_POST['grade'] == "All Grades")
            $code = 1;
        else if ($_POST['grade'] == "Freshman-Sophomore-Junior")
            $code = 2;
        else if ($_POST['grade'] == "Sophomore-Junior-Senior")
            $code = 3;
        else if ($_POST['grade'] == "Freshman-Sophomore")
            $code = 4;
        else if ($_POST['grade'] == "Junior-Senior")
            $code = 5;
        else if ($_POST['grade'] == "Freshman")
            $code = 6;
        else if ($_POST['grade'] == "Sophomore")
            $code = 7;
        else if ($_POST['grade'] == "Junior")
            $code = 8;
        else if ($_POST['grade'] == "Senior")
            $code = 9;

        $query = $db->prepare("INSERT INTO announcements (teacher, date, grade, announcement, code) VALUES (:teacher, :date, :grade, :announcement, :code)");
        $query->bindValue(":teacher", $_SESSION['name']);
        $query->bindValue(":date", $_POST['date']);
        $query->bindValue(":grade", $_POST['grade']);
        $query->bindValue(":announcement", $_POST['announcement']);
        $query->bindValue(":code", $code);

        $query->execute();

        echo "<body bgcolor=#CCCCCC>";
        echo "<h1 align=center>Announcement Added</h1>";
    } else {
        echo "<body bgcolor=#CCCCCC>";
        echo "<h1 align=center>Add Announcement Failed</h1>";
        echo "<center>The announcement you tried to add was blank. Please try again.</center><br>";
    }
    echo "<center><a href=addannouncement.php>Add Another</a></center>";
} else if (isset($_POST['absentee1']) && $_POST['absentee1']) {
    $i = 1;
    $absentee = "absentee" . $i;
    $grade = "grade" . $i;
    do {
        $query = $db->prepare("INSERT INTO absentee (name, grade, teacher, date) VALUES (:name, :grade, :teacher, :date)");
        $query->bindValue(":name", $_POST[$absentee]);
        $query->bindValue(":grade", $_POST[$grade]);
        $query->bindValue(":teacher", $_SESSION['name']);
        $query->bindValue(":date", $_POST['date']);
        $query->execute();

        $i = $i + 1;
        $absentee = "absentee" . $i;
        $grade = "grade" . $i;
    } while (isset($_POST[$absentee]) && $_POST[$absentee]);
    echo "<body bgcolor=#CCCCCC>";
    echo "<h1 align=center>Absentee Added</h1>";
    echo "<center><a href=addabsentee.php>Add Another</a></center>";
} else if (isset($_POST['lockdown1']) && $_POST['lockdown1']) {
    $i = 1;
    $lockdown = "lockdown" . $i;
    $grade = "grade" . $i;
    
    $query = $db->prepare("INSERT INTO lockdown (name, grade, teacher, date) VALUES (:name, :grade, :teacher, :date)");
    $query->bindValue(":name", $_SESSION['name']);
    $query->bindValue(":grade", $_POST[$grade]);
    $query->bindValue(":teacher", $_SESSION['name']);
    $query->bindValue(":date", $_POST['date']);
    $query->execute();

    do {
        $query = $db->prepare("INSERT INTO lockdown (name, grade, teacher, date) VALUES (:name, :grade, :teacher, :date)");
        $query->bindValue(":name", $_POST[$lockdown]);
        $query->bindValue(":grade", $_POST[$grade]);
        $query->bindValue(":teacher", $_SESSION['name']);
        $query->bindValue(":date", $_POST['date']);
        $query->execute();

        $i = $i + 1;
        $lockdown = "lockdown" . $i;
        $grade = "grade" . $i;
    } while (isset($_POST[$lockdown]) && $_POST[$lockdown]);
    echo "<body bgcolor=#CCCCCC>";
    echo "<h1 align=center>Lockdown Added</h1>";
    echo "<center><a href=addlockdown.php>Add Another</a></center>";
} else if (isset($_POST['late1']) && $_POST['late1']) {
    $i = 1;
    $late = "late" . $i;
    $period = "period" . $i;
    $minutes = "minutes" . $i;
    $grade = "grade" . $i;
    do {
        $query = $db->prepare("INSERT INTO late (name, grade, teacher, date, period, minutes) VALUES (:name, :grade, :teacher, :date, :period, :minutes)");
        $query->bindValue(":name", $_POST[$late]);
        $query->bindValue(":grade", $_POST[$grade]);
        $query->bindValue(":teacher", $_SESSION['name']);
        $query->bindValue(":date", $_POST['date']);
        $query->bindValue(":period", $_POST[$period]);
        $query->bindValue(":minutes", $_POST[$minutes]);
        $query->execute();

        $i = $i + 1;
        $late = "late" . $i;
        $period = "period" . $i;
        $minutes = "minutes" . $i;
        $grade = "grade" . $i;
    } while (isset($_POST[$late]) && $_POST[$late]);
    echo "<body bgcolor=#CCCCCC>";
    echo "<h1 align=center>Late Added</h1>";
    echo "<center><a href=addlate.php>Add Another</a></center>";
} else if (isset($_POST['violation1']) && $_POST['violation1']) {
    $i = 1;
    $name = "name" . $i;
    $violation = "violation" . $i;
    $grade = "grade" . $i;
    $notes = "notes" . $i;
    do {
        $query = $db->prepare("INSERT INTO dress (name, grade, teacher, violation, date, notes) VALUES (:name, :grade, :teacher, :violation, :date, :notes)");
        $query->bindValue(":name", $_POST[$name]);
        $query->bindValue(":grade", $_POST[$grade]);
        $query->bindValue(":teacher", $_SESSION['name']);
        $query->bindValue(":violation", $_POST[$violation]);
        $query->bindValue(":date", $_POST['date']);
        $query->bindValue(":notes", $_POST[$notes]);
        $query->execute();

        $i = $i + 1;
        $name = "name" . $i;
        $violation = "violation" . $i;
        $grade = "grade" . $i;
        $notes = "notes" . $i;
    } while (isset($_POST[$name]) && $_POST[$name]);
    echo "<body bgcolor=#CCCCCC>";
    echo "<h1 align=center>Violation Added</h1>";
    echo "<center><a href=adddress.php>Add Another</a></center>";
} else if (isset($_POST['newpassword']) && $_POST['newpassword']) {
    if ($_POST['newpassword'] == $_POST['confirmnewpassword']) {
		if ($_SESSION['isTeacher']) {
			$query = $db->prepare("UPDATE teacher SET password=:password WHERE username=:username");
			$query->bindValue(":password", md5($_POST['newpassword']));
			$query->bindValue(":username", $_SESSION['username']);
			$query->execute();
		}else{ 
			$query = $db->prepare("UPDATE student SET password=:password WHERE username=:username");
			$query->bindValue(":password", md5($_POST['newpassword']));
			$query->bindValue(":username", $_SESSION['username']);
			$query->execute();
		}

        //Update the password
        $_SESSION['password'] = md5($_POST['newpassword']);
        echo "<body bgcolor=#CCCCCC>";
        //echo $_SESSION['password'];
		echo "<h1 align=center>Password Changed</h1>";
    } else {
        redirect("chgpass.php");
    }
} else if (isset($_POST['startDate']) && $_POST['startDate']) {
    $curDate = strToTime($_POST['startDate']);
    $endDate = strToTime($_POST['endDate']);
    if (isset($_POST['skipList'])){
        $skipDates = $_POST['skipList'];
    } else {
        $skipDates = "";
    }

    $letterDay;
    $charNum = ord($_POST['letterDay']);
    $extraAdded = false;

    if (($charNum >= 65 && $charNum <= 72) || $charNum == 88) //A-H or X
        $letterDay = chr($charNum);
    else {
        $letterDay = "A";
        $charNum = 65;
    }
    while ($curDate <= $endDate) {
        $dateStr = date('Y-m-d', $curDate);
        //If it is not the weekend and it is not a skip day ...
        if ((date("D", $curDate) != "Sun") && (date("D", $curDate) != "Sat") && ($skipDates == null || array_search($dateStr, $skipDates) === false)) {

            //See if there was already the date in the calendar
            $dateQuery = $db->prepare("SELECT * FROM calendar WHERE date=:date");
            $dateQuery->bindValue(":date", $dateStr);
            $dateQuery->execute();

            //There was ... tell the user
            if ($dateQuery->rowCount() != 0) {
                $extraAdded = true;
            }

            //There wasn't ... all is good!
            else {
                //Insert the day in the calendar
                $dayInsert = $db->prepare("INSERT INTO calendar (date, letter) VALUES (:date, :letter)");
                $dayInsert->bindValue(":date", $dateStr);
                $dayInsert->bindValue(":letter", $letterDay);
                $dayInsert->execute();

                //See if we need to add auto schedule rooms
                $autoQuery = $db->prepare("SELECT * FROM autoroomschedule WHERE letter=:letter");
                $autoQuery->bindValue(":letter", chr($charNum));
                $autoQuery->execute();

                //We have results! Add them one by one to the roomschedule
                while ($auto = $autoQuery->fetch()) {
                    $roomSchedule = $db->prepare("INSERT INTO roomschedule (teacher, date, number, room) VALUES (:teacher, :date, :number, :room)");
                    $roomSchedule->bindValue(":teacher", $auto['teacher']);
                    $roomSchedule->bindValue(":date", $dateStr);
                    $roomSchedule->bindValue(":number", $auto['number']);
                    $roomSchedule->bindValue(":room", $auto['room']);
                    $roomSchedule->execute();
                }
            }

            //If the number is greater than 'H' set it back to 'A'
            if ((++$charNum) > 72)
                $charNum = 65;
            $letterDay = chr($charNum);
        }
        //Increment one day
        $curDate = mkTime(0, 0, 0, date("m", $curDate), date("d", $curDate) + 1, date("Y", $curDate));
    }
    echo "<body bgcolor=#CCCCCC>";
    echo "<h1 align=center>Day(s) Added</h1><center>";
    if (isset($extraAdded) && $extraAdded) {
        echo "Warning: You attempted to add days that already existed in the calendar. They were not added.<br />";
    }
    echo "<a href=addcalendar.php>Add More</a></center>";
} else if (isset($_POST['removeDate']) && $_POST['removeDate']) {
    $rDate = strToTime($_POST['removeDate']);
    echo "<body bgcolor=#CCCCCC>";
    $statement = $db->prepare("SELECT * FROM calendar WHERE date=:date");
    $statement->bindValue(":date", date('Y-m-d', $rDate));
    $statement->execute();
    if ($statement->rowCount() != 0) {
        //Delete the date from the calendar
        $deleteQuery = $db->prepare("DELETE FROM calendar WHERE date=:date");
        $deleteQuery->bindValue(":date", date('Y-m-d', $rDate));
        $deleteQuery->execute();
        
        //Get all the days after this day. We need to shift them back one
        $subDaysQuery = $db->prepare("SELECT * FROM calendar WHERE date>:date");
        $subDaysQuery->bindValue(":date", date('Y-m-d', $rDate));
        $subDaysQuery->execute();
        
        while ($row = $subDaysQuery->fetch()) {
            //Get the old letter
            $oldLetterNum = ord($row['letter']);
            //Set the new letter to one less
            $newLetterNum = $oldLetterNum - 1;
            
            while ($newLetterNum < 65)
                $newLetterNum += 8;
            
            //Update the new letter
            $newLetter = chr($newLetterNum);
            
            //Update the database. Shifting back one letter day
            $calendarQuery = $db->prepare("UPDATE calendar SET letter=:letter WHERE id=:id");
            $calendarQuery->bindValue(":letter", $newLetter);
            $calendarQuery->bindValue(":id", $row['id']);
            $calendarQuery->execute();
        }
        
        //Now we need to shift the roomschedule back a day
        $roomAssignmentQuery = $db->prepare("SELECT * FROM roomschedule WHERE date>=:date ORDER BY date");
        $roomAssignmentQuery->bindValue(":date", date('Y-m-d', $rDate));
        $roomAssignmentQuery->execute();
        $nextCache = array(); //this will cache the day to next-day mappings for multiple assignments in the same day
        while ($row = $roomAssignmentQuery->fetch()) {
            $oldDate = strToTime($row['date']);
            if (isset($nextCache[$oldDate])){
                $newDate = $nextCache[$oldDate];
            } else {
                $newDate = $oldDate;
            }
            if (isset($newDate)) {//changed from (!($newdate))
                $newDate = $oldDate;
                //This loop sets $newDate to the first day in calendar following $oldDate, or to the day after the last day in calendar.
                do {
                    $newDate = mkTime(0, 0, 0, date("m", $newDate), date("d", $newDate) + 1, date("Y", $newDate));
                } while (($db->query("SELECT * FROM calendar WHERE date='" . date('Y-m-d', $newDate) . "'")->rowCount() == 0)
                && ($db->query("SELECT * FROM roomschedule WHERE date>='" . date('Y-m-d', $newDate) . "'")->rowCount() != 0));
                //In the latter case above, this moves $newDate past the weekend if it lands on one.
                while (date("D", $newDate) == "Sat" || date("D", $newDate) == "Sun")
                    $newDate = mkTime(0, 0, 0, date("m", $newDate), date("d", $newDate) + 1, date("Y", $newDate));
                $nextCache[$oldDate] = $newDate;
            }
            $roomSchedule = $db->prepare("UPDATE roomschedule SET date=:date WHERE id=:id");
            $roomSchedule->bindValue(":date", date('Y-m-d', $newDate));
            $roomSchedule->bindValue(":id", $row['id']);
            $roomSchedule->execute();
        }
        echo "<h1 align=center>Day Removed</h1>";
        echo "<center>Room assignments from the last calendar day have been advanced to the next<br>";
        echo "weekday. Please handle these as is appropriate for the case at hand.<br></center>";
    } else {
    //if ($roomAssignmentQuery->rowCount() == 0) { fixed? 2-5-12
        echo "<h1 align=center>Day Not Removed</h1><center>";
        echo "<center>The day did not exist to be removed.<br></center>";
    }
    echo "<center><a href=removecalendar.php>Remove More</a></center>";
} else if (isset($_POST['isLockdown']) && $_POST['isLockdown']) { //This is for a teacher in a lockdown with no students
    $query = $db->prepare("INSERT INTO lockdown (teacher, date) VALUES (:teacher, :date)");
    $query->bindValue(":teacher", $_SESSION['name']);
    $query->bindValue(":date", $_POST['date']);
    $query->execute();
    echo "<body bgcolor=#CCCCCC>";
    echo "<h1 align=center>Lockdown Added</h1>";
    echo "<center><a href=addlockdown.php>Add Another</a></center>";
}else if (isset($_POST['student']) && $_POST['student']!== null){
	$sid = $_POST['student'];
	$sql="SELECT * FROM student WHERE id=:sid";
	$query = $db->prepare($sql);
    $query->bindValue(":sid", $sid);
    $query->execute();
	$row = $query->fetch();
    if($row['id']==$_POST['student']){
		$student = $_POST['student'];
		$servhrs = $_POST['servicehours'];
		$servdate = $_POST['date'];
		$servagency = $_POST['agid'];
		$servnotes = $_POST['notes'];		
	    //check if id represents a person
    	$sql="INSERT INTO service (student, servicehours, date, agency, notes) VALUES (:student,:servhrs,:servdate,:servagency,:servnotes )";
		$query = $db->prepare($sql);
	    $query->bindValue(":student", $student);
	    $query->bindValue(":servhrs", $servhrs);
    	$query->bindValue(":servdate", $servdate);
    	$query->bindValue(":servagency", $servagency);
		$query->bindValue(":servnotes", $servnotes);
    	$query->execute();
		echo "<body bgcolor=#CCCCCC>";
		echo "<h1 align=center>Service Added</h1>";
		if (is_teacher($_SESSION['username'],$_SESSION['password'])) { echo "<center><a href=serviceReporting.php>Add Another</a></center>"; }
			else { echo "<center><a href=serviceReportPageS.php>Add Another</a></center>";}
	}else {
		echo "<body bgcolor=#CCCCCC>";
		echo "<h1 align=center>Add Service Failed</h1>";
		echo "<center>The Student ID you tried to add does not exist. Please try again.</center><br>";
	}
}else if (isset($_POST['agency']) && $_POST['agency']){
		$agencyName = $_POST['agency'];
		$sql="INSERT INTO agencies (name) VALUES (:name )";
		$query = $db->prepare($sql);
		$query->bindValue(":name", $agencyName);
		$query->execute();
		echo "<body bgcolor=#CCCCCC>";
		echo "<h1 align=center>Agency Added</h1>";
		if (is_teacher($_SESSION['username'],$_SESSION['password'])) { 
                    echo "<center><a href=addAgency.php>Add Another</a></center>"; }
		else {
		echo "<body bgcolor=#CCCCCC>";
		echo "<h1 align=center>Add Agency Failed</h1>";
		echo "<center>Please see Technology Support.</center><br>";
	}

} else { //tried to submit "nothing"
    echo "<body bgcolor=#CCCCCC>";
    echo "<h1 align=center>Failed</h1>";
    echo "<center>When adding an absentee, late or dress violation you must select a student.</center>";
}
echo "<br><center><a href=index.php>Home</a></center></body>";
$db = null;
?>
