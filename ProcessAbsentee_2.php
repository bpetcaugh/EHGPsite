<?PHP
session_start();
include 'functions_2.php';
att_admin_only();//Mr. Chapman
password_protect();
$db = get_database_connection();
include 'includeInc_2.php';

if($_POST['absnt'] == 1)
{
	$query = $db->prepare("INSERT INTO absentee (name, grade, teacher, date) VALUES (:name, :grade, :teacher, :date)");
    $query->bindValue(":name", $_POST['sname']);
    $query->bindValue(":grade", $_POST['sgrade']);
    $query->bindValue(":teacher", $_SESSION['name']);
    $query->bindValue(":date", date("y-m-d"));
    $query->execute();
}
elseif($_POST['late'] == 1)
{
	$query = $db->prepare("INSERT INTO late (name, grade, teacher, date, period, minutes) VALUES (:name, :grade, :teacher, :date, :period, :minutes)");
    $query->bindValue(":name", $_POST['sname']);
    $query->bindValue(":grade", $_POST['sgrade']);
    $query->bindValue(":teacher", $_SESSION['name']);
    $query->bindValue(":date", date("y-m-d"));
    $query->bindValue(":period", "1st");
    $query->bindValue(":minutes", '1');
    $query->execute();
}
elseif($_POST['present'] == 1)
{
	$query = $db->prepare("INSERT INTO present (name, grade, teacher, date) VALUES (:name, :grade, :teacher, :date)");
    $query->bindValue(":name", $_POST['sname']);
    $query->bindValue(":grade", $_POST['sgrade']);
    $query->bindValue(":teacher", $_SESSION['name']);
    $query->bindValue(":date", date("y-m-d"));
    $query->execute();
}


dohtml_header("Process Absentee Files");
$date = date("m-j-Y");
echo "<table class=centered><tr><td>".$date."<br><br></td></tr><tr><td>";

$files = scandir("AttendanceFiles");
$todayFiles = array();

echo "Teachers who have submitted files: ";
//search for files with todays date
foreach ($files as $file) {
    if (strpos($file, $date) !== false){
		array_push($todayFiles, $file);
		echo substr($file,strlen($date), strlen($file)-strlen($date)-5) . "  ";
	}
}

//Put contents of todays files into an array
$presStudents = array();
foreach ($todayFiles as $file){
	$myfile = fopen("AttendanceFiles/".$file, "r") or die("Unable to open file!");
	$presStudents = array_merge($presStudents, explode(PHP_EOL,fread($myfile,filesize("AttendanceFiles/".$file))));
	fclose($myfile);
}
//$presStudents = array_filter($presStudents);
//$presStudents = array_slice($presStudents, 0);
$presStudents=array_map('trim',$presStudents);

$query = $db->prepare("SELECT * FROM student ORDER BY grade, lastname");
$query->bindValue(":date", $date);
$query->execute();

//remove students who are already marked "Absent", "Late", or "Present"

echo "<table align=center>";

//display missing students from files
while($row = $query -> fetch()){
	$findquery = $db->prepare("SELECT * FROM late WHERE name=\"{$row['lastname']}, {$row['firstname']}\" AND date='" . date("y-m-d") . "';SELECT * FROM absentee WHERE name=\"{$row['lastname']}, {$row['firstname']}\" AND date='" . date("y-m-d") . "';SELECT * FROM present WHERE name=\"{$row['lastname']}, {$row['firstname']}\" AND date='" . date("y-m-d") . "'");
	$findquery->execute();
	if(($findquery->rowCount() == 0)){
		$findquery->nextRowset();
		if(($findquery->rowCount() == 0)){
			$findquery->nextRowset();
			if(($findquery->rowCount() == 0)){
				
				if(array_search($row['accessID'], $presStudents) === false){
					echo "<tr><td>" . $row['id'] . " " . $row['firstname'] . " " . $row['lastname'] . " " . $row['grade'] . "</td>";
					echo "<td><br><form action=ProcessAbsentee_2.php method='post'><input type=hidden name=absnt value=1><input type=hidden name=sname value=\"{$row['lastname']}, {$row['firstname']}\"><input type=hidden name=sgrade value=" . $row['grade'] . "><input type='submit' name='Absent' value='Absent'></form></td>";
					echo "<td><br><form action=ProcessAbsentee_2.php method='post'><input type=hidden name=late value=1><input type=hidden name=sname value=\"{$row['lastname']}, {$row['firstname']}\"><input type=hidden name=sgrade value=" . $row['grade'] . "><input type='submit' name='Late' value='Late'></form></td>";
					echo "<td><br><form action=ProcessAbsentee_2.php method='post'><input type=hidden name=present value=1><input type=hidden name=sname value=\"{$row['lastname']}, {$row['firstname']}\"><input type=hidden name=sgrade value=" . $row['grade'] . "><input type='submit' name='Present' value='Present'></form></td></tr>";
				}
			}
		}
	}
}

echo "</table>";

$db = null;
$dbabs = null;
$dblate = null;
$dbpres = null;
echo "</td></tr><tr><td><br><br>";
homeLogout();
echo "</td></tr></table>";
dohtml_footer(true);
?>
