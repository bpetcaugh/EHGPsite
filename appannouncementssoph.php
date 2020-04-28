<?php
session_start();
include 'functions_2.php';
$db = get_database_connection();
    
    $query = $db->prepare("SELECT * FROM announcements WHERE date=:date AND (code=1 OR code=2 OR code=3 OR code=4 OR code=7) ORDER BY code");
    //$query->bindValue(":table", $_GET['table']);
    $query->bindValue(":date", $_GET['date']);
    $query->execute();

    while ($row = $query->fetch()) {
        echo "<b>From: " . $row['teacher'] . "<br>";
        echo "To: " . $row['grade'] . "</b><br>";
        echo nl2br($row['announcement']) . "<br>";
        echo "<hr>";
    }

    $db = null;
    ?>
</body>
</html>