<?php
session_start();
include 'functions_2.php';
$db = get_database_connection();


include 'includeInc_2.php';
dohtml_header("Total hours in EHGP");
?>

<body>
    <?php
    echo "<br /><hr />";

    $query = $db->prepare("SELECT * FROM service WHERE verified='1' ORDER BY student ASC");
    $query->execute();//*AND WHERE verified=1 OR notes LIKE '%bibl%'(notes LIKE '%uto%') AND 

    echo "<table class=centered border=1>";
    echo "<tr><th>Hours</th><th>Notes</th><th>" . "Records " . $query->rowCount() . "</th></tr>";

    $count=0;
	$hours=0;
    $name="";
    while ($row = $query->fetch()) {
       // if ($name==$row['name']){
			echo "<tr><td>" . "total hours = " . $hours . "</td>";
			echo "<td>" . $row['notes'] . "</td><td>" . $row['servicehours'] . "</td></tr>\n";
		//	$count++;
			$hours=$hours+$row['servicehours'];
		}
	//	else{
	//		if($count>0){
	//			echo "</td>";
	//	        echo "<td>" . $count . "</td></tr>";
	//		}
			echo "<tr><td>" . "total hours = " . $hours . "</td></tr>";
        	//echo "<td>" . $row['date'];
			//$name=$row['name'];
			//$count=1;	
	//	}
    //}
    //echo "</td>";
   // echo ;

    if ($query->rowCount() == 0)
        echo "<h3 class='centered'>No tutoring this year.</h3>";

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

