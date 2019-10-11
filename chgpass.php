<?php
session_start();
include 'functions.php';

password_protect();
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="css.css" />
</head>
    
<body bgcolor=#CCCCCC>
        
<h1 align=center>Change Password</h1>
        
	<table align=center>
            
	<td>
                
		<form action=submit.php method='post' name='theForm'>

 			New Password: <input type='password' name='newpassword' /><br>

 			Confirm New Password: <input type='password' name='confirmnewpassword' /><br>

 			<input type=submit name=submit value='Change Password'/>
                
		</form>
            
	</td>
            
	<a href=index.php>Home</a>
        
	</table>
    
</body>

</html>

