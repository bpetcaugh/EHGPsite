<?
	//Created and edited by Ricky Wang
	session_start();
	include 'functions_2.php';
	include 'includeInc_2.php';
	password_protect();
	teacher_only();
	//dohtml_header("Service CSV");
	$db = get_database_connection();

	//Session Setup
	if (isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];

		$statement = $db->prepare("SELECT * FROM teacher WHERE username=:username AND password=:password");
		$statement->bindValue(":username", $username);
		$statement->bindValue(":password", $password);
		$statement->execute();

		$row1 = $statement->fetch();
		if ($username == $row1['username'] && $password == $row1['password']) {
			 
			$id = $row1['id'];
			$name = $row1['name'];
			$date = date('Y-m-d');
		}
	}
	
	//Global constants for archiving
	$weburl = "advancedtopics.holyghostprep.org/";
	$main_folder = "advancedtopics/hwang/htdocs/";
	$CSV_output_folder = "CSV_output";
	$Requests_output = "CSV_output/";
	$file_name = "Services_Requests.csv";
	$filedir = "{$Requests_output}/{$file_name}"; //use for csv_line_write
	$fulldir = "{$weburl}{$main_folder}{$Requests_output}{$file_name}";//use for js open download windows
	$CSV_label = array("Class Number","First Name","Last Name","Grade","Date","Agency","Hours","Notes","Role","Verified");
?>
	<script type="text/javascript">;
		function open_win(){
		var dir = "<? echo $filedir ?>";
		window.open(dir);
		}
	</script>;
<?


	function ensure_folder_exists($path) {
		if (!file_exists($path)){
		return mkdir($path,0777,true);
		}
		else{
			return true;
		}
	}
	
	function delete_old_file($path) {
		if (file_exists($path)){
		return unlink($path);
		}
		else{
			return true;
		}
	}
	
	function write_line_csv($filedir,$line){ //write to the end of the file
		$file = fopen($filedir,"a+");
		return fputcsv($file,$line); //return false if have error
	}
	
	
	function requestsOutput($servdb3){
		
		global $db, $CSV_output_folder, $Requests_output, $filedir, $fulldir;
		
	if ($servdb3->rowCount()>0) {
		
	//Set up more queries for table displays
                $i = 0;
                if (!isset($agid)) $agid = 0;
                //while ($row = mysql_fetch_array($result)) 
				while ($servdbrow2 = $servdb3->fetch())
				{
	                $sid = $servdbrow2['student'];
					$sql6 = "SELECT * FROM student WHERE id=:sid";
					$studb1 = $db->prepare($sql6);
					$studb1->bindvalue(":sid",$sid);
					$studb1->execute();
					$studbrow1 = $studb1->fetch();					

					$agidsel = $servdbrow2['agency'];
					$sql7 = "SELECT * FROM agencies WHERE id=:agidsel";
					$agdb1 = $db->prepare($sql7);
					$agdb1->bindvalue(":agidsel",$agidsel);
					$agdb1->execute();
					$agdbrow1 = $agdb1->fetch();
					$nameOfSelected = $agdbrow1['name'];
					
                    $i++;
					
					$tempRole = $servdbrow2['role'];
					$Role = "";
					if ($tempRole == "L"){
						$Role = "Leadership"; 
					}
					else{
						if ($tempRole == "B") $Role = "Both";
							else{
								if ($tempRole == "I") $Role = "Initiative";
							}
					}
					
					$tempVerified = $servdbrow2['verified'];
					if ($tempVerified == 0) {
						$Verified = "NOT yet Verified";
					} else {
						if ($tempVerified == 1) {
							$Verified = "Verified";
						} else {
							$Verified = "Rejected";
						}
					}
			
			
			$output_array = array($studbrow1['id'],$studbrow1['firstname'],$studbrow1['lastname'],$studbrow1['grade'],$servdbrow2['date'],$nameOfSelected,$servdbrow2['servicehours'],$servdbrow2['notes'],$Role,$Verified);

			
			if (ensure_folder_exists($CSV_output_folder)) {
				write_line_csv($filedir,$output_array);
			}
		}
	}
	}
	
	$servdb3 = $db->prepare("SELECT * FROM service ORDER by student");
	$servdb3->execute();
	delete_old_file($filedir);
	write_line_csv($filedir,$CSV_label);
	requestsOutput($servdb3);
	echo "<script> open_win();</script>";
	$db = null;
?>


















