<?php
//session_start();
$_SESSION = array();
//session_regenerate_id();
//if (isset(session_id()) && session_id!="") { session_destroy();} //added these three lines in case somebody didnt logout
session_start();

include 'functions.php';

$db = get_database_connection();

if (isset($_POST['password'])) {
    if (login($_POST['username'], md5($_POST['password']))) {
        if ($_GET['announcement'] == 1) {
            redirect("addannouncement.php");
        } else if ($_GET['scheduleRoom'] == 1) {
            redirect("scheduleRoom.php");
        } else if ($_GET['scheduleMeeting'] == 1) {
            redirect("scheduleMeeting.php");
        } else if ($_GET['absentee'] == 1) {
            redirect("addabsentee.php");
        } else if ($_GET['absentee'] == 2) {
            redirect("viewabsentee.php");
        } else if ($_GET['lockdown'] == 1) {
            redirect("addlockdown.php");
        } else if ($_GET['lockdown'] == 2) {
            redirect("viewlockdown.php");
        } else if ($_GET['late'] == 1) {
            redirect("addlate.php");
        } else if ($_GET['late'] == 2) {
            redirect("viewlate.php");
        } else if ($_GET['dress'] == 1) {
            redirect("adddress.php");
        } else if ($_GET['dress'] == 2) {
            redirect("viewdress.php");
        } else if ($_GET['test']) {
            redirect("test.php");
        } else if ($_GET['home']) {
            redirect("index.php");
        } else if ($_GET['calendar']) {
            redirect("addcalendar.php");
        } else if ($_GET['rcalendar']) {
            redirect("removecalendar.php");
        } else {
            $ref=@$HTTP_REFERER;
            echo $ref;
            if ($ref=="http://www.holyghostprep.org/page.cfm?p=1488") {
                redirect("/trackandfield/index.php");
            } else redirect("index.php");
            //http://www.plus2net.com/php_tutorial/php_referrer.php
        }
    } else {
        redirect("login.php?fail=1&announcement=" . $_GET['announcement'] . "&scheduleRoom=" . $_GET['scheduleRoom'] . "&absentee=" . $_GET['absentee'] . "&lockdown=" . $_GET['lockdown'] . "&late=" . $_GET['late'] . "&dress=" . $_GET['dress'] . "&test=" . $_GET['test'] . "&home=" . $_GET['home']);
    }
} else if (check_logged_in()) {
    if ($_GET['announcement'] == 1) {
        redirect("addannouncement.php");
    } else if ($_GET['scheduleRoom'] == 1) {
        redirect("scheduleRoom.php");
    } else if ($_GET['scheduleMeeting'] == 1) {
        redirect("scheduleMeeting.php");
    } else if ($_GET['absentee'] == 1) {
        redirect("addabsentee.php");
    } else if ($_GET['absentee'] == 2) {
        redirect("viewabsentee.php");
    } else if ($_GET['lockdown'] == 1) {
        redirect("addlockdown.php");
    } else if ($_GET['lockdown'] == 2) {
        redirect("viewlockdown.php");
    } else if ($_GET['late'] == 1) {
        redirect("addlate.php");
    } else if ($_GET['late'] == 2) {
        redirect("viewlate.php");
    } else if ($_GET['dress'] == 1) {
        redirect("adddress.php");
    } else if ($_GET['dress'] == 2) {
        redirect("viewdress.php");
    } else if ($_GET['test']) {
        redirect("test.php");
    } else if ($_GET['home']) {
        redirect("index.php");
    } else if ($_GET['calendar']) {
        redirect("addcalendar.php");
    } else if ($_GET['rcalendar']) {
        redirect("removecalendar.php");
    } else {
        $ref=@$HTTP_REFERER;
        echo $ref;
        if ($ref=="http://www.holyghostprep.org/page.cfm?p=1488") {
            redirect("/trackandfield/index.php");
        } else redirect("index.php");
        //http://www.plus2net.com/php_tutorial/php_referrer.php
    }
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css.css" />
</head>
<body bgcolor=#CCCCCC>
	<table align=center>
	<td>
    	<h1 align=center>Login</h1>
        <form action=login.php?announcement=' <?php //echo $_GET['announcement'] . "&scheduleRoom=" . $_GET['scheduleRoom'] . "&scheduleMeeting=" . $_GET['scheduleMeeting'] . "&absentee=" . $_GET['absentee'] . "&lockdown=" . $_GET['lockdown'] . "&late=" . $_GET['late'] . "&dress=" . $_GET['dress'] . "&test=" . $_GET['test'] . "&home=" . $_GET['home']; ?>' method='post' name='theForm'>
            <?php if (isset($_GET['fail'])): ?>
                <font color=red>Login Failed</font><br>
            <?php endif; ?>
            Username: <input type='text' name='username' /><br>
            Password: <input type='password' name='password' /><br>
            <input type=submit name=submit value=Login>
        </form><a href=index.php>Home</a>
    	</td>
	</table>
	<?php $db = null; ?>
</body>
</html>