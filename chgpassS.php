<?php
session_start();
include 'functions.php';
include 'studentpicker.php';
super_admin_only();

password_protect();
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="css.css" />
</head>
    
<body>
        
<h1 align=center>Change Password</h1>
        
	<table align=center>
            
	<td>
                        <?php
                       
						studentSelector('chgpassS.php');
                        if (isset($_GET['student'])) {
                            $_SESSION['passnameid'] = $_GET['student'];
                        }
						if(isset($_GET['student'])){
							echo "Student Number == " . $_GET['student'];
						}
                        ?>

                
		<form action=submitPass.php method='post' name='theForm2'>

 			New Password: <input type='password' name='newpassword' /><br>

 			Confirm New Password: <input type='password' name='confirmnewpassword' /><br>

 			<input type=submit name=submit value='Change Password'/>
                
		</form>
            
	</td>
            
	<a href=index.php>Home</a>
        
	</table>
    
</body>

</html>

