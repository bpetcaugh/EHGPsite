<?php
//edited by Vincent Pillinger
session_start();
include 'functions_2.php';
password_protect();
$db = get_database_connection();

//Make sure a student is not trying to register a car that already 
//has a license plate that exists
//Apparently is can't use the DB connection already existing above it on the p
//age and has to have its own.
function checkValidLicense($licenseplate) {
    $db = get_database_connection();
    $dontbreak = $db->prepare("SELECT * FROM parkingpermit WHERE licenseplate = :licenseplate");
    $dontbreak->bindValue(":licenseplate", $licenseplate);
    $dontbreak->execute();
    if ($dontbreak->rowCount() > 0) {
        die("This vehicle already exists in our database.");
    }
    $db = null;
    return true;
}

$todie = false;
if (!isset($_SESSION['id'])) {
    $todie = true;
}
if (!isset($_POST['make'])) {
    $todie = true;
}
if (!isset($_POST['model'])) {
    $todie = true;
}
if (!isset($_POST['year'])) {
    $todie = true;
}
if (!isset($_POST['color'])) {
    $todie = true;
}
if (!isset($_POST['licenseplate'])) {
    $todie = true;
}

if ($todie) {
    die("One of the required fields was blank. 
        Please report this incident to the webmaster.");
}
//everything exists
$sid = $_SESSION['id'];
$make = $_POST['make'];
$model = $_POST['model'];
$color = $_POST['color'];
$licenseplate = $_POST['licenseplate'];
$year = $_POST['year'];
$existingnumber = 0;

if ($_POST['existingnumber'] != "") {
	$existingnumber = $_POST['existingnumber'];
}

if (isset($_POST['oldlicense'])) { //means to edit existing permit
    $oldlicense = $_POST['oldlicense'];
    if ($licenseplate != $oldlicense) {
        checkValidLicense($licenseplate);
    }
    $edit = $db->prepare("UPDATE parkingpermit SET studentid=:studentid, make=:make, model=:model, year=:year, color=:color, licenseplate=:licenseplate WHERE licenseplate=:oldlicense AND studentid=:studentid");
    $edit->bindValue(":studentid", $sid);
    $edit->bindValue(":make", $make);
    $edit->bindValue(":model", $model);
    $edit->bindValue(":year", $year);
    $edit->bindValue(":color", $color);
    $edit->bindValue(":licenseplate", $licenseplate);
    $edit->bindValue(":oldlicense", $oldlicense);
    $edit->execute();
    if ($edit->rowCount() < 1) {
        die("Something went wrong with permit update. Please report this incident to the webmaster.");
    }
} else {//means to add new permit
    //checks to see if new permit should be verify or not
    $verify = 0;
    if (isset($existingnumber) && isset($sid)) {
        $statement = $db->prepare("SELECT * FROM parkingpermit WHERE permitnumber=:permitnumber AND studentid=:studentid AND verify=1");
        $statement->bindValue(":permitnumber", $existingnumber);
        $statement->bindValue(":studentid", $sid);
        $statement->execute();

        if ($statement->rowCount() > 0) {
            $verify = 1;
        }
    }
	//if ($verify == 0)
	//	$existingnumber = 0;
    checkValidLicense($licenseplate);
    //Inserts new permits into DB
	//$existingnumber = 0;
    	//echo $_POST['oldlicense'];
	$query = $db->prepare("INSERT INTO parkingpermit (studentid, make, model, year, color, licenseplate, permitnumber, verify) VALUES (:studentid, :make, :model, :year, :color, :licenseplate, :permitnumber, :verify)");
    $query->bindValue(":studentid", $sid);
    $query->bindValue(":make", $make);
    $query->bindValue(":model", $model);
    $query->bindValue(":year", $year);
    $query->bindValue(":color", $color);
    $query->bindValue(":licenseplate", $licenseplate);
    $query->bindValue(":permitnumber", $existingnumber);
    $query->bindValue(":verify", $verify);
    $query->execute();
    if ($query->rowCount() < 1) {
		echo $sid . " " . $make . " " . $model . " " . $year . " " . $color . " " . $licenseplate . " " . $existingnumber . " verify:" . $verify;
        die("Something went wrong with the new permit.");
    }
}
$db = null;
include 'includeInc_2.php';
dohtml_header("Succesful Request, Registration, or Edit");
echo "<table class='centered'>";
makeButton("See Vehicle/Permit","viewmypermit_2.php");
homeLogout();
echo "</table>";
dohtml_footer(true);
?>