<?PHP
include 'functions.php';

$db = get_database_connection();

$date=date('Y-m-d');
$tomorrow = mktime(0,0,0,date("m"),date("d"),date("Y"));

    $statement = $db->prepare("SELECT * FROM announcements WHERE date=:date");
    $statement->bindValue(":date", $date);
    $statement->execute();
	//$row1 = $statement->fetch()
    
//$result = mysql_query("SELECT * FROM announcements WHERE date='" . $date . "'");
$i=1;
while (!($row1 = $statement->fetch()))
{
	$tomorrow = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
	$date=date('Y-m-d', $tomorrow);

    $statement = $db->prepare("SELECT * FROM announcements WHERE date=:date");
    $statement->bindValue(":date", $date);
    $statement->execute();

	//$result = mysql_query("SELECT * FROM announcements WHERE date='" . $date . "'");
	$i++;
}

?> 


<html>
<head>
<style type="text/css">
</style>
</head>
<body bgcolor=#FFFF77> 

 
<table width="80%"> 

<tr><td><img src=holyghost.jpg></td>

<td><font size=7><center>Daily Announcements</center></font>


<?php
echo "<br><font size=6><center>" . date('l', strtotime($date)) . ", " . date('F jS', $tomorrow) . "</center></font></td>";
echo "</tr></table><hr>";

    $statement = $db->prepare("SELECT * FROM announcements WHERE date=:date AND grade<>'Faculty'");
    $statement->bindValue(":date", $date);
    $statement->execute();
	//$row1 = $statement->fetch()
//$result = mysql_query("SELECT * FROM announcements WHERE date='" . $date . "' AND grade<>'Faculty'");
//if($row = mysql_fetch_array($result))
if ($row1 = $statement->fetch())
{
    $statement = $db->prepare("SELECT * FROM announcements WHERE date=:date AND grade<>'Faculty' ORDER BY code");
    $statement->bindValue(":date", $date);
    $statement->execute();
	//$result = mysql_query("SELECT * FROM announcements WHERE date='" . $date . "' AND grade<>'Faculty' ORDER BY code");
	$i=0;
	while ($i!=$_GET['num'])
	{	
		//$row = mysql_fetch_array($result);
		$row1 = $statement->fetch();
		$i++;
	}
		echo "<br><br><font size=6>From: " . $row1['teacher'] . "<br>";
		echo "To: " . $row1['grade'] . "</font><br><br><font size=5>";
		echo ($row1['announcement']) . "</font><br><br>"; //deleted n12br beginning
}
else
	echo "<h3 align=center>No Announcements Today.</h3>";
//moved out of script

?>
<script>setTimeout("location.href = 'scrollingMMM2.php?num=<?PHP
if (($_GET['num']+1) > $statement->rowCount())
	echo 1;
else
	echo $_GET['num']+1;
?>'",4500);</script>
<?PHP
$db = null;
?>
<br><br>
<font size=1>Designed by Mr. Jacobs, Joe Wolfe '11, and Mr. Meistering</font>
</table>
</body>
</html>


Example #2 Counting rows returned by a SELECT statement


 For most databases, PDOStatement::rowCount() does not return the number of rows affected by a SELECT statement. Instead, use PDO::query() to issue a SELECT COUNT(*) statement with the same predicates as your intended SELECT statement, then use PDOStatement::fetchColumn() to retrieve the number of rows that will be returned. Your application can then perform the correct action. 


<?php
$sql = "SELECT COUNT(*) FROM fruit WHERE calories > 100";
if ($res = $conn->query($sql)) {

    /* Check the number of rows that match the SELECT statement */
  if ($res->fetchColumn() > 0) {

        /* Issue the real SELECT statement and work with the results */
         $sql = "SELECT name FROM fruit WHERE calories > 100";
       foreach ($conn->query($sql) as $row) {
           print "Name: " .  $row['NAME'] . "\n";
         }
    }
    /* No rows matched -- do something else */
  else {
      print "No rows matched the query.";
    }
}

$res = null;
$conn = null;
?> 


The above example will output:

 
apple
banana
orange
pear



 Report a bug

 See Also


¦PDOStatement::columnCount() - Returns the number of columns in the result set
¦PDOStatement::fetchColumn() - Returns a single column from the next row of a result set
¦PDO::query() - Executes an SQL statement, returning a result set as a PDOStatement object



 
PDOStatement->setAttributePDOStatement->nextRowset
--------------------------------------------------------------------------------
[edit] Last updated: Fri, 28 Oct 2011
  


add a noteUser Contributed NotesPDOStatement->rowCount


dcahh at gmx dot de19-Aug-2011 01:53
 
It's pretty obvious, but might save one or the other from bug tracking...
 
Alltough rowCount ist returned by the statement, one has to execute the statement before rowCount returns any results...
 
Does not work
 <?php
     $statement = $dbh->prepare('SELECT FROM fruit');
     $count = $statement->rowCount();
 ?>
 
Works
 <?php
     $statement = $dbh->prepare('SELECT FROM fruit');
     $statement->execute();
     $count = $statement->rowCount();
 ?> 