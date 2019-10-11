<?PHP
session_start();
include 'functions_2.php';
att_admin_only();//Mr. Chapman
password_protect();
$db = get_database_connection();
include 'includeInc_2.php';
dohtml_header("Student List");
$date = date("m-j-Y");
echo "<table class=centered><tr><td>".$date."<br><br></td></tr><tr><td>";

$files = scandir("AttendanceFiles");
$todayFiles = array();
//search for files with todays date
foreach ($files as $file) {
    if (strpos($file, $date) !== false){
		array_push($todayFiles, $file);
		echo substr($file,strlen($date), strlen($file)-strlen($date)-5) . "<br>";
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

//display students from $presStudents
while($row = $query -> fetch()){
	if(array_search($row['accessID'], $presStudents) !==false){
		echo $row['id'] . " " . $row['firstname'] . " " . $row['lastname'] . " " . $row['grade'] . "<br>";
	}
}

$db = null;
echo "</td></tr><tr><td><br><br>";
homeLogout();
echo "</td></tr></table>";
dohtml_footer(true);
?>
