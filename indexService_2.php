
<?php
session_start();
include 'functions_2.php';
$db = get_database_connection();

$doneButtons = false;
$title="EHGP SERVICE";
include 'includeInc_2.php';
dohtml_header("EHGP SERVICE");

               
if (check_logged_in()) {
    $isTeacher = $_SESSION['isTeacher'];
    echo "<table class = 'centered'><tr class='centered'><td></td><td><h3 class='centered'>Welcome, " . $_SESSION['name'] . "</h3></td><td></td></tr>";
    echo "</table>";
	echo "<table class='centered'>";
		tableRowSpace();
		//makeButton("Home", "index_2.php");
		if ($isTeacher) {
            tableRowSpace(); 
			echo "</table><table class='centered'>";
			makeButton("View Agency Activity","serviceAgencies_2.php"); 
            if (is_admin($_SESSION['username'], $_SESSION['password'])) {
                if (is_serv_admin($_SESSION['username'], $_SESSION['password'])) {
              		makeTwoButtons("View Reported Service","servindstu_2.php","View Verified Service","servindstuv_2.php");  
    				makeTwoButtons("Report Service","serviceReporting_2.php","Verify Reported Service","serviceVerify_2.php");   
    				makeTwoButtons("Verify Service by Agency","serviceVerifyA2b_2.php","Verify Service by Student","serviceVerifyS2b_2.php");   
    				makeTwoButtons("Add Service Agency","addAgency_2.php","Show All Service Records","serviceShow_2.php"); 
					makeTwoButtons("View Service Summary","serviceSummaryAll_2.php","View Service Deficiency Summary","serviceDeficiencySummaryAll_2.php"); 
    				//makeTwoButtons("Insufficient Fr","serviceSummary12fr_2.php","Insufficient So","serviceSummary12so_2.php"); 
    				//makeTwoButtons("Insufficient Jr","serviceSummary12jr_2.php","Insufficient Sr","serviceSummary12sr_2.php");   
    				//makeTwoButtons("Insufficient Fr/So","serviceSummary12frso_2.php","Insufficient Jr/Sr","serviceSummary12jrsr_2.php");   
    				//makeTwoButtons("Total Service Fr/So","serviceTotal12frso_2.php","Total Service Jr/Sr","serviceTotal12jrsr_2.php");   
				makeButton("Access Archives","accessArchives_2.php");
  
                } //service only
            } //isAdmin
        } else {  //not a Teacher
            ?>
            </table><table class = 'centered'>
            <tr><h4 class = 'centerWhite'><font color="white">ALL service should be reported below, even service done through a school sponsored function.
                For school sponsored functions, such as the Cares Walk, the sponsoring teacher will verify your service, so
                no Service Verification Form is needed to be turned in to Mr. Whartenby. ALL other service reported online
                must also have a Service Verification Form turned in to Mr. Whartenby to verify the service performed.</font></h4></tr>
            <?php
					makeTwoButtons("Report Your Service","serviceReportPageS_2.php","View All Reported Service","servindstuaS_2.php"); 
    				makeTwoButtons("View Verified Service","servindstuvS_2.php","View Rejected Service","servindsturS_2.php"); 
    				makeTwoButtons("Service Verification Form","http://www.holyghostprep.org/uploaded/documents/Service_Documents/CSPVerify.pdf","Service Site Links","http://www.holyghostprep.org/uploaded/documents/Service_Documents/ServiceWebsites.pdf"); 
    				makeTwoButtons("Service Opportunities","http://www.holyghostprep.org/page.cfm?p=2492","Service Handbook","http://www.holyghostprep.org/uploaded/documents/Service_Documents/CSPbro0809.pdf"); 
    				makeButton("Service Home Page","http://www.holyghostprep.org/page.cfm?p=298"); 
       } //isTeacher
    tableRowSpace(); 
	echo '</table><table class="centered">';
	
	makeButton("Home","loader.php");
	makeButton("Logout","logout_2.php");
    echo '</table>';
    $doneButtons = true;
} //logged in
if (!$doneButtons) {
    echo '<table class="centered">';
   			makeButton("Read Announcements","readannouncements_2.php");
        	makeButton("Bell Schedules","TimeSchedules.pdf");
        	makeButton("Computer Lab Usage","scheduleViewS_2.php");
			tableRowSpace();
        	makeButton("Calendar","Calendar.php");
			makeButton("Login","login_2.php?home=1");
       
  echo '</table><br /><br />';
}

dohtml_footer(true);
?>