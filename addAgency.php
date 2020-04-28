<?PHP
session_start();
include 'functions.php';
serv_admin_only();
password_protect("login.php?agency=1");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css.css" />
</head>
<body bgcolor=#CCCCCC>
       
    <center><h1>Add Service Agency</h1></center>
    <table align=center><td><form action='submit.php' method='post'>
                <?php 
				//$tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
                //echo "Date:<input type=text name=date value='" . date('Y-m-d', $tomorrow) . "'><br>"; ?>
                <br>
                <p><center>Type in the name of the agency to be added below. <br><br>
				<div>Use the View Agency Activity button to be certain 
				<br>that you are not adding a duplicate before 
				<br> adding an agency here.</div></center></p>
                <br>
				<?php
				echo "<input type='text' name='agency' size=50><br>";
				?>
                <br>
				<br>
			<center>
                <input type='submit' name='submit' value='Submit'><br><br>
                <a href=index.php>Home</a>
            </form>
            <a href=logout.php>Logout</a>
			</center>
    </td></table>
</body>
</html>
