<?php
//edited by Vincent Pillinger and Christian Kardish
//not finished may 15th 2013
session_start();
include 'functions_2.php'; 
password_protect();
error_reporting(0);
//require_once "Mail.php";

$db = get_database_connection();


$header = "ERROR NO INPUT";
$message = null; //message to be displayed in button
$link = null; //link for button
$warningMessage = null;
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

        if(isset($_POST['id'])){
            //delete the old announcement
          $query = $db->prepare("DELETE FROM announcements WHERE id=:id AND teacher=:teacher");
          $query->bindValue(":id", $_POST['id']);
          $query->bindValue(":teacher", $_SESSION['name']);
          $query->execute();
        }

        $query2 = $db->prepare("INSERT INTO announcements (teacher, date, grade, announcement, code) VALUES (:teacher, :date, :grade, :announcement, :code)");
        $query2->bindValue(":teacher", $_SESSION['name']);
        $query2->bindValue(":date", $_POST['date']);
        $query2->bindValue(":grade", $_POST['grade']);
        $query2->bindValue(":announcement", $_POST['announcement']);
        $query2->bindValue(":code", $code);

        $query2->execute();

        $header = "Annoucement Added";
    } else {

        $header = "Add Announcement Failed";
        $warningMessage = "The announcement you tried to add was blank. Please try again.";
    }
    $message = "Add Another";
    $link = "addannouncement_2.php";
} else if (isset($_POST["absentee1"]) && $_POST["absentee1"]) {
    $i = 1;
    $absentee = "absentee" . $i;
    $grade = "grade" . $i;
    do {
        $query = $db->prepare("INSERT INTO absentee (name, grade, teacher, date) VALUES (:name, :grade, :teacher, :date)");
        $query->bindValue(":name", $_POST[$absentee]);
        $query->bindValue(":grade", $_POST[$grade]);
        $query->bindValue(":teacher", $_SESSION["name"]);
        $query->bindValue(":date", $_POST["date"]);
        $query->execute();

        $i = $i + 1;
        $absentee = "absentee" . $i;
        $grade = "grade" . $i;
    } while (isset($_POST[$absentee]) && $_POST[$absentee]);

    $header = "Absentee Added";
    $message = "Add Another";
    $link = "addabsentee_2.php";
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

    $header = "Lockdown Added";
    $message = "Add Another";
    $link = "addlockdown_2.php";
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
    $header = "Late Added";
    $message = "Add Another";
    $link = "addlate_2.php";
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
    $header = "Violation Added";
    $message = "Add Another";
    $link = "adddress_2.php";
} else if (isset($_POST['newpassword']) && $_POST['newpassword']) {
    if ($_POST['newpassword'] == $_POST['confirmnewpassword']) {
        if ($_SESSION['isTeacher']) {
            $query = $db->prepare("UPDATE teacher SET password=:password WHERE username=:username");
            $query->bindValue(":password", md5($_POST['newpassword']));
            $query->bindValue(":username", $_SESSION['username']);
            $query->execute();
        } else {
            $query = $db->prepare("UPDATE student SET password=:password WHERE username=:username");
            $query->bindValue(":password", md5($_POST['newpassword']));
            $query->bindValue(":username", $_SESSION['username']);
            $query->execute();
        }

        //Update the password
        $_SESSION['password'] = md5($_POST['newpassword']);
        //echo $_SESSION['password'];
        $header = "Password Changed";
    } else {
        redirect("chgpass_2.php");
    }
} else if (isset($_POST['startDate']) && $_POST['startDate']) {
    $curDate = strToTime($_POST['startDate']);
    $endDate = strToTime($_POST['endDate']);
    if (isset($_POST['skipList'])) {
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
    $header = "Day(s) Added";
    if (isset($extraAdded) && $extraAdded) {
        $warningMessage = "Warning: You attempted to add days that already existed in the calendar. They were not added.";
    }
    $message = "Add More";
    $link = "addcalendar_2.php";
} else if (isset($_POST['removeDate']) && $_POST['removeDate']) {
    $rDate = strToTime($_POST['removeDate']);
    $statement = $db->prepare("SELECT * FROM calendar WHERE date=:date");
    $statement->bindValue(":date", date('Y-m-d', $rDate));
    $statement->execute();
    if ($statement->rowCount() != 0) {
 //Delete the date from the calendar
     //   $deleteQuery = $db->prepare("DELETE FROM calendar WHERE date=:date");
     //   $deleteQuery->bindValue(":date", date('Y-m-d', $rDate));
     //   $deleteQuery->execute();

        //Get all the days from this day.

        $subDaysQuery = $db->prepare("SELECT * FROM calendar WHERE date>=:date");
        $subDaysQuery->bindValue(":date", date('Y-m-d', $rDate));
        $subDaysQuery->execute();

        while ($row = $subDaysQuery->fetch()) {
            $oldDate = strToTime($row['date']);
			$newDate = mkTime(0, 0, 0, date("m", $oldDate), date("d", $oldDate) + 1, date("Y", $oldDate));
            //In the latter case above, this moves $newDate past the weekend if it lands on one.
            while (date("D", $newDate) == "Sat" || date("D", $newDate) == "Sun")
				$newDate = mkTime(0, 0, 0, date("m", $newDate), date("d", $newDate) + 1, date("Y", $newDate));
			
      //Get the old letter
//            $oldLetterNum = ord($row['letter']);
            //Set the new letter to one less
  //          $newLetterNum = $oldLetterNum - 1;

    //        while ($newLetterNum < 65)
      //          $newLetterNum += 8;

            //Update the new letter
        //    $newLetter = chr($newLetterNum);
            //Update the database. Shifting back one letter day
            $calendarQuery = $db->prepare("UPDATE calendar SET date=:date WHERE id=:id");
            $calendarQuery->bindValue(":date", date('Y-m-d', $newDate));
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
            if (isset($nextCache[$oldDate])) {
                $newDate = $nextCache[$oldDate];
            } else {
                $newDate = $oldDate;
            }
            if (isset($newDate)) {//changed from (!($newdate))
                $newDate = $oldDate;
                //This loop sets $newDate to the first day in calendar following $oldDate, or to the day after the last day in calendar.
                do {
                    $newDate = mkTime(0, 0, 0, date("m", $newDate), date("d", $newDate) + 1, date("Y", $newDate));
                } while (($db->query("SELECT * FROM calendar WHERE date='" . date('Y-m-d', $newDate) . "'")->rowCount() == 0) && ($db->query("SELECT * FROM roomschedule WHERE date>='" . date('Y-m-d', $newDate) . "'")->rowCount() != 0));
                //In the latter case above, this moves $newDate past the weekend if it lands on one.
                while (date("D", $newDate) == "Sat" || date("D", $newDate) == "Sun")
                    $newDate = mkTime(0, 0, 0, date("m", $newDate), date("d", $newDate) + 1, date("Y", $newDate));
                $nextCache[$oldDate] = $newDate;
            }
			$rooms = array("C1", "F1", "C2", "F2", "C4", "F4", "C5", "F5", "C6/7", "F6/7", "C7/8", "F7/8", "C9", "F9", "C10", "F10");
            for ($i = 0; $i < sizeof($rooms); $i = $i + 1) {
				$roomSchedule = $db->prepare("UPDATE roomschedule SET date=:date WHERE id=:id and room=:room");
				$roomSchedule->bindValue(":date", date('Y-m-d', $newDate));
				$roomSchedule->bindValue(":id", $row['id']);
				$roomSchedule->bindValue(":room", $rooms[$i]);
				$roomSchedule->execute();
			}
            //$roomSchedule = $db->prepare("UPDATE roomschedule SET date=:date WHERE id=:id");
            //$roomSchedule->bindValue(":date", date('Y-m-d', $newDate));
            //$roomSchedule->bindValue(":id", $row['id']);
            //$roomSchedule->execute();
//            $roomSchedule = $db->prepare("UPDATE roomschedule SET date=:date WHERE id=:id");
  //          $roomSchedule->bindValue(":date", date('Y-m-d', $newDate));
    //        $roomSchedule->bindValue(":id", $row['id']);
      //      $roomSchedule->execute();
        }
        $header = "Day Removed";
        
        $warningMessage = "Room assignments from the last calendar day have been advanced to the next<br>"
           . "weekday. Please handle these as is appropriate for the case at hand.";
    } else {
        //if ($roomAssignmentQuery->rowCount() == 0) { fixed? 2-5-12
        $header =  "Day Not Removed";
        $warningMessage = "The day did not exist to be removed.";
    }
    $message = "Remove More";
    $link = "removecalendar_2.php";
} else if (isset($_POST['isLockdown']) && $_POST['isLockdown']) { //This is for a teacher in a lockdown with no students
    $query = $db->prepare("INSERT INTO lockdown (name, grade, teacher, date) VALUES (:name, :grade, :teacher, :date)");
    $query->bindValue(":name", $_SESSION['name']);
    $query->bindValue(":grade", 0);         //0 is the default grade for a teacher
    $query->bindValue(":teacher", $_SESSION['name']);
    $query->bindValue(":date", $_POST['date']);
    $query->execute();
    
    $header = "Lockdown Added";
    $message = "Add Another";
    $link = "addlockdown_2.php";
} else if (isset($_POST['student']) && $_POST['student'] !== null) {
    $sid = $_POST['student'];
    $sql = "SELECT * FROM student WHERE id=:sid";
    $query = $db->prepare($sql);
    $query->bindValue(":sid", $sid);
    $query->execute();
    $row = $query->fetch();
    if ($row['id'] == $_POST['student']) {
        $student = $_POST['student'];
        $servhrs = $_POST['servicehours'];
        $servdate = $_POST['date'];
        $servagency = $_POST['agid'];
        $servnotes = $_POST['notes'];
		//check values
		//echo $student.$servhrs.$servdate.$servagency.$servnotes;
				
        //check if id represents a person
        $sql = "INSERT INTO service (student, servicehours, date, agency, notes) VALUES (:student,:servhrs,:servdate,:servagency,:servnotes )";
        $query = $db->prepare($sql);
        $query->bindValue(":student", $student);
        $query->bindValue(":servhrs", $servhrs);
        $query->bindValue(":servdate", $servdate);
        $query->bindValue(":servagency", $servagency);
        $query->bindValue(":servnotes", $servnotes);
        $query->execute();
        
        $header = "Service Added";
        if (is_teacher($_SESSION['username'], $_SESSION['password'])) {
            $message = "Add Another";
            $link = "serviceReporting_2.php";
        } else {
            $message = "Add Another";
            $link = "serviceReportPageS_2.php";
        }
    } else {
        $message = "Add Service Failed";
        $warningMessage ="The Student ID you tried to add does not exist. Please try again.";
    }  

} else if (isset($_POST['agency']) && $_POST['agency']) {
    $agencyName = $_POST['agency'];
	$agencyName = addslashes($agencyName);
    $sql = "INSERT INTO agencies (name) VALUES (:name )";
    $query = $db->prepare($sql);
    $query->bindValue(":name", $agencyName);
    $query->execute();
    $header = "Agency Added";
    if (is_teacher($_SESSION['username'], $_SESSION['password'])) {
        $message = "Add Another";
        $link = "addAgency_2.php";
    } else {
        $header = "Add Agency Failed";
        $warningMessage = "Please see Technology Support.";
    }
    
} else if(isset($_GET['problem']) && $_GET['problem']){            //adding a new teacher support ticket
	$id = $_GET['teacher'];                                        //added by CK 3/10/14
    $sql = "SELECT * FROM teacher WHERE id=:id";
    $query = $db->prepare($sql);
    $query->bindValue(":id", $id);
    $query->execute();
    $row = $query->fetch();
    //check if id represents a person
    if ($row['id'] == $_GET['teacher']) {
        $teacher = $_GET['teacher'];
        $date = $_GET['date'];
        $problem = $_GET['problem'];
        $urgency = $_GET['urgency'];
        $notes = $_GET['notes'];
        $query = $db->prepare("INSERT INTO support (teacher, problem, urgency, notes, date) VALUES (:teacher, :problem, :urgency, :notes, :date)");
        $query->bindValue(":teacher", $teacher);
        $query->bindValue(":problem", $problem);
        $query->bindValue(":urgency", $urgency);
        $query->bindValue(":notes", $notes);
        $query->bindValue(":date", $date);
        $query->execute();
        
$statement = $db->prepare("SELECT * FROM teacher WHERE id=" . $teacher);
$statement->execute();
$row = $statement->fetch();

$statement = $db->prepare("SELECT * FROM problems WHERE id=" . $problem);
$statement->execute();
$rowproblem = $statement->fetch();

if($urgency==3)
	$urgency="Low";
else if($urgency==2)
	$urgency="Medium";
else if ($urgency==1)
	$urgency="High";

$to = "mjacobs@holyghostprep.org"; 
$subject = "Support Ticket Submitted by " . $row['name'];
$message    = "From: " . $row['name'] . "\r\n Issue with: " . $rowproblem['name'] . "\r\n Priority: " . $urgency . "\r\n" . $notes;
$headers = "From: ". $row['username'] . "@holyghostprep.org" . "\r\n" . "Reply-To: " . $row['username'] . "@holyghostprep.org";

mail($to, $subject, $message, $headers);
/*
$from    = "support@holyghostprep.org";  
$to      = "technology@holyghostprep.org";
$replyto = $row['username'] . "@holyghostprep.org";
$subject = "Support Ticket Submitted by " . $row['name'];
$body    = "From: " . $row['name'] . "\n\n Issue with: " . $rowproblem['name'] . "\n\n Priority: " . $urgency . "\n\n" . $notes;
$smtpinfo["host"] = "ssl://smtp.gmail.com";  
$smtpinfo["port"] = "465";  
$smtpinfo["auth"] = true;  
$smtpinfo["username"] = "support@holyghostprep.org";  
$smtpinfo["password"] = "support123";
$headers = array ('From' => $from, 'Reply-To' => $replyto, 'To' => $to,'Subject' => $subject);
$smtp = &Mail::factory('smtp', $smtpinfo );
$mail = $smtp->send($to, $headers, $body);  
*/
        $header = "Support Ticket Submitted.";
        $statement = $db->prepare("SELECT * FROM support");
        $statement->execute();
        $tickNum = 0;
        while($ticket = $statement->fetch()){       //display current ticket number for ticket
            if($ticket['status']!=3){
                $tickNum++;
            }
        }
        $warningMessage = "You are ticket number " . $tickNum . ".";
        $message = "Add Another Support Ticket";
        $link = "support.php";
    } 
    
}else if (isset($_POST['newProblem']) && $_POST['newProblem']) {           //add new type of support problem by admin
    $problemName = $_POST['newProblem'];                                    //added by CK 3/10/14
    $problems = $db->prepare("SELECT * FROM problems");
    $problems->execute();
    $numProbs = 1;
    while($row = $problems->fetch()){ $numProbs++; }
    $sql = "INSERT INTO problems (name, id) VALUES (:name, :id)";
    $query = $db->prepare($sql);
    $query->bindValue(":name", $problemName);
    $query->bindValue(":id", $numProbs);
    $query->execute();
    $header = "Type of Problem Added";
    if (is_teacher($_SESSION['username'], $_SESSION['password'])) {
        $message = "Add Another";
        $link = "addProblem.php";
    } else {
        $header = "Add Problem Failed";
        $warningMessage = "Please see Technology Support.";
    }
    
}else if(isset($_GET['request']) && $_GET['request']){            //adding a new teacher support ticket
    $id = $_GET['teacher'];                                        //added by CK 3/10/14
    $sql = "SELECT * FROM teacher WHERE id=:id";
    $query = $db->prepare($sql);
    $query->bindValue(":id", $id);
    $query->execute();
    $row = $query->fetch();
    //check if id represents a person
    if ($row['id'] == $_GET['teacher']) {
        $teacher = $_GET['teacher'];
        $date = $_GET['date'];
        $request = $_GET['request'];
        $urgency = $_GET['urgency'];
        $notes = $_GET['notes'];        
        $query = $db->prepare("INSERT INTO mainrequest (teacher, request, urgency, notes, date) VALUES (:teacher, :request, :urgency, :notes, :date)");
        $query->bindValue(":teacher", $teacher);
        $query->bindValue(":request", $request);
        $query->bindValue(":urgency", $urgency);
        $query->bindValue(":notes", $notes);
        $query->bindValue(":date", $date);
        $query->execute();
        
$statement = $db->prepare("SELECT * FROM teacher WHERE id=" . $teacher);
$statement->execute();
$row = $statement->fetch();

$statement = $db->prepare("SELECT * FROM requests WHERE id=" . $request);
$statement->execute();
$rowproblem = $statement->fetch();

if($urgency==3)
	$urgency="Low";
else if($urgency==2)
	$urgency="Medium";
else if ($urgency==1)
	$urgency="High";

$to = "twoods@holyghostprep.org,rmalley@holyghostprep.org"; 
$subject = "Maintenance Request Submitted by " . $row['name'];
$message    = "From: " . $row['name'] . "\r\n Request with: " . $rowproblem['name'] . "\r\n Priority: " . $urgency . "\r\n" . $notes;
$headers = "From: ". $row['username'] . "@holyghostprep.org" . "\r\n" . "Reply-To: " . $row['username'] . "@holyghostprep.org";

mail($to, $subject, $message, $headers);

/*$from    = "support@holyghostprep.org";  
$to      = "twoods@holyghostprep.org,rmalley@holyghostprep.org";
$replyto = $row['username'] . "@holyghostprep.org";
$subject = "Maintenance Request Submitted by " . $row['name'];
$body    = "From: " . $row['name'] . "\n\n Request with: " . $rowproblem['name'] . "\n\n Priority: " . $urgency . "\n\n" . $notes;
$smtpinfo["host"] = "ssl://smtp.gmail.com";  
$smtpinfo["port"] = "465";  
$smtpinfo["auth"] = true;  
$smtpinfo["username"] = "support@holyghostprep.org";
$smtpinfo["password"] = "support123";
$headers = array ('From' => $from, 'Reply-To' => $replyto, 'To' => $to,'Subject' => $subject);
$smtp = &Mail::factory('smtp', $smtpinfo );
$mail = $smtp->send($to, $headers, $body);  
*/
        $header = "Request Submitted.";
        $statement = $db->prepare("SELECT * FROM mainrequest");
        $statement->execute();
        $tickNum = 0;
        while($ticket = $statement->fetch()){       //display current ticket number for ticket
            if($ticket['status']!=2){
                $tickNum++;
            }
        }
        $warningMessage = "You are ticket number " . $tickNum . ".";
        $message = "Add Another Request Ticket";
        $link = "maintenancerequest.php";
    } 
    
}else if (isset($_POST['link']) && $_POST['text']) {           //add new link
    $text = $_POST['text'];
	$link = $_POST['link'];
	$grade = $_POST['grade'];
    $sql = "INSERT INTO links (text,link,grade) VALUES (:text, :link, :grade)";
    $query = $db->prepare($sql);
    $query->bindValue(":text", $text);
    $query->bindValue(":link", $link);
	$query->bindValue(":grade", $grade);
    $query->execute();
    $header = "Link Added";
	if (is_teacher($_SESSION['username'], $_SESSION['password'])) {
        $message = "Add Another";
        $link = "editlinks_2.php";
    } else {
        $header = "Add Problem Failed";
        $warningMessage = "Please see Technology Support.";
    }
} else { //tried to submit "nothing"
    $header = "Failed";
    $warningMessage = "When filling out this form, be sure to complete all required fields.";
}
 
$db = null;
include 'includeInc_2.php';
dohtml_header($header);
echo "<table class=centered>";
if (isset($warningMessage)) {
    echo "<tr><td>" . $warningMessage . "</td></tr>";
}
if (isset($message) && isset($link))
    makeButton($message, $link);
homeLogout();
echo "</table>";
dohtml_footer(true);
?>