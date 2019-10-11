<?php

session_start();
include 'functions.php';
password_protect();

$db = get_database_connection();
$todie = false;
if (!isset($_POST['sid'])) {
    $todie = true;
}
if (!isset($_POST['make'])) {
    $todie = true;
}
if (!isset($_POST['model'])) {
    $todie = true;
}
if (!isset($_POST['color'])) {
    $todie = true;
}
if (!isset($_POST['licenseplate'])) {
    $todie = true;
}
if (!isset($_POST['permitnumber'])) {
    $todie = true;
}
if (!isset($_POST['verify'])) {
    $todie = true;
}
if (!isset($_POST['year'])) {
    $todie = true;
}
if (!isset($_POST['oldlicense'])) {
    $todie = true;
}
if ($todie) {
    die("One of the required fields was blank. 
        Please report this incident to the webmaster.
        If you were trying to hack the database ... please stop.");
}
//everything exists
$sid = $_POST['sid'];
$make = $_POST['make'];
$model = $_POST['model'];
$color = $_POST['color'];
$licenseplate = $_POST['licenseplate'];
$permitnumber = $_POST['permitnumber'];
$verify = $_POST['verify'];
$year = $_POST['year'];
$oldlicense = $_POST['oldlicense'];
//make this gigantic query to update the permit
$edit = $db->prepare("UPDATE parkingpermit SET studentid=:studentid, make=:make, model=:model, year=:year, color=:color, licenseplate=:licenseplate, permitnumber=:permitnumber, verify=:verify WHERE licenseplate=:oldlicense");
$edit->bindValue(":studentid", $sid);
$edit->bindValue(":make", $make);
$edit->bindValue(":model", $model);
$edit->bindValue(":year", $year);
$edit->bindValue(":color", $color);
$edit->bindValue(":licenseplate", $licenseplate);
$edit->bindValue(":oldlicense", $oldlicense);
$edit->bindValue(":permitnumber", $permitnumber);
$edit->bindValue(":verify", $verify);
$edit->execute();
if ($edit->rowCount() < 1) {
    die("Something went wrong with the update. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
}

$db = null;
echo "<body bgcolor=#CCCCCC>";
echo "<h1 align=center>Permit Edit Successful</h1><br/><br/>";
echo "<center><a href=viewpp.php>See All Permits</a>";

echo "</select>&nbsp&nbsp<a href=index.php>Home</a>&nbsp&nbsp<a href=logout.php>Logout</a><br><br></center>";
?>