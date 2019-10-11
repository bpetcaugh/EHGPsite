<?PHP
session_start();
include 'functions.php';
teacher_only();
password_protect("login.php?scheduleMeeting=1");
$db = get_database_connection();
?>
<html>
<head>
<script type='text/javascript'>

    function refresh()
    {
        var formObject = document.forms['theForm']; //isnt theForm dead?
        formObject.submit();
    }
    function checkMeetingRoomDate(){
        var date = document.formDate.newDate.value;    //Check the value of the DATE variable
        if (!isValidDate(date)) {                
            alert("Please enter a valid date in the format YYYY-MM-DD.");                
            return;                
        }        
    }

    function isValidDate(s) {
        if (s.length != 10) return false;
        var year = parseInt(s.substring(0,4), 10);
        //alert("Please enter a valid year.");
        if (isNaN(year) || year < 1000)
            return false;
        if (s.charAt(4) != '-')
            return false;
        var month = parseInt(s.substring(5,7), 10);
        //alert("Please enter a valid month.");
        if (isNaN(month) || month < 0 || month > 12)
            return false;
        var maxDay;
        switch (month) {
            case 1: case 3: case 5: case 7: case 8: case 10: case 12:
                                        maxDay = 31;
                                        break;
                                    case 4: case 6: case 9: case 11:
                                                    maxDay = 30;
                                                    break;
                                                case 2:
                                                    if (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0))
                                                        maxDay = 29;
                                                    else
                                                        maxDay = 28;
                                                    break;
                                                default:
                                                    return false;
                                            }
                                            if (s.charAt(7) != '-')
                                                return false;
                                            var day = parseInt(s.substring(8,10), 10);
                                            if (isNaN(day) || day < 0 || day > maxDay)
                                                return false;
                                            return true;
                                        }
</script>
<link rel="stylesheet" type="text/css" href="css.css" />
</head>
<body bgcolor=#CCCCCC>
	<h1 align="center">Schedule Meeting Rooms</h1><br>

    <form name='formDate' action='scheduleMeeting.php' method='post'>
        <?php
        if (isset($_POST['changeDate'])) {
            $date = $_POST['newDate'];
            echo "<center>Date:<input type=text name='newDate' value='" . $date . "' onBlur='checkMeetingRoomDate(document.formDate.newDate)'><br>"; //Change datesAdd.startDate
        } else if (isset($_POST['date'])) {
            $date = $_POST['date'];
            echo "<center>Date:<input type=text name='newDate' value='" . $date . "' onBlur='checkMeetingRoomDate(document.formDate.newDate)'><br>"; //Change datesAdd.startDate
        } else {
            $tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
            $date = date('Y-m-d', $tomorrow);
            echo "<center>Date:<input type=text name='newDate' value='" . date('Y-m-d', $tomorrow) . "' onBlur='checkMeetingRoomDate(document.formDate.newDate)'><br>"; //Change datesAdd.startDate
        }
        ?>
        <input type='submit' name='changeDate' value='Change Date'><br><br>
    </form>
    <?php
    echo $date;
    echo "</select>&nbsp&nbsp<a href=index.php>Home</a>&nbsp&nbsp<a href=logout.php>Logout</a></center><hr></form>";

    if (isset($_POST['signout'])) {
        //Room that are being signed out out by the teacher
        $room = $_POST['room'];
        //The number of people that are being signed out by the teacher
        $number = $_POST['num'];

        //This query gets the total count of other teachers and the current teacher
        $totalQuery = $db->prepare("SELECT (SELECT SUM(number) FROM roomschedule WHERE date=:date AND room=:room AND teacher=:teacher) AS thisTeacher, (SELECT SUM(number) FROM roomschedule WHERE date=:date AND room=:room AND teacher!=:teacher) AS otherTeachers");
        $totalQuery->bindValue(":date", $date);
        $totalQuery->bindValue(":room", $room);
        $totalQuery->bindValue(":teacher", $_SESSION['name']);
        $totalQuery->execute();

        $totalResult = $totalQuery->fetchObject();
        $totalQuery = null;

        //Teacher wants to delete the room schedule
        if ($number < 1) {
            //Delete the room schedule from the database
            $deleteQuery = $db->prepare("DELETE FROM roomschedule WHERE date=:date AND room=:room AND teacher=:teacher");
            $deleteQuery->bindValue(":date", $date);
            $deleteQuery->bindValue(":room", $room);
            $deleteQuery->bindValue(":teacher", $_SESSION['name']);
            $deleteQuery->execute();

            $deleteQuery = null;
        }
        //Teacher wants to check out the room
        else if (($totalResult->otherTeachers + $number) <= 100) {
            //Either update the existing value or insert the new request in the database
            //Update
            if (isset($totalResult->thisTeacher)) {
                $updateQuery = $db->prepare("UPDATE roomschedule SET number=:number WHERE date=:date AND room=:room AND teacher=:teacher");
                $updateQuery->bindValue(":number", $number);
                $updateQuery->bindValue(":date", $date);
                $updateQuery->bindValue(":room", $room);
                $updateQuery->bindValue(":teacher", $_SESSION['name']);
                $updateQuery->execute();

                $updateQuery = null;
            }
            //Insert
            else {
                $insertQuery = $db->prepare("INSERT INTO roomschedule (teacher, date, number, room) VALUES (:teacher, :date, :number, :room)");
                $insertQuery->bindValue(":teacher", $_SESSION['name']);
                $insertQuery->bindValue(":date", $date);
                $insertQuery->bindValue(":number", $number);
                $insertQuery->bindValue(":room", $room);
                $insertQuery->execute();

                $insertQuery = null;
            }
        }
        //Not enough space
        else {
            echo "There is only so much space";
        }
    }
    ?>

    <table border=0 align=center>
        <tr><td>Please enter the number of students you need to reserve the meeting room for, then click "Sign Out"</td></tr>
    </table>
    <table border="1" align=center>
        <tr>
            <th></th>
            <th align=center>Sager</th>
            <th align=center>Father Brown</th>
            <th align=center>Brottier</th>
            <th align=center>Laval</th>
            
    <th align=center>Sawicki</th>
    <th align=center>Maletz</th>
            <th align=center>Spiritan Dining</th>
            <th align=center>Spiritan Conference</th>

        </tr>
        <?php
        $rooms = array("S0", "H0", "B0", "L0", "D0", "G0", "X0", "Y0",
            "S1", "H1", "B1", "L1", "D1", "G1", "X1", "Y1",
            "S2", "H2", "B2", "L2", "D2", "G2", "X2", "Y2",
            "S3", "H3", "B3", "L3", "D3", "G3", "X3", "Y3",
            "S4", "H4", "B4", "L4", "D4", "G4", "X4", "Y4",
            "S5", "H5", "B5", "L5", "D5", "G5", "X5", "Y5",
            "S6/7", "H6/7", "B6/7", "L6/7", "D6/7", "G6/7", "X6/7", "Y6/7",
            "S7/8", "H7/8", "B7/8", "L7/8", "D7/8", "G7/8", "X7/8", "Y7/8",
            "S9", "H9", "B9", "L9", "D9", "G9", "X9", "Y9",
            "S10", "H10", "B10", "L10", "D10", "G10", "X10", "Y10",
            "SA", "HA", "BA", "LA", "DA", "GA", "XA", "YA",
            "SA2", "HA2", "BA2", "LA2", "DA2", "GA2", "XA2", "YA2",
            "SA3", "HA3", "BA3", "LA3", "DA3", "GA3", "XA3", "YA3",
            "SA4", "HA4", "BA4", "LA4", "DA4", "GA4", "XA4", "YA4",
            "SA5", "HA5", "BA5", "LA5", "DA5", "GA5", "XA5", "YA5",
            "SE", "HE", "BE", "LE", "DE", "GE", "XE", "YE",
            "SE2", "HE2", "BE2", "LE2", "DE2", "GE2", "XE2", "YE2",
            "SE3", "HE3", "BE3", "LE3", "DE3", "GE3", "XE3", "YE3",
            "SE4", "HE4", "BE4", "LE4", "DE4", "GE4", "XE4", "YE4",
            "SE5", "HE5", "BE5", "LE5", "DE5", "GE5", "XE5", "YE5",
            "SE6", "HE6", "BE6", "LE6", "DE6", "GE6", "XE6", "YE6",
            "SE7", "HE7", "BE7", "LE7", "DE7", "GE7", "XE7", "YE7",
            "SE8", "HE8", "BE8", "LE8", "DE8", "GE8", "XE8", "YE8");
        $periods = array("7:30am - 8:00am",
            "8:00am - 8:45am",
            "8:45am - 9:45am",
            "9:45am - 10:15am",
            "10:15am - 11:00am",
            "11:00am - 11:45am",
            "11:45am - 12:30pm",
            "12:30pm - 1:05pm",
            "1:05pm - 1:50pm",
            "1:50pm - 2:30pm",
            "2:30pm - 3:00pm",
            "3:00pm - 3:30pm",
            "3:30pm - 4:00pm",
            "4:00pm - 4:30pm",
            "4:30pm - 5:00pm",
            "5:00pm - 5:30pm",
            "5:30pm - 6:00pm",
            "6:00pm - 6:30pm",
            "6:30pm - 7:00pm",
            "7:00pm - 7:30pm",
            "7:30pm - 8:00pm",
            "8:00pm - 8:30pm",
            "8:30pm - 9:00pm");
        $j = 0;
        for ($i = 0; $i < sizeof($rooms); $i = $i + 1) {
            if ($i % 8 == 0) {
                echo "<tr><td align=center>" . $periods[$j] . "</td>";
                $j = $j + 1;
            }
            $roomQuery = $db->prepare("SELECT * FROM roomschedule WHERE date=:date and room=:room");
            $roomQuery->bindValue(":date", $date);
            $roomQuery->bindValue(":room", $rooms[$i]);
            $roomQuery->execute();

            echo "<td align=center>";
            $num = 0;
            while ($row = $roomQuery->fetch())
                echo $row['teacher'] . " " . $row['number'] . "<br>";
            echo "<form action=scheduleMeeting.php method='post'><input type=text size=3 name=num><input type=hidden name=room value=" . $rooms[$i] . "><input type=hidden name=date value=" . $date . "><input type='submit' name='signout' value='Sign Out'></td></form>";
            if (($i + 1) % 8 == 0)
                echo "</tr>";
        }
        ?>
    </table>
    <font size=1>Written by Mr. Meistering and Nick Gardiner, modeled after code by Mr. Jacobs	</font>
<?php $db = null; ?>
</body>
</html>