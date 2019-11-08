<?php
//Edited by Christian Kardish

//session_start();
$_SESSION = array();
//session_regenerate_id();
//if (isset(session_id()) && session_id!="") { session_destroy();} //added these three lines in case somebody didnt logout
session_start();

include 'functions_2.php';

$db = get_database_connection();

if (isset($_POST['password'])) {
    if (login($_POST['username'], md5($_POST['password']))) {
        if ($_GET['announcement'] == 1) {
            redirect("addannouncement_2.php");
        } else if ($_GET['scheduleRoom'] == 1) {
            redirect("scheduleRoom_2.php");
        } else if ($_GET['scheduleMeeting'] == 1) {
            redirect("scheduleMeeting_2.php");
        } else if ($_GET['absentee'] == 1) {
            redirect("addabsentee_2.php");
        } else if ($_GET['absentee'] == 2) {
            redirect("viewabsentee_2.php");
        } else if ($_GET['lockdown'] == 1) {
            redirect("addlockdown_2.php");
        } else if ($_GET['lockdown'] == 2) {
            redirect("viewlockdown_2.php");
        } else if ($_GET['late'] == 1) {
            redirect("addlate_2.php");
        } else if ($_GET['late'] == 2) {
            redirect("viewlate_2.php");
        } else if ($_GET['dress'] == 1) {
            redirect("adddress_2.php");
        } else if ($_GET['dress'] == 2) {
            redirect("viewdress_2.php");
        } else if ($_GET['test']) {
            redirect("test_2.php");
        } else if ($_GET['home']) {
            redirect("index_2.php");
        } else if ($_GET['calendar']) {
            redirect("addcalendar_2.php");
        } else if ($_GET['rcalendar']) {
            redirect("removecalendar_2.php");
        } else {
            $ref=@$HTTP_REFERER;
            echo $ref;
            if ($ref=="http://www.holyghostprep.org/page.cfm?p=1488") {
                redirect("/trackandfield/index.php");
            } else redirect("index_2.php");
            //http://www.plus2net.com/php_tutorial/php_referrer.php
        }
    } else {
        redirect("login_2.php?fail=1&announcement=" . $_GET['announcement'] . "&scheduleRoom=" . $_GET['scheduleRoom'] . "&absentee=" . $_GET['absentee'] . "&lockdown=" . $_GET['lockdown'] . "&late=" . $_GET['late'] . "&dress=" . $_GET['dress'] . "&test=" . $_GET['test'] . "&home=" . $_GET['home']);
    }
} else if (check_logged_in()) {
    if ($_GET['announcement'] == 1) {
        redirect("addannouncement_2.php");
    } else if ($_GET['scheduleRoom'] == 1) {
        redirect("scheduleRoom_2.php");
    } else if ($_GET['scheduleMeeting'] == 1) {
        redirect("scheduleMeeting_2.php");
    } else if ($_GET['absentee'] == 1) {
        redirect("addabsentee_2.php");
    } else if ($_GET['absentee'] == 2) {
        redirect("viewabsentee_2.php");
    } else if ($_GET['lockdown'] == 1) {
        redirect("addlockdown_2.php");
    } else if ($_GET['lockdown'] == 2) {
        redirect("viewlockdown_2.php");
    } else if ($_GET['late'] == 1) {
        redirect("addlate_2.php");
    } else if ($_GET['late'] == 2) {
        redirect("viewlate_2.php");
    } else if ($_GET['dress'] == 1) {
        redirect("adddress_2.php");
    } else if ($_GET['dress'] == 2) {
        redirect("viewdress_2.php");
    } else if ($_GET['test']) {
        redirect("test_2.php");
    } else if ($_GET['home']) {
        redirect("index_2.php");
    } else if ($_GET['calendar']) {
        redirect("addcalendar_2.php");
    } else if ($_GET['rcalendar']) {
        redirect("removecalendar_2.php");
    } else {
        $ref=@$HTTP_REFERER;
        echo $ref;
        if ($ref=="http://www.holyghostprep.org/page.cfm?p=1488") {
            redirect("/trackandfield/index.php");
        } else redirect("index_2.php");
        //http://www.plus2net.com/php_tutorial/php_referrer.php
    }
}

include 'includeInc_2.php';
dohtml_header("Login");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css_2.css" />
</head>
<body bgcolor=#CCCCCC>
	<table class="centered">
	<td class="centered">
        <form action=login_2.php?announcement=' <?php //echo $_GET['announcement'] . "&scheduleRoom=" . $_GET['scheduleRoom'] . "&scheduleMeeting=" . $_GET['scheduleMeeting'] . "&absentee=" . $_GET['absentee'] . "&lockdown=" . $_GET['lockdown'] . "&late=" . $_GET['late'] . "&dress=" . $_GET['dress'] . "&test=" . $_GET['test'] . "&home=" . $_GET['home']; ?>' method='post' name='theForm'>
            <?php if (isset($_GET['fail'])): ?>
                <font color=red>Login Failed</font><br>
            <?php endif; ?>
            <!--Username: <input type='text' name='username' /><br>change made here 10-03-13//--> 
            Username: <input type='text' name='username' onChange="javascript:this.value=this.value.toLowerCase();"/><br><!--change made here 10-03-13//--> 
            Password: <input type='password' name='password' /><br>
            <input type=submit name=submit value=Login>
    	</td>
	</table>
	<?php $db = null; 
        echo "<table class='centered'><td class='centered'>";
        homeLogout();
        echo "</td></table>";
        dohtml_footer(true);?>
