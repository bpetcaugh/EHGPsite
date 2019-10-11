<?php
session_start();
include'functions.php';
password_protect();


$db = get_database_connection();

?>

        <html>
        <title>Request Permit</title>
            <head>
                <script type='text/javascript'>

                    function refresh()
                    {
                        var formObject = document.forms['theForm'];
                        formObject.submit();
                        formObject.action="parkingpermit.php";
                    }

                    //Confirms that all fields on form are filled out before submitting; alerts user if false
                    function validateForm()
                    {
                        //var studentid=document.forms["theForm"]["studentid"].value;
                        var make=document.forms["theForm"]["make"].value;
                        var model=document.forms["theForm"]["model"].value;
                        var year=document.forms["theForm"]["year"].value;
                        var color=document.forms["theForm"]["color"].value;
                        var licenseplate=document.forms["theForm"]["licenseplate"].value;
                        //var email=document.forms["theForm"]["email"].value;

                        var s="";
                        
                        //Where there is a value missing, s adds onto itself that box's error message
                       
                        if (make==null || make=="")
                        {
                            s=s+"Car make must be filled out.\n";
                        }
                        if (model==null || model=="")
                        {
                            s=s+"Car model must be filled out.\n";
                        }
                        if (year==null || year=="")
                        {
                            s=s+"Year must be filled out.\n";
                        }
                        if (color==null || color=="")
                        {
                            s=s+"Car color must be filled out.\n";
                        }
                        if (licenseplate==null || licenseplate=="")
                        {
                            s=s+"License plate must be filled out.\n";
                        }

                        //If s is still blank, all boxes have been filled, and the form is submitted
                        //If not, the value of s is printed in the alert box, and the form is not submitted
                        if (s=="")
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
            </head>
            <body bgcolor='#CCCCCC'>
                <center><h1>Register for Parking Permit</h1></center>
                <table align='center'>
                    <td>
                        <form id='theForm' name='theForm' onsubmit='return validateForm()' method='post' action='submitpp.php'>
                            <!--If at least one field is blank, the form wont submit-->
                    <?php
                     
                    echo "<br/>";

                    echo "<center>Your Student ID is " . $_SESSION['id'] . "<br /><br /><br /><input type=hidden name=student value=" . $_SESSION['id'] . "></center>";
                          
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
                    <input type='button' name='cancel' value='Cancel' onclick='self.location = "viewmypermit.php"'/><br/><br/><br/><br/>
                </form>
      </select><a href=index.php>Home</a><br/><br/><a href=logout.php>Logout</a></center><br><br>

            </td>
        </table>
    </body>
</html>