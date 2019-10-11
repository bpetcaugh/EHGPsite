<?php
/*Fred Kummer '13
 * Adapted by Robert Conway '13
 fixed by Eric Ghildyal and added/checked by mmm  7-30-15*/
session_start();
include 'functions_2.php';
password_protect();
//include 'studentpicker_2.php';
super_admin_only();
include 'includeInc_2.php';
dohtml_header("Change Password");
?>

<!--<script type="text/javascript" src="strengthmeter_2.js"></script>//-->
<link rel="stylesheet" type="text/css" href="chgpasscss_2.css" />
<!--<script>
function passwordStrength(password) {
    var desc = new Array();

    desc[0] = "Does not meet requirements";

	desc[1] = "Weak";

	desc[2] = "Medium";

	desc[3] = "Strong";

	var score=0;

	if(password.length > 8){
		document.getElementById("subPass").style.visibility="visible";
		if ((password.match(/[a-z]/))  && (password.match(/[A-Z]/))){

			if (password.match(/\d+/)){
				score++;
				//if password has at least one special character give 1 point
				if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ){
					score++;
				}
				//if password bigger than 12 give another 1 point
				if (password.length > 12){
					score++;
				}
			}else{
				document.getElementById("subPass").style.visibility="hidden";
			}
		}else{
			document.getElementById("subPass").style.visibility="hidden";
		}
	}else{
		document.getElementById("subPass").style.visibility="hidden";
	}

	document.getElementById("passwordDescription").innerHTML = desc[score];

	document.getElementById("passwordStrength").className = "strength" + score;

}//-->
<script>
	function confirmPass(){
		var pass = document.forms['theForm2']['newpassword'].value;
		var conf = document.forms['theForm2']['confirmnewpassword'].value;
		if(pass !== conf){
			alert("Your confirmation does not match what you originally typed");
			return false;
		}
		return true;
	}
</script>

	<table class="centered">
     <tr>
	<td>

<?php
function get_students(){
	$db = get_database_connection();
    $statement = $db->prepare("SELECT firstname,lastname,classnum FROM student ORDER BY lastname");
    $statement->execute();
	$db= null;
	return $statement->fetchAll();
}

	$student = '';
	if (isset($_POST['student'])) {
		$student = $_POST['student'];
	}
//	echo"<form name='theFormS' action='chgpassS_2.php' method='get'>
//	<select name='student' onchange='refresh()'>
//	<option value = ' '>Choose a student</option>";
//
//	$rows = get_students();
//	foreach ($rows as $row) {
//		$lastname = $row['lastname'];
//		$firstname = $row['firstname'];
//		$classnum = $row['classnum'];
//		echo "<option value=" . $classnum;
//		if ($classnum == $student) {
//			echo " selected=selected";
//		}
//		echo ">" . $lastname .", ". $firstname . "</option>";
//	}
//	echo "</select></form>";
	// foreach ($rows as $row) {
	// 	echo $row['name'];
	// }



                        //studentSelector('chgpassS_2.php');
                        //$_SESSION['passnameid']=$_GET['student'];
						if (isset($_POST['student'])) {
                            $_SESSION['passnameid'] = $_POST['student'];
                        }
						if(isset($_POST['student'])){
							echo "Student Number == " . $_POST['student'];
						}
                        ?>

			<table border="1" class="centered250">
			<tr>
			<td >Passwords must be at least 8 characters and contain a lowercase letter, uppercase letter, and a digit.</td>
			</tr>
			</table>

			<form action='submitPassS_2.php' method='post' onsubmit="return confirmPass()" name='theForm2'>
<?php

echo"<select name='student' onchange='refresh()'>";
echo "<option value = ' '>Choose a student</option>";

	$rows = get_students();
	foreach ($rows as $row) {
		$lastname = $row['lastname'];
		$firstname = $row['firstname'];
		$classnum = $row['classnum'];
		echo "<option value=" . $classnum;
		if ($classnum == $student) {
			echo " selected=selected";
		}
		echo ">" . $lastname .", ". $firstname . "</option>";
	}
	echo "</select></td></tr>";
?>
			<tr><td>
 			New Password: <input type="password" name="newpassword" id="pass" onkeyup="passwordStrength(this.value)" /><br/>

 			Confirm New Password: <input type='password' name='confirmnewpassword' /><br>

			<!--<label for="passwordStrength">Password strength</label>

            <div id="passwordDescription">Password not entered</div>

            <table class="centered">
            <tr class="centeredButton"><td class="centered">
            <div id="passwordStrength" class="strength0"></div><br/>
            </td></tr>
            </table>//-->
            <!--<input type=submit id="subPass" name=submit style="visibility:hidden" value='Change Password'/>//-->
			<input type=submit id="subPass" name=submit value='Change Password'/>


		</form>

	</td></tr>

	<?php
	homeLogout();
	?>

	</table>
    <?php
	dohtml_footer(true);
	?>
