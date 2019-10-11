<?php
session_start();
include 'functions_2.php';
$db = get_database_connection();

if (isset($_GET['remove']) && check_logged_in()) {
    $query = $db->prepare("DELETE FROM announcements WHERE id=:id AND teacher=:teacher");
    $query->bindValue(":id", $_GET['remove']);
    $query->bindValue(":teacher", $_SESSION['name']);
    $query->execute();

    if ($query->rowCount() != 1)
        die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    else
        redirect("readannouncements_2.php?date=" . $_GET['date']);
}
if (isset($_GET['edit']) && check_logged_in()) {
    $announcements = $db->prepare("SELECT * FROM announcements WHERE id=:id AND teacher=:teacher");
    $announcements->bindValue(":id", $_GET['edit']);
    $announcements->bindValue(":teacher", $_SESSION['name']);
    $announcements->execute();    
    
    if ($announcements->rowCount() != 1){
        die($announcements->rowCount()." Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    }else{
        $row = $announcements -> fetch();
        $announcement = $row['announcement'];
        $grade = $row['grade'];
            
        redirect("addannouncement_2.php?date=" . $_GET['date'] ."&?grade=" .$grade. "&?announcement=" . $announcement. "&?id=".$_GET['edit']);        
    }
}

include 'includeInc_2.php';
dohtml_header("Daily Announcements");
?>
<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script> 

<body>
    <?php
    $date = date('Y-m-d');
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
    }
	echo "<table class='centered'>";
	echo "<tr class='centered'>
			<td class='centered'>";
    echo "<h2>" . date('l', strtotime($date)) . "<br>" . $date . "</h2></td></tr>";
	
	echo "<tr class='centered'>
			<td class='centered'>";
    echo"<form name='theForm' action='readannouncements_2.php' method='get'><select name='date' onchange='refresh()'>";

    $rows = $db->query("SELECT * FROM announcements ORDER BY date DESC");
    $temp = 0;
    echo "<option value=''></option>";
    foreach ($rows as $row) {
        if ($temp != $row['date']) {
            $temp = $row['date'];
            echo "<option value=" . $temp;
            if ($temp == $date) {
                echo " selected=selected";
            }
            echo ">" . $temp . "</option>";
        }
    }
    echo "</select></td></tr></table><br><hr>";

    $query = $db->prepare("SELECT * FROM announcements WHERE date=:date ORDER BY code");
    $query->bindValue(":date", $date);
    $query->execute();

    while ($row = $query->fetch()) {
        echo "<b>From: " . $row['teacher'] . "<br>";
        echo "To: " . $row['grade'] . "</b><br>";
        echo nl2br("<p> " . $row['announcement']) . "</p>";
        if (isset($_SESSION['name']) && ($_SESSION['name'] == $row['teacher'])){
            $announcement = $row['id'];
            echo "<a href=readannouncements_2.php?edit=" . $announcement . "&date=" . $date . ">Edit This Announcement </a></td>";  
            echo "<a href=readannouncements_2.php?remove=" . $row['id'] . "&date=" . $date . ">Remove This Announcement</a></td>";
        }
        echo "<hr>";
    }

    if ($query->rowCount() == 0)
        echo "<h3 class='centered'>No Announcements Today.</h3>";

    $db = null;
    ?>
<table class="centered">
<?php
homeLogout();
?>
</table>
<?php 
dohtml_footer(true);
?>