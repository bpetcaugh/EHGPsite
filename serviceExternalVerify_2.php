<?php
	session_start();
	include 'functions_2.php';
	include 'includeInc_2.php';
	$db=get_database_connection();
	//added 9-4-14 because submit part is now here
	$link = "serviceReportPageS_2.php";
	$sid=$_SESSION['id'];
	$isTeacher = false;
	
	if (is_teacher($_SESSION['username'], $_SESSION['password'])) {
		//added by BM, moved from (HERE) 5/3/16
		$link = "serviceReporting_2.php";
		$sid=$_POST['student'];
		//5-2-16 because when checking for teacher $_SESSION['id'] does not match. BM
		$isTeacher = true;
	}

	
	if (isset($_POST['servicehours']) && isset($_POST['date'])) {
		$serviceHours = $_POST['servicehours'];
		// required
		$serviceDate = $_POST['date'];
		// required
		$serviceInfo = explode("-", $serviceDate);
		$serviceYear = $serviceInfo[0];
		$serviceMonth = $serviceInfo[1];
		$serviceDay = $serviceInfo[2];
		$serviceAgency = $_POST['agid'];
		$serviceNotes = $_POST['notes'];
		//create a blank error message
		$error_message = "";
		//specify what is legal for service hours
		
		if ($serviceHours <= 0) {
			$error_message .= 'The service hours that you entered does not appear to be valid. <br />';
		}

		//specify what is legal for a piece of text for date
		$currYear = date("Y");
		//this year
		$currMonth = date("m");
		//this month
		$currDay = date("d");
		$monthLim = "06";
		//July is the earliest month where service of this school year counts
		
		if ($serviceYear == $currYear) {
			//if service has been performed in this current year
			
			if ($serviceMonth < $monthLim) {
				//if the month of service was before monthLim
				
				if ($currMonth > $monthLim) {
					//If the current month is after monthLim, illegal entry
					$error_message .= 'The date of service that you entered is no longer acceptable towards your service total of this school year. <br />';
				}

			}

			
			if ($serviceMonth == $currMonth){
				//if the service year equals this year and the service month equals the this month
				
				if($serviceDay > $currDay){
					//if the day of service is after the current day, illegal entry
					$error_message .= 'The date of service that you entered has not yet occurred. <br />';
				}

			}

			
			if ($serviceMonth > $currMonth){
				//if the service month is after the current month, illegal entry
				$error_message .= 'The date of service that you entered has not yet occurred. <br />';
			}

		} else {
			//if service year is before or after current year
			
			if ($serviceYear < $currYear) {
				//if service year less than current year
				
				if ($serviceYear == ($currYear - 1)) {
					//if service is one less than current year (2012 in the 2012-2013 school year and it is currently 2013)
					
					if ($serviceMonth < $monthLim) {
						//if the service from a year ago was performed before monthLim (of 2012 for example), illegal entry
						$error_message .= 'The date of service that you entered is no longer acceptable towards your service total of this school year. <br />';
					} else {
						//if the service month is greater than or equal to the month limit
						
						if($currMonth > $monthLim){
							//if the current month is after the month lim, it is in the beginning of the school year, thus making the service entry illegal since it is from a year prior
							$error_message .= 'The date of service that you entered is no longer acceptable towards your service total of this school year. <br />';
							//EX:(it is Nov of 2012-2013, entry is nov of 2011)
						}

					}

				} else {
					//Service year is before the current school year (service in 2011 does not count for 2012-13 school year) then illegal entry
					$error_message .= 'The date of service that you entered is no longer acceptable towards your service total of this school year. <br />';
				}

			} else {
				//if service year is after current year, illegal entry
				$error_message .= 'The date of service that you entered has not yet occurred. <br />';
			}

		}

		
		if($serviceAgency == 0){
			$error_message .= 'You did not select a Service Agency. <br />';
		}

		
		if($serviceNotes == ""){
			$error_message .= 'You did not enter information on your service work in the notes section. <br />';
		}

		//if error message isnt blank, display it and die
		
		if (strlen($error_message) > 0) {
			died($error_message);
			//return false;
		}

		// else {
		//redirect("submit_2.php?student=" . $_POST['student'] . "&?servicehours=" . $serviceHours . "&?date=" . $serviceDate . "&?agid=" . $serviceAgency . "&?notes=" . $serviceNotes);
		//return true;
		//}
	} else {
		died('There appears to be an unknown problem with the form you submitted. <br />You must have a valid service date and a valid number of servicehours.<br />');
	}

	
	if (isset($_POST['student']) && $_POST['student'] !== null) {
		//$sid = $_POST['student'];  ASSIGNED NEAR BEGINNING BY MCGEE CHANGE
		//$sid=$_SESSION['id']; //9-4-14    05-04-16
		$sql = "SELECT * FROM student WHERE id=:sid";
		$query = $db->prepare($sql);
		$query->bindValue(":sid", $sid);
		$query->execute();
		$row = $query->fetch();
		
		if ($row['id'] == $_POST['student']) {
			$student = $_POST['student'];
			$servhrs = $_POST['servicehours'];
			$servdate = $_POST['date'];
			$servagency = $_POST['agid'];
			$servnotes = $_POST['notes'];
			//check values
			//echo $student.$servhrs.$servdate.$servagency.$servnotes;
			//check if id represents a person
			$sql = "INSERT INTO service (student, servicehours, date, agency, notes) VALUES (:student,:servhrs,:servdate,:servagency,:servnotes )";
			$query = $db->prepare($sql);
			$query->bindValue(":student", $student);
			$query->bindValue(":servhrs", $servhrs);
			$query->bindValue(":servdate", $servdate);
			$query->bindValue(":servagency", $servagency);
			$query->bindValue(":servnotes", $servnotes);
			$query->execute();
			$header = "Service Added";
			$message = "Add Another";
		}

	} else {
		$message = "Add Service Failed";
		$warningMessage ="The Student ID you tried to add does not exist. Please try again.";
	}




function died($error) {
	global $link;
	dohtml_header("Add Service Failed");
	echo "<table class=centered>";
	echo "<tr><td> We are very sorry, but there were error(s) found with the form you submitted: <br /><br />" . $error . "<br />Please go back and fix these errors.</br></br></br></td></tr>";
	makeButton("Report Service", "$link");
	homeLogoutService();
	echo "</table>";
	dohtml_footer(true);
	die();
}

$db = null;
//include 'includeInc_2.php'; commented out 9-4-14 as it is already at the beginning after submit added to here.
//$warningMessage = "Add Service temporarily under repair";
dohtml_header($header);
echo "<table class=centered>";

if (isset($warningMessage)) {
	echo "<tr><td>" . $warningMessage . "</td></tr>";
}


if (isset($message) && isset($link))    makeButton($message, $link);
homeLogoutService();
echo "</table>";
dohtml_footer(true);
?>