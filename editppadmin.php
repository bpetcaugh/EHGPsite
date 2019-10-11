<?php
session_start();
include'functions.php';
password_protect();


$db = get_database_connection();
?>

<html>
    <title>Edit Permit</title>
    <head>
        <script type='text/javascript'>

            function refresh()
            {
                var formObject = document.forms['theForm'];
                formObject.submit();
                formObject.action = "editppadmin.php";
            }

            //Confirms that all fields on form are filled out before submitting; alerts user if false
            function validateForm()
            {
                var studentid = document.forms["theForm"]["sid"].value;
                var make = document.forms["theForm"]["make"].value;
                var model = document.forms["theForm"]["model"].value;
                var year = document.forms["theForm"]["year"].value;
                var color = document.forms["theForm"]["color"].value;
                var permit = document.forms["theForm"]["permitnumber"].value;
                var verifyRadios = document.getElementsByName("verify");//I hate radio buttons forever
                var licenseplate = document.forms["theForm"]["licenseplate"].value;
                var oldlicense = document.forms["theForm"]["oldlicense"].value;
                var oldmake = document.forms["theForm"]["oldmake"].value;
                var oldstudentid = document.forms["theForm"]["oldsid"].value;
                var oldmodel = document.forms["theForm"]["oldmodel"].value;
                var oldyear = document.forms["theForm"]["oldyear"].value;
                var oldcolor = document.forms["theForm"]["oldcolor"].value;
                var oldpermit = document.forms["theForm"]["oldpermitnumber"].value;
                var oldverify = document.forms["theForm"]["oldverify"].value;
                var verify = 0;
                //var email=document.forms["theForm"]["email"].value;

                //radio buttons are stupid and have to be done this way, no easily getting value of checked dial. 
                //That makes too much sense for javascript.               
                for (var i = 0; i < verifyRadios.length; i = i+1) {
                    if (verifyRadios[i].checked) {
                        verify = verifyRadios[i].value;
                        break;
                    }
                }
              
                var s = "";

                //Where there is a value missing, s adds onto itself that box's error message
                if (permit === null || permit === "") {
                    s = s + "Permitnumber make must be filled out.\n";
                }
                if (studentid === null || studentid === "") {
                    s = s + "Studentid make must be filled out.\n";
                }
                if (make === null || make === "")
                {
                    s = s + "Car make must be filled out.\n";
                }
                if (model === null || model === "")
                {
                    s = s + "Car model must be filled out.\n";
                }
                if (year === null || year === "")
                {
                    s = s + "Year must be filled out.\n";
                }
                if (color === null || color === "")
                {
                    s = s + "Car color must be filled out.\n";
                }
                if (licenseplate === null || licenseplate === "")
                {
                    s = s + "License plate must be filled out.\n";
                }
                if ((licenseplate === oldlicense) && (make === oldmake)){
                    if ((color === oldcolor) && (model === oldmodel)){
                        if ((year === oldyear) && (studentid === oldstudentid)){
                            if ((permit === oldpermit) && (verify === oldverify)) {
                                s = s + "At least one field must be changed. \n";
                            }
                        }
                    }
                }

                //If s is still blank, all boxes have been filled, and the form is submitted
                //If not, the value of s is printed in the alert box, and the form is not submitted
                if (s === "") {
                    return true;
                }
                alert(s);
                return false;
            }

            function send()
            {
                var formObject = document.forms['theForm'];
                formObject.submit();
            }
        </script>
    </head>
    <body bgcolor='#CCCCCC'>
    <center><h1>Edit Parking Permit</h1></center>
    <table align='center'>
        <td>
            <form id='theForm' name='theForm' onsubmit='return validateForm();' method='post' action='submitppadmin.php'>
                <!--If at least one field is blank, the form wont submit-->
                <?php
                echo "<br/>";



                $licenseplate = $_GET['licenseplate'];
                $sid = $_GET['sid'];
                if (isset($licenseplate) && isset($sid)) {
                    $query = $db->prepare("SELECT * FROM parkingpermit WHERE studentid=:studentid AND licenseplate=:licenseplate");
                    $query->bindValue(":licenseplate", $licenseplate);
                    $query->bindValue(":studentid", $sid);
                    $query->execute();
                    if ($query->rowCount() == 0) {
                        die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
                    }
                } else {
                    die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
                }
                echo "<center>Student: " . getFullName($sid, $db) . "<br /> StudentID: " . $sid . "<br/><br/></center>";

                $row = $query->fetch();
                $make = $row['make'];
                $model = $row['model'];
                $year = $row['year'];
                $color = $row['color'];
                $permitnumber = $row['permitnumber'];
                $verify = $row['verify'];
                //all of the hidden variables that make sure at least one box was changed
                echo "<input type='hidden' name='oldsid' value='" . $sid . "'/><br/>";
                echo "<input type='hidden' name='oldmake' value='" . $make . "'/><br/>";
                echo "<input type='hidden' name='oldmodel' value='" . $model . "'/><br/>";
                echo "<input type='hidden' name='oldyear' value='" . $year . "'/><br/>";
                echo "<input type='hidden' name='oldcolor' value='" . $color . "'/><br/>";
                echo "<input type='hidden' name='oldpermitnumber' value='" . $permitnumber . "'/><br/>";
                echo "<input type='hidden' name='oldverify' value='" . $verify . "'/><br/>";
                echo "<input type='hidden' name='oldlicense' value='" . $licenseplate . "'/><br/>";

                //all input boxes
                echo "StudentID:<input type='text' name='sid' value='" . $sid . "'/><br/>";
                echo "Car Make:<input type='text' name='make' value='" . $make . "'/><br/>";
                echo "Car Model:<input type='text' name='model' value='" . $model . "'/><br/>";
                echo "Car Year:<input type='text' name='year' value='" . $year . "'/><br/>";
                echo "Car Color:<input type='text' name='color' value='" . $color . "'/><br/>";
                echo "License Plate: <input type='text' name='licenseplate' value='" . $licenseplate . "'><br/>";
                echo "Permitnumber: <input type='text' name='permitnumber' value='" . $permitnumber . "'><br/>";
                if ($verify == 0) {
                    echo "Verified: <input type='radio' name='verify' value='1'   /> 
                          Unverify: <input type='radio' name='verify' value='0' checked /> <br />";
                } else {
                    echo "Verified: <input type='radio' name='verify' value='1' checked /> 
                          Unverify: <input type='radio' name='verify' value='0'/> <br />";
                }
                ?>
                <input type='submit' name='submit' value='Submit' onclick='send()'/>
                <input type='button' name='cancel' value='Cancel' onclick='self.location = "viewpp.php"'/><br/><br/>
            </form>
            </select><a href=index.php>Home</a><br/><br/><a href=logout.php>Logout</a></center><br><br>

        </td>
    </table>
</body>
</html>