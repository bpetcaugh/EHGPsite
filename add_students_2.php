<?PHP
//Created by Ricky Wang

session_start();
include 'functions_2.php';
admin_only();
password_protect();
$db = get_database_connection();
include 'includeInc_2.php';

function replace_single_quotes($str) {
    //Replace one single quote to two.
    $str = str_replace("'","''",$str);
    return $str;
}

$myfile = fopen("directory/Students.txt", "r") or die("Unable to open file!");
$stunum = 1;
    while(!feof($myfile)) {
        $line = fgets($myfile);
        $strs = explode(",", $line); //Change this if the separator is different

		//Change the sql of the table for test or real used!
		
        //$query2 = $db->prepare("INSERT INTO student (classnum, lastname, firstname, grade, id, username, password) VALUES (:classnum, :lastname, :firstname, :grade, :id, :username, :password)");
		$query2 = $db->prepare("INSERT INTO student_test (classnum, lastname, firstname, grade, id, username, password) VALUES (:classnum, :lastname, :firstname, :grade, :id, :username, :password)");
        
		
		$query2->bindValue(":classnum", $strs[0]);
		//Switch oder of first and last name to matching the db.
        $query2->bindValue(":lastname", replace_single_quotes($strs[2]));
        $query2->bindValue(":firstname", replace_single_quotes($strs[1]));
        $query2->bindValue(":grade", $strs[3]);
        $query2->bindValue(":id", $strs[0]); //id is same as classnum for compatibility.
        $query2->bindValue(":username", $strs[4]);
        $query2->bindValue(":password", md5($strs[5]));
        $query2->execute();
		$stunum++;
    }
        dohtml_header("Students Added!");
		$Message = "Total add Student: {$stunum}";
		echo "<table class=centered>";
		echo "<tr><td>" . $Message . "</td></tr>";
		homeLogout();
		echo "</table>";

dohtml_footer(true);
$db = null;
?>
