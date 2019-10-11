<?php
session_start();
include 'functions_2.php';
$db = get_database_connection();


include 'includeInc_2.php';
dohtml_header("Seniors who visited colleges");
?>

<body>
    <?php
    echo "<br><hr>";

    $query = $db->prepare("SELECT * FROM absentee WHERE notes like '%ll%' ORDER BY name ASC");
    $query->execute();

    echo "<table class=centered border=1>";
    echo "<tr><th>Name</th><th>Dates</th><th>College Absences</th></tr>";

    $count=0;
    $name="";
    while ($row = $query->fetch()) {
        if ($name==$row['name']){
		echo " & " . $row['date'];
		$count++;
	}
	else{
		if($count>0){
			echo "</td>";
		        echo "<td>" . $count . "</td></tr>";
		}
		echo "<tr><td>" . $row['name'] . "</td>";
        	echo "<td>" . $row['date'];
		$name=$row['name'];
		$count=1;	
	}
    }
    echo "</td>";
    echo "<td>" . $count . "</td></tr>";

    if ($query->rowCount() == 0)
        echo "<h3 class='centered'>No seniors this year.</h3>";

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

