<?
	//Created and edited by Ricky Wang
	session_start();
	include 'functions_2.php';
	include 'includeInc_2.php';
	password_protect();
	teacher_only();
	//dohtml_header("Maintenance Requests CSV");
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
	$Maintenance_Requests_output = "CSV_output/";
	$file_name = "Maintenance_Requests.csv";
	$filedir = "{$Maintenance_Requests_output}/{$file_name}"; //use for csv_line_write
	$fulldir = "{$weburl}{$main_folder}{$Maintenance_Requests_output}{$file_name}";//use for js open download windows
	$CSV_label = array("Ticket No.","Teacher","Request Location","Ticket Description","Urgency Level","Date","Status");
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
	
	
	function requestsOutput($statement, $username, $password){
		
		global $db, $CSV_output_folder, $Maintenance_Requests_output, $filedir, $fulldir;
		
	while ($tickets = $statement->fetch()) {      //while there are still support tickets
			
			$probID = $tickets['id'];
			$probNum = $tickets['request'];
			$query1 = $db->prepare("SELECT * FROM requests WHERE id = :id");
			$query1->bindValue(":id", $probNum);
			$query1->execute();
			$problem = $query1->fetch();       //the list of problems in the database to compare to the ticket

			$query2 = $db->prepare("SELECT * FROM teacher WHERE id = :id");
			$query2->bindValue(":id", $tickets['teacher']);
			$query2->execute();
			$teachers = $query2->fetch();
			$teacher = $teachers['name'];               //display name of teacher's ticket

			$urgency = $tickets['urgency'];         //urgency level of the ticket
			if ($urgency == 1) {
				$urgLevel = "High";
			} else if ($urgency == 2) {
				$urgLevel = "Medium";
			} else {
				$urgLevel = "Low";
			}

			$statusLevel = $tickets['status'];              //status level of the ticket
			$statuses[0] = "Pending";
			$statuses[1] = "In Progress";
			$statuses[2] = "Completed";
			$status = $statuses[$statusLevel];              //display name of status
		   
			if($statusLevel != 2){                  //if status is not completed, find it's ticket no.
				$ticks = $db->prepare("SELECT * FROM mainrequest ORDER BY id");
				$ticks->execute();
				$tickNum = 1;
				while(($ticket = $ticks->fetch()) && ($ticket['id'] != $probID)){       //while it is still checking and the current ticket is not up, add to tickno. counter
					if($ticket['status']!=2){
					   $tickNum++;
					}   
				}
			}else{ $tickNum = "--"; }           //already completed, no ticket number
			
			
			$output_array = array($tickNum,$teacher,$problem['name'],$tickets['notes'],$urgLevel,$tickets['date'],$status);

			
			if (ensure_folder_exists($CSV_output_folder)) {
				write_line_csv($filedir,$output_array);
			}
		}
	}
	
	$ticketOrder = ("ORDER by `date` DESC");
	$ticketView = ("SELECT * FROM mainrequest ");
	$sth2 = $db->prepare($ticketView . $ticketOrder);
	$sth2->execute();
	delete_old_file($filedir);
	write_line_csv($filedir,$CSV_label);
	requestsOutput($sth2, $username, $password);
	echo "<script> open_win();</script>";
	$db = null;
?>


















