<?php 
	include 'functions.php';

	$db = get_database_connection();

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
<html>
    <head>
	<link rel="stylesheet" type="text/css" href="css.css" />
    </head>
    <body bgcolor=#CCCCCC>
		<center><h1>EHGP</h1></center>
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