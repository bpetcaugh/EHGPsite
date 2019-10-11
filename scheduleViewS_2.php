<?php

//edited by Vincent Pillinger
session_start();
include 'functions_2.php';
//password_protect("login_2.php?scheduleViewS_2.php"); password protect not needed
$db = get_database_connection();
include 'includeInc_2.php';
dohtml_header("Computer Lab Usage");
?>
<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>

<?php

$date = date('Y-m-d'); //establish a default for weekends
if (isset($_POST['mydate']) && $_POST['mydate'])
    $date = $_POST['mydate'];
else if (isset($_POST['date']) && $_POST['date'])
    $date = $_POST['date'];
else {
    $date = date('Y-m-d');
        $query = $db->prepare("SELECT * FROM calendar WHERE date=:date");
        $query->bindValue(":date", $date);
        $query->execute();
		//if it doesn't find today in the calendar:
		if (!$row = $query->fetch()){
			$query = $db->prepare("SELECT * FROM calendar WHERE date>:date ORDER BY date ASC");
			$query->bindValue(":date", $date);
			$query->execute();
			if ($row = $query->fetch()){
				$date = $row['date'];
			}
			else {
					$query = $db->prepare("SELECT * FROM calendar WHERE date<:date ORDER BY date DESC");
					$query->bindValue(":date", $date);
					$query->execute();
					if ($row = $query->fetch()){
						$date = $row['date'];
					}
					else{
						$date = "None";
					}
				}
			}
		}
	if($date != "None"){
    $query = $db->prepare("SELECT * FROM calendar WHERE date=:date LIMIT 1");
$query->bindValue(":date", $date);
$query->execute();

$row = $query->fetch();
echo "<form name='theForm' action=scheduleViewS_2.php method='post'>";
echo "<table class='centered'>";
homeLogout();
echo "</table><table class='centered'><tr><td><h2>" . $date . ", \"" . $row['letter'] . "\" Day</h2></td></tr>";
echo "</table><table class='centered'><tr><td><select name='mydate' onchange='refresh()'>";

$rows = $db->query("SELECT * FROM calendar ORDER BY date DESC");
foreach ($rows as $row) {
    echo "<option value=" . $row['date'];
    if ($row['date'] == $date) {
        echo " selected=selected";
    }
    echo ">" . $row['date'] . " " . $row['letter'] . " Day</option>";
}
echo "</td></tr></table></form>";
?>


<table class='centered' border=1>
    <tr>
		<th>Period</th>
        <th>Founders 301</th>
        <th>Founders 302</th>
    </tr>
    <?php

    $rooms = array("E1", "F1", "E2", "F2", "EF4", "F4", "E5", "F5", "E6/7", "F6/7", "E7/8", "F7/8", "E9", "F9", "E10", "F10");
    $periods = array("1", "2", "4", "5", "6/7", "7/8", "9", "10");
    $j = 0;
    for ($i = 0; $i < sizeof($rooms); $i = $i + 1) {
        if ($i % 2 == 0) {
            echo "<tr><td>Period " . $periods[$j] . "</td>";
            $j = $j + 1;
        }
        $rows = $db->prepare("SELECT * FROM roomschedule WHERE date=:date and room=:room");
        $rows->bindValue(":date", $date);
        $rows->bindValue(":room", $rooms[$i]);
        $rows->execute();

        echo "<td>";
        $num = 0;
        $blank = true;
        while ($row = $rows->fetch()) {
            $blank = false;
            echo $row['teacher'] . " " . $row['number'] . "<br>";
        }
        if ($blank)
            echo "---";
        if (($i + 1) % 2 == 0)
            echo "</tr>";
    }
	}
	else{
		echo "<table class='centered'border=0><tr><td>There are no calendar days.</td></tr></table>";		
	}
    $db = null;
    echo "</table>";
    dohtml_footer(true);
    ?>

