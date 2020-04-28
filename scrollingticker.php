<?php
session_start();
include 'functions_2.php';
$db = get_database_connection();

$date = date('Y-m-d');
$tomorrow = mktime(0, 0, 0, date("m"), date("d"), date("Y"));

$query = $db->prepare("SELECT * FROM announcements WHERE date=:date ORDER BY code");
$query->bindValue(":date", $date);
$query->execute();
//$con=mysql_connect("localhost","ehgp_test","password");
//mysql_select_db("ehgp_test", $con);
//$result = mysql_query("SELECT * FROM announcements WHERE date='" . $date . "'");

$i = 1;
while (!$row = $query->fetch()) {
//while (mysql_num_rows($result)==0)
//{
    $tomorrow = mktime(0, 0, 0, date("m"), date("d") + $i, date("Y"));
    $date = date('Y-m-d', $tomorrow);
    //$result = mysql_query("SELECT * FROM announcements WHERE date='" . $date . "'");
    $query = $db->prepare("SELECT * FROM announcements WHERE date=:date ORDER BY code");
    $query->bindValue(":date", $date);
    $query->execute();
    $i++;
}
?> 
<html>
    <head>

        <style type="text/css">

        </style>
    </head>

    <body>

<?php
$query = $db->prepare("SELECT * FROM announcements WHERE date=:date  AND grade<>'Faculty' ORDER BY code");
$query->bindValue(":date", $date);
$query->execute();

//$result = mysql_query("SELECT * FROM announcements WHERE date='" . $date . "' AND grade<>'Faculty'");
if ($row = $query->fetch()/* $row = mysql_fetch_array($result) */) {
    $query = $db->prepare("SELECT * FROM announcements WHERE date=:date  AND grade<>'Faculty' ORDER BY code");
    $query->bindValue(":date", $date);
    $query->execute();

    //$result = mysql_query("SELECT * FROM announcements WHERE date='" . $date . "' AND grade<>'Faculty' ORDER BY code");
    $i = 0;
    if (isset($_GET['num'])) {
        while ($i != $_GET['num']) {
            //$row = mysql_fetch_array($result);
            $row = $query->fetch();
            $i++;
        }
    }
//       echo "<br><font size=6><center>" . date('l', strtotime($date)) . ", " . date('F jS', $tomorrow) . "</center></font></td>";
    //     echo "</tr></table><hr>";
    echo "<hr color='red' />";
    echo "<center><font size=5>Daily Announcements for " . date('l', strtotime($date)) . ", " . date('F jS', $tomorrow) . " -- To: " . $row['grade'] . " -- From: " . $row['teacher'] . "<br /></font><br /><font size=5>";
    //echo "To: " . $row['grade'] . "</font><br><br><font size=5>";
    $each = $row['announcement'];
    $each = $each . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo "<marquee scrollamount=5 scrolldelay=1>";
    echo $each;
    echo "</marquee>";
    echo "</font></center><br><br>"; //deleted n12br beginning
}
else
    echo "<h3 align=center>No Announcements Today.</h3>";
//moved out of script
?>
        <script>setTimeout("location.href = 'scrollingticker.php?num=<?php
        $query = $db->prepare("SELECT COUNT(*) FROM announcements WHERE date=:date  AND grade<>'Faculty' ORDER BY code");
        $query->bindValue(":date", $date);
        $query->execute();
        $numrows = $query->fetchColumn();
        //$result = mysql_query("SELECT * FROM announcements WHERE date='" . $date . "' AND grade<>'Faculty' ORDER BY code");
        if (isset($_GET['num'])){
                if (($_GET['num'] + 1) > $numrows/* mysql_num_rows($result) */)
                    echo 1;
                
                else
                    echo $_GET['num'] + 1;
        }
        else
            echo 2;
?>'",<?php echo strlen($each) * 120 ?>);</script>
<?php
//mysql_free_result($result);
//mysql_close($con);
        $db = null;
?>
    </body>
</html>