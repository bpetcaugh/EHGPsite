<?php
session_start(); //added 2-5-12
include 'functions_2.php';
password_protect();
?>
<style type="text/css">
    input {
        background-color: #FFFFFF;
        border: 2px solid #900000;
        font-family: verdana;
        font-size: 14px;
        color: #555555;
    }
</style>
<script type='text/javascript'>
function validateForm(){
	var x = document.forms["theForm"]["servicehours"].value;
    if (x == "" || isNaN(x)) {
        alert("Service hours must be filled out (numbers only)");
        return false;
    }
	var y = document.forms["theForm"]["date"].value;
    if (y == "") {
        alert("Date must be filled out");
        return false;
    }
	
	var validformat=/^\d{4}-\d{2}-\d{2}$/; //Basic check for format validity

    if(!validformat.test(document.forms["theForm"]["date"].value)) {
      alert("Invalid date format: yyyy-mm-dd");
      return false;
    }
	var z = document.forms["theForm"]["agency"].value;
    if (z == 0) {
        alert("Agency must be filled out");
        return false;
    }
	var a = document.forms["theForm"]["notes"].value;
    if (a == "" || a.length > 500) {
        alert("Description must be filled out and less than 500 characters");
        return false;
    }
}
</script>

<?php
$db = get_database_connection();

if (isset($_SESSION['username'])) {
    include 'includeInc_2.php';
    dohtml_header("Service Reporting");
?>

<?php
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $statement = $db->prepare("SELECT * FROM student WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    $row1 = $statement->fetch();
    if ($_SESSION['username'] == $row1['username'] && $_SESSION['password'] == trim($row1['password'])) {
        $sid = $row1['id'];
        $firstname = $row1['firstname'];
        $lastname = $row1['lastname'];
        ?>


        <form name='theForm' method='post' onsubmit="return validateForm()" action='serviceSubmit_2.php'>
            <table class='centered'>

                <?php
                homeLogoutService();
				tableRowSpace();
				endAndBeginTable();
                echo "<tr><td>Your Student ID is " . $_SESSION['id'] . "</td></tr>";
				tableRowSpace();
				echo "<input type=hidden name=student value=" . $_SESSION['id'] . ">";
                ?>
				    <table class="centered"><tr><td width=5%></td>
					<td width=90%>ALL service should be reported below, even service done through a school sponsored function.
						For school sponsored functions, such as the Cares Walk, the sponsoring teacher will verify your service, so
						no Service Verification Form is needed to be turned in to Mr. Whartenby. ALL other service reported online
						must also have a Service Verification Form turned in to Mr. Whartenby to verify the service performed.
					</td><td width=5%></td></tr></table> 
                <table>
        
				
				<tr><td width='70%'>            
							<?php
                            echo "Enter Service Hours: <t /><input type=text name=servicehours size=3>";
                            ?>
							
                        </td>
                        <td width='30%'>
                            
                        </td></tr><tr><td width='70%'>
                            
							<?php
                            echo "Date of Service:   <t /><input type=text name=date size=10'> (yyyy-mm-dd)";
                            ?>
							
                        </td>
                        <td width="30%">
                            
                        </td></tr><tr><td width='70%'>
                            
                            
							<?php
//agency drop down
                            $agid = 0; //not working for 2013; try to fix here; ck had name instead of id for option value value
                            $agency = "agency";
                            $stha = $db->prepare("SELECT * FROM agencies ORDER BY name");
                            $stha->execute();
                            if ($stha->rowCount() < 1)
                                return false;
                            echo "Select: <select name=agency>";
                            echo "<option value=0>Select Agency</option>";
                            while ($row2 = $stha->fetch()) {
                                //echo "<option value='" . $row2['name'] . "' ";
                                echo "<option value=\"{$row2['id']}\"";//Ricky Wang MMM concat change 4-22-16
                                
                                //echo ">" . $row2['name'] . "</option>";
                                echo ">{$row2['name']}</option>";//Ricky Wang MMM concat change 4-22-16
                            }
                            echo "</select>"; 
							//next two lines to see where problem is
							//echo $agid . "AGID";
							//if (isset($_POST[$agency])) echo $_POST[$agency];
                            //Not sure if the next two line are necessary, I just left them in in case
                            //echo "<input type=hidden value='" . $teacherid . "' name=teacherid>";
                            ?>
							
                        </td><td width="30%">
                            
                        </td></tr>
                </table>
                <br /><br />
                <table>
                    <tr><td>Please describe the type of service<br>that you performed at the service site:</td>
                        <td><textarea rows=5 cols=50 name='notes'></textarea></td></tr>
                </table>
                <br /><br /><center>
                    <input type='Submit' value='Submit'><br><br>
                    </form>
					
                    <?php
                }
            } else {
                redirect("login_2.php?serviceReportPageS_2.php");
            }
            $db = null;
            echo "</td></table>";
            dohtml_footer(true);
            ?>


