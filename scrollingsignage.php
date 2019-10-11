<html>
<head>

<style type="text/css">

</style>
<?php
$con=mysql_connect("localhost","ehgp_test","hactc2003");
mysql_select_db("ehgp_test", $con);
$date=date('Y-m-d');
$tomorrow = mktime(0,0,0,date("m"),date("d"),date("Y"));
$result = mysql_query("SELECT * FROM announcements WHERE date='" . $date . "'");
$i=1;
while (mysql_num_rows($result)==0)
{
	$tomorrow = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
	$date=date('Y-m-d', $tomorrow);
	$result = mysql_query("SELECT * FROM announcements WHERE date='" . $date . "'");
	$i++;
}

?> 
</head>

<body> 
        
<?php
$result = mysql_query("SELECT * FROM announcements WHERE date='" . $date . "' AND grade<>'Faculty'");
if($row = mysql_fetch_array($result))
{
	$result = mysql_query("SELECT * FROM announcements WHERE date='" . $date . "' AND grade<>'Faculty' ORDER BY code");
	$i=0;
	while ($i!=$_GET['num'])
	{	
		$row = mysql_fetch_array($result);
		$i++;
	}

//       echo "<br><font size=6><center>" . date('l', strtotime($date)) . ", " . date('F jS', $tomorrow) . "</center></font></td>";
  //     echo "</tr></table><hr>";
		echo "<center><font size=5>Daily Announcements for " .  date('l', strtotime($date)) . ", " . date('F jS', $tomorrow)  . " -- To: " . $row['grade'] . " -- From: " . $row['teacher'] . "<br /></font><br /><font size=5>";
		//echo "To: " . $row['grade'] . "</font><br><br><font size=5>";
		echo ($row['announcement']) . "</font></center><br><br>"; //deleted n12br beginning
}
else
	echo "<h3 align=center>No Announcements Today.</h3>";
//moved out of script

?>
<script>setTimeout("location.href = 'scrollingsignage.php?num=<?PHP
if (($_GET['num']+1) > mysql_num_rows($result))
	echo 1;
else
	echo $_GET['num']+1;
?>'",4500);</script>
<?PHP
mysql_free_result($result);
mysql_close($con);

?>
</table>
</body>
</html>