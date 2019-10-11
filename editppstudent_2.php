<?php

session_start();
include'functions_2.php';
password_protect();
include 'includeInc_2.php';
dohtml_header("Edit Permit");

$db = get_database_connection();
?>

<script type='text/javascript'>

    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
        formObject.action = "editppstudent_2.php";
    }

    //Confirms that all fields on form are filled out before submitting; alerts user if false
    function validateForm()
    {
        var make = document.forms["theForm"]["make"].value;
        var model = document.forms["theForm"]["model"].value;
        var year = document.forms["theForm"]["year"].value;
        var color = document.forms["theForm"]["color"].value;
        var licenseplate = document.forms["theForm"]["licenseplate"].value;
        var oldlicense = document.forms["theForm"]["oldlicense"].value;
        var oldmake = document.forms["theForm"]["oldmake"].value;
        var oldmodel = document.forms["theForm"]["oldmodel"].value;
        var oldyear = document.forms["theForm"]["oldyear"].value;
        var oldcolor = document.forms["theForm"]["oldcolor"].value;

        //var email=document.forms["theForm"]["email"].value;

        var s = "";

        //Where there is a value missing, s adds onto itself that box's error message
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
        if ((licenseplate === oldlicense) && (make === oldmake)) {
            if ((color === oldcolor) && (model === oldmodel)) {
                if (year === oldyear) {
                    s = s + "At least one field must be changed. \n";
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
    function cancel()
    {
        window.location.href = "http://advancedtopics.holyghostprep.org/advancedtopics/vpillinger/ehgp/viewmypermit_2.php";
    }
</script>
<table class='centered'>

    <form id='theForm' name='theForm' onsubmit='return validateForm();' method='post' action='submitpp_2.php'>
        <!--If at least one field is blank, the form wont submit-->
        <?php

        homeLogout();
        echo "<td>";
        echo "Your Student ID is " . $_SESSION['id'] . "<br/><br/><input type=hidden name=student value=" . $_SESSION['id'] . ">";

        $licenseplate = $_GET['licenseplate'];
        if (isset($licenseplate)) {
            $query = $db->prepare("SELECT * FROM parkingpermit WHERE studentid=:studentid AND licenseplate=:licenseplate");
            $query->bindValue(":licenseplate", $licenseplate);
            $query->bindValue(":studentid", $_SESSION['id']);
            $query->execute();
            if ($query->rowCount() == 0) {
                die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
            }
        } else {
            die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
        }
        $row = $query->fetch();
        $make = $row['make'];
        $model = $row['model'];
        $year = $row['year'];
        $color = $row['color'];
        //all of the hidden variables that make sure at least one box was changed
        echo "<input type='hidden' name='oldmake' value='" . $make . "'/>";
        echo "<input type='hidden' name='oldmodel' value='" . $model . "'/>";
        echo "<input type='hidden' name='oldyear' value='" . $year . "'/>";
        echo "<input type='hidden' name='oldcolor' value='" . $color . "'/>";
        echo "<input type='hidden' name='oldlicense' value='" . $licenseplate . "'/>";

        echo "Car Make:<input type='text' name='make' value='" . $make . "'/><br/>";
        echo "Car Model:<input type='text' name='model' value='" . $model . "'/><br/>";
        echo "Car Year:<input type='text' name='year' value='" . $year . "'/><br/>";
        echo "Car Color:<input type='text' name='color' value='" . $color . "'/><br/>";
        echo "License Plate: <input type='text' name='licenseplate' value='" . $licenseplate . "'><br/>";
        echo "Your existing Permit Number: ";
        echo $row['permitnumber'] . "<br/>";
        //echo "Email: <input type='text' name='email' value='" . $email . "'><br/>";
        $db = null;


        echo "<input type='submit' name='submit' value='Submit' onclick='send()'/>";
        echo "<input type='button' name='cancel' value='Cancel' onclick='self.location = \"viewmypermit_2.php\"'/><br/><br/>";
        echo "</td></form></table>";

        dohtml_footer(true);
        ?>
