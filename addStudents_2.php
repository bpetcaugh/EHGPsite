<?PHP
	//Created by Ricky Wang
	session_start();
	include 'functions_2.php';
	admin_only();
	password_protect();
	$db = get_database_connection();
	include 'includeInc_2.php';
	include 'mysqlbk_functions_2.php';
	
	function replace_single_quotes($str) {
		//Replace one single quote to two and then when uploaded it will only be one!
		$str = str_replace("'","''",$str);
		return $str;
	}

	$myfile = fopen("directory/Students.txt", "r") or die("Unable to open file!");
	$stunum = 0;
	$bk = mysqlbackup();
	
	if($bk){
		//Change the sql of the table for test or real used!
		//$query1 = $db->prepare("DELETE FROM `student`");
		$query1 = $db->prepare("DELETE FROM `student`");
		$query1->execute();
		while(!feof($myfile)) {
			$line = fgets($myfile);
			if ($line=="") break;
			$strs = explode(",", $line);
			//Change this if the separator is different
			//Change the sql of the table for test or real used!
			//$query2 = $db->prepare("INSERT INTO student (classnum, lastname, firstname, grade, id, username, password) VALUES (:classnum, :lastname, :firstname, :grade, :id, :username, :password)");
			$query2 = $db->prepare("INSERT INTO student (classnum, lastname, firstname, grade, accessID, id, username, password) VALUES (:classnum, :lastname, :firstname, :grade, :accessID, :id, :username, :password)");
			$query2->bindValue(":classnum", $strs[0]);
			//Switch oder of first and last name to matching the db.
			//$query2->bindValue(":lastname", replace_single_quotes($strs[2]));
			$query2->bindValue(":lastname", $strs[2]);
			//$query2->bindValue(":firstname", replace_single_quotes($strs[1]));
			$query2->bindValue(":firstname", $strs[1]);
			$query2->bindValue(":grade", $strs[3]);
			$query2->bindValue(":accessID", $strs[6]);
			$query2->bindValue(":id", $strs[0]);
			//id is same as classnum for compatibility.
			$query2->bindValue(":username", $strs[4]);
			$query2->bindValue(":password", md5(trim($strs[5])));
			$query2->execute();
			$stunum++;
		}

		dohtml_header("Students Added!");
		$message = "Total add Student: {$stunum}";
		echo "<table class=centered>";
		echo "<tr><td>" . $message . "</td></tr>";
	} 
	else {
		dohtml_header("Fail to back up!");
	}

	homeLogout();
	echo "</table>";
	dohtml_footer(true);
	$db = null;
?>
