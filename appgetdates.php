 <?php
session_start();
include 'functions_2.php';
$db = get_database_connection();
    
    //$query = $db->prepare("SELECT * FROM announcements WHERE date=:date ORDER BY code");
    //$query->bindValue(":table", $_GET['table']);
    //$query->bindValue(":date", $_GET['date']);
    //$query->execute();


    $rows = $db->query("SELECT * FROM announcements ORDER BY date");
    $temp = 0;
    foreach ($rows as $row) {
        if ($temp != $row['date']) {
            $temp = $row['date'];
            echo $temp . "<br>";
        }
    }


    //while ($row = $query->fetch()) {
    //    echo "<b>From: " . $row['teacher'] . "<br>";
    //    echo "To: " . $row['grade'] . "</b><br>";
    //    echo nl2br($row['announcement']) . "<br>";
    //    echo "<hr>";
    //}

    $db = null;
    ?>
</body>
</html>