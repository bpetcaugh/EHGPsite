<?php
session_start();
include 'functions_2.php';
$db = get_database_connection();


include 'includeInc_2.php';
dohtml_header("Total hours in EHGP by Class");
?>

<body>
    <?php
    echo "<br /><hr />";

    echo "<table class=centered border=1>";
    echo "<tr><th>Hours</th><th>Notes for Class of 2015</th><th>" . "Records " . "</th></tr>";
	$query = $db->prepare("SELECT * FROM service WHERE verified='1' AND (student>=15000 AND student<16000) ORDER BY student ASC");
    $query->execute();//*AND WHERE verified=1 OR notes LIKE '%bibl%'(notes LIKE '%uto%') AND 
  	$hours=0;
    while ($row = $query->fetch()) {
 			echo "<tr><td>" . "Total hours = " . $hours . "</td>";
			echo "<td>" . $row['notes'] . "</td><td>" . $row['servicehours'] . "</td></tr>\n";
			$hours=$hours+$row['servicehours'];
	}
	echo "<tr><td>" . "total hours = " . $hours . "</td></tr>";
	
	echo "<tr><th>Hours</th><th>Notes for Class of 2016</th><th>" . "Records " . $query->rowCount() . "</th></tr>";
	$query = $db->prepare("SELECT * FROM service WHERE verified='1' AND (student>=16000 AND student<17000) ORDER BY student ASC");
    $query->execute();//*AND WHERE verified=1 OR notes LIKE '%bibl%'(notes LIKE '%uto%') AND 
  	$hours=0;
    while ($row = $query->fetch()) {
 			echo "<tr><td>" . "Total hours = " . $hours . "</td>";
			echo "<td>" . $row['notes'] . "</td><td>" . $row['servicehours'] . "</td></tr>\n";
			$hours=$hours+$row['servicehours'];
	}
	echo "<tr><td>" . "total hours = " . $hours . "</td></tr>";
	
	echo "<tr><th>Hours</th><th>Notes for Class of 2017</th><th>" . "Records " . $query->rowCount() . "</th></tr>";
	$query = $db->prepare("SELECT * FROM service WHERE verified='1' AND (student>=17000 AND student<18000) ORDER BY student ASC");
    $query->execute();//*AND WHERE verified=1 OR notes LIKE '%bibl%'(notes LIKE '%uto%') AND 
  	$hours=0;
    while ($row = $query->fetch()) {
 			echo "<tr><td>" . "Total hours = " . $hours . "</td>";
			echo "<td>" . $row['notes'] . "</td><td>" . $row['servicehours'] . "</td></tr>\n";
			$hours=$hours+$row['servicehours'];
	}
	echo "<tr><td>" . "total hours = " . $hours . "</td></tr>";
	
	echo "<tr><th>Hours</th><th>Notes for Class of 2018</th><th>" . "Records " . $query->rowCount() . "</th></tr>";
	$query = $db->prepare("SELECT * FROM service WHERE verified='1' AND (student>=18000 AND student<19000) ORDER BY student ASC");
    $query->execute();//*AND WHERE verified=1 OR notes LIKE '%bibl%'(notes LIKE '%uto%') AND 
  	$hours=0;
    while ($row = $query->fetch()) {
 			echo "<tr><td>" . "Total hours = " . $hours . "</td>";
			echo "<td>" . $row['notes'] . "</td><td>" . $row['servicehours'] . "</td></tr>\n";
			$hours=$hours+$row['servicehours'];
	}
	echo "<tr><td>" . "total hours = " . $hours . "</td></tr>";
     
    $db = null;
    ?>
</table>
<table class="centered">
<?php
homeLogout();
?>
</table>
<?php 
dohtml_footer(true);
?>

