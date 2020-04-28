<?php
        session_start();
        include 'functions.php';
	password_protect("login.php?scheduleViewS.php");
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
	</script>
	<link rel="stylesheet" type="text/css" href="css.css" />

</head>

<body bgcolor=#CCCCCC>
	<h1 align="center">Computer Lab Usage</h1>

    <?php
	$date = date('Y-m-d'); //establish a default for weekends
    if (isset($_POST['mydate']) && $_POST['mydate'])
        $date = $_POST['mydate'];
    else if (isset($_POST['date']) && $_POST['date'])
        $date = $_POST['date'];
    else {
        $date = date('Y-m-d');
    }

    $query = $db->prepare("SELECT * FROM calendar WHERE date=:date LIMIT 1");
    $query->bindValue(":date", $date);
    $query->execute();

    $row = $query->fetch();
    echo "<h2 align=center>" . $date . ", \"" . $row['letter'] . "\" Day</h2><center>";
	echo "<form name='theForm' action=scheduleViewS.php method='post'><select name='mydate' onchange='refresh()'>";

    $rows = $db->query("SELECT * FROM calendar ORDER BY date");
    foreach ($rows as $row) {
        echo "<option value=" . $row['date'];
        if ($row['date'] == $date) {
            echo " selected=selected";
        }
        echo ">" . $row['date'] . " " . $row['letter'] . " Day</option>";
    }
    echo "</select>&nbsp&nbsp<a href=index.php>Home</a>&nbsp&nbsp<a href=logout.php>Logout</a></center></form>";

    ?>
<!-- above removed -- only needed for signout //-->

    <table border="1" align=center>
        <tr>
            <th></th>
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
            echo "<form action=scheduleViewS.php method='post'><input type=text STYLE='background-color: #CCCCCC; border=0;' size=3 name=num><input type=hidden name=room value=" . $rooms[$i] . "><input type=hidden name=date value=" . $date . "></td></form>";
            if (($i + 1) % 2 == 0)
                echo "</tr>";
        }
        $db = null; 
		?>
    </table>
	</body>
</html>