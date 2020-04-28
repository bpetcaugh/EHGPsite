<?php
session_start();
include 'functions.php';
teacher_only();
password_protect("login.php?scheduleRoom=1");
$db = get_database_connection();
?>
<html>
<head>
<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
	function show_alert() 
	{ 
	 	alert("There are only 25 computers available. Please choose a lower number or a different lab."); 
	}
</script>
<link rel="stylesheet" type="text/css" href="css.css" />
</head>
<body bgcolor=#CCCCCC>
<h1 align="center">Room Schedule</h1><br>
<?php
	$date = date('Y-m-d'); //establish a default for weekends
    if (isset($_POST['mydate']))
        $date = $_POST['mydate'];
    else if (isset($_POST['date']))
        $date = $_POST['date'];
    else {
        $date = date('Y-m-d');
        //$query = $db->query("SELECT MAX(date) AS maxDate FROM calendar ORDER BY date");
        //$date = $query->fetch()->maxDate;
		//Jacobs code piece
		//$today = mktime(0,0,0,date("m"),date("d"),date("Y"));
		//$date=date('Y-m-d', $tomorrow);
		
    }

    $query = $db->prepare("SELECT * FROM calendar WHERE date=:date LIMIT 1");
    $query->bindValue(":date", $date);
    $query->execute();

    $row = $query->fetch();
    echo "<h2 align=center>" . $date . "<br>" . $row['letter'] . " Day</h2><br><center><form name='theForm' action=scheduleRoom.php method='post'><select name='mydate' onchange='refresh()'>";

    $rows = $db->query("SELECT * FROM calendar ORDER BY date");
    foreach ($rows as $row) {
        echo "<option value=" . $row['date'];
        if ($row['date'] == $date) {
            echo " selected=selected";
        }
        echo ">" . $row['date'] . " " . $row['letter'] . " Day</option>";
    }
    echo "</select>&nbsp&nbsp<a href=index.php>Home</a>&nbsp&nbsp<a href=logout.php>Logout</a></center><hr></form>";

    //Signout request
    if (isset($_POST['signout'])) {
        //The number of people the teacher is signing out
        $number = $_POST['num'];
        //The room the the teacher is signing out
        $room = $_POST['room'];

        //This query gets the total count of other teachers and the current teacher
        $totalQuery = $db->prepare("SELECT (SELECT SUM(number) FROM roomschedule WHERE date=:date AND room=:room AND teacher=:teacher) AS thisTeacher, (SELECT SUM(number) FROM roomschedule WHERE date=:date AND room=:room AND teacher!=:teacher) AS otherTeachers");
        $totalQuery->bindValue(":date", $date);
        $totalQuery->bindValue(":room", $room);
        $totalQuery->bindValue(":teacher", $_SESSION['name']);
        $totalQuery->execute();

        $totalResult = $totalQuery->fetchObject();
        $totalQuery = null;

        //If the number is less than or equal to zero delete it
        if ($number <= 0){
            $deleteQuery = $db->prepare("DELETE FROM roomschedule WHERE date=:date AND room=:room AND teacher=:teacher");
            $deleteQuery->bindValue(":date", $date);
            $deleteQuery->bindValue(":room", $room);
            $deleteQuery->bindValue(":teacher", $_SESSION['name']);
            $deleteQuery->execute();
            
            $deleteQuery = null;
        }
        //Sees if there is room is left in the lab by adding the students from other teachers and getting the differece between the new request and the old value
        else if (($totalResult->otherTeachers + $totalResult->thisTeacher + $number) <= 25) {
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
        } else {
            echo "<script>show_alert();</script>";
			echo "<center>There are only 25 computers.</center>";
        }
    }
?>

    <table border=0 align=center>
        <tr><td>Enter the number of computers you would like to reserve in the appropriate box, then click "Sign Out"</td></tr>
    </table>
    <table border="1" align=center>
        <tr>
            <th></td>
            <th align=center>Cornwells Lab</th>
            <th align=center>Founders Lab</th>
        </tr>
        <?php
        $rooms = array("C1", "F1", "C2", "F2", "C4", "F4", "C5", "F5", "C6/7", "F6/7", "C7/8", "F7/8", "C9", "F9", "C10", "F10");
        $periods = array("1", "2", "4", "5", "6/7", "7/8", "9", "10");
        $j = 0;
        for ($i = 0; $i < sizeof($rooms); $i = $i + 1) {
            if ($i % 2 == 0) {
                echo "<tr><td align=center>Period " . $periods[$j] . "</td>";
                $j = $j + 1;
            }
            $rows = $db->prepare("SELECT * FROM roomschedule WHERE date=:date and room=:room");
            $rows->bindValue(":date", $date);
            $rows->bindValue(":room", $rooms[$i]);
            $rows->execute();

            echo "<td align=center>";
            $num = 0;
            while ($row = $rows->fetch())
                echo $row['teacher'] . " " . $row['number'] . "<br>";
            echo "<form action=scheduleRoom.php method='post'><input type=text size=3 name=num><input type=hidden name=room value=" . $rooms[$i] . "><input type=hidden name=date value=" . $date . "><input type='submit' name='signout' value='Sign Out'></td></form>";
            if (($i + 1) % 2 == 0)
                echo "</tr>";
        }
        ?>
    </table>
	<?php $db = null; ?>
</body>
</html>
