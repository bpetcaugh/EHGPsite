<?php
//Austin did this
//Most code taken from index_2.php and changed to php
session_start();
include 'functions_2.php';
//From regular functions.
password_protect();
admin_only();
include 'includeInc_2.php';
dohtml_header("Administrator Tools");

if (check_logged_in()) {
    echo "<table class='centered'><tr class='centered'><td></td><td><h3 class='centered'>Welcome, " . $_SESSION['name'] . "</h3></td><td></td></tr>"; //display name
    echo "</table>";
	echo "<table class='centered'>";
		tableRowSpace();
		  if (is_admin($_SESSION['username'], $_SESSION['password'])) {
  			if(is_super_admin($_SESSION['username'], $_SESSION['password'])) {
  				makeTwoButtons("Edit Links","editlinks_2.php","View Student Infractions","viewStudentInfractions_2.php");
  				makeTwoButtons("View/Manage Support Tickets","viewtickets.php","Add Type of Problem","addProblem.php");
  				makeTwoButtons("Parent-Teacher Teacher Scheduler","admin-ts_2.php","Parent-Teacher Student Scheduler","par-teach-night-admin_3.php");
  				makeTwoButtons("Add Calendar Days","login_2.php?calendar=1","Remove Calendar Days","login_2.php?rcalendar=1");
				makeTwoButtons("Change Student Password","chgpassS_2.php","Change Teacher Password","chgpassT_2.php");//added 7-30-15 mmm
				makeButton("Sync Students with PowerSchool","addStudents_2.php");
  			} //end super admin
  			if (is_att_admin($_SESSION['username'], $_SESSION['password'])) {
  				makeTwoButtons("Edit Absentee","editabsentee_2.php","Edit Late","editlate_2.php");
				makeTwoButtons("Process Attendance Records","ProcessAbsentee_2.php","View Swipe List","SwipeList_2.php");
       			makeTwoButtons("Verify Permits", "permitVerify_2.php", "View Permits", "permitView_2.php");//added 4-29-15 Eric Ghildyal
  				makeTwoButtons("View College Visits","college_2.php","View Attendance Totals","attendanceTotal_2.php");//added 11-12-13 readded 09-12-14
  				//makeButton("View Student Infractions","viewStudentInfractions_2.php");
  				tableRowSpace();
  			} //end attendance admin
		} //end admin buttons
	echo "</table>";
	tableRowSpace();

  echo "<table class='centered'>";
	homeLogout();
  echo "</table>";
} //logged in

dohtml_footer(true);
  ?>
