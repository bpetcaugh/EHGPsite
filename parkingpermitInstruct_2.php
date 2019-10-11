<?php
//edited by Vincent Pillinger
//note: input fields need to be aligned, but page is functional
session_start();
include'functions_2.php';
password_protect();
include 'includeInc_2.php';
dohtml_header("Register a Car or Request a Permit");


?>

<table class='centered'>
<tr class='centered'>
<td width="10%"></td>
<td class="centered" colspan=2><h4>Students driving onto campus must register 
        their vehicle(s) and have a valid Holy Ghost Prep Parking Permit. The 
        HGP Parking Permit should be hung from the rear view mirror of any vehicle 
        that you drive onto campus. You only need one Parking Permit, even if 
        you have registered multiple vehicles, as long as you move the permit 
        from one vehicle to the next. You may purchase more than one permit if 
        desired. </h4>
      <h4>Parking Permits are obtained for $5 cash or check payable to "Holy Ghost 
        Prep" from the Dean of Discipline, Mr. Chapman. After registering your 
        vehicle on the next page, see Mr. Chapman with your $5 to obtain your 
        parking permit. </h4>
      <h4>Register another vehicle at any time through this website, always remembering 
        to transfer the permit from one vehicle to the other. </h4>
      <h4>To complete the form on the next page, you will need your vehicle's 
        make, model, year, color, and license plate number. If you are registering 
        an additional vehicle, you will also need your permit number. </h4></td><td width="10%"></td>
</tr></table>
<?php
//insertInRow("");
?>
<?php
//</tr><tr width='33%'></tr>
	//endAndBeginTable();
	//insertRowTableSpace();
	//insertRowTableSpace();
	//endAndBeginTable();
	//echo "<tr></tr>";
	endAndBeginTable();
	makeButton("Register Car/Request Permit","parkingpermit_2.php");
	endAndBeginTable();
	//echo "</td></tr>";
?>








<?php
/*$db = get_database_connection();
?>
<script type='text/javascript'>

    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
        formObject.action = "parkingpermit_2.php";
    }

    //Confirms that all fields on form are filled out before submitting; alerts user if false
    function validateForm()
    {
        //var studentid=document.forms["theForm"]["studentid"].value;
        var make = document.forms["theForm"]["make"].value;
        var model = document.forms["theForm"]["model"].value;
        var year = document.forms["theForm"]["year"].value;
        var color = document.forms["theForm"]["color"].value;
        var licenseplate = document.forms["theForm"]["licenseplate"].value;
        //var email=document.forms["theForm"]["email"].value;

        var s = "";

        //Where there is a value missing, s adds onto itself that box's error message

        if (make == null || make == "")
        {
            s = s + "Car make must be filled out.\n";
        }
        if (model == null || model == "")
        {
            s = s + "Car model must be filled out.\n";
        }
        if (year == null || year == "")
        {
            s = s + "Year must be filled out.\n";
        }
        if (color == null || color == "")
        {
            s = s + "Car color must be filled out.\n";
        }
        if (licenseplate == null || licenseplate == "")
        {
            s = s + "License plate must be filled out.\n";
        }

        //If s is still blank, all boxes have been filled, and the form is submitted
        //If not, the value of s is printed in the alert box, and the form is not submitted
        if (s == "")
        {
            return true;
        } else
        {
            alert(s);
            return false;
        }
        return false;
    }

    function send()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>

<table class='centered'>

    <form id='theForm' name='theForm' onsubmit='return validateForm()' method='post' action='submitpp_2.php'>
        <!--If at least one field is blank, the form wont submit-->
        <?php

        echo "<br/>";
        homeLogout();
        echo "<tr><td>";
        echo "Your Student ID is " . $_SESSION['id'] . "<br /><br /><input type=hidden name=student value=" . $_SESSION['id'] . ">";
        echo "</td></tr><tr><td>";
        $make = "";
        $model = "";
        $year = "";
        $color = "";
        $licenseplate = "";
        $existingnumber = "";
        //$email = '';

        echo "Car Make:<input type='text' name='make' value='" . $make . "'/><br/>";
        echo "Car Model:<input type='text' name='model' value='" . $model . "'/><br/>";
        echo "Car Year:<input type='text' name='year' value='" . $year . "'/><br/>";
        echo "Car Color:<input type='text' name='color' value='" . $color . "'/><br/>";
        echo " License Plate: <input type='text' name='licenseplate' value='" . $licenseplate . "'><br/>";
        echo "Existing Permit Number: <input type='text' name='existingnumber' value='" . $existingnumber . "'><br/>";
        echo "Note: Leave this field blank if you do not have an already existing parking permit.</br>";
        //echo "Email: <input type='text' name='email' value='" . $email . "'><br/>";

        $db = null;
        ?>

        <input type='submit' name='submit' value='Submit' onclick='send()'/>
        <input type='button' name='cancel' value='Cancel' onclick='self.location = "viewmypermit_2.php"'/><br/><br/><br/><br/>
        </td></tr>;
    </form>


</td>
</table>
*/
dohtml_footer(true);
?>