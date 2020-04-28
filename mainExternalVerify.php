<?php               //CK 3/10/14
session_start();
include 'functions_2.php';
include 'includeInc_2.php';
  
function died($error) { 
    dohtml_header("Report Help Failed");
    echo "<table class=centered>";
    echo "<tr><td> We are very sorry, but there were error(s) found with the form you submitted: <br /><br />" . $error . "<br />Please go back and fix these errors.</br></br></br></td></tr>";
    makeButton("Report Help", "maintenancerequest.php");
    homeLogout();
    echo "</table>";
    dohtml_footer(true);
}

$error_message = "";
if (isset($_POST['request'])) {
    if($_POST['request'] == 0){
        $error_message .= 'Please make a valid selection on your Problem Type. <br />';
    }
    if($_POST['urgency'] == 0){
        $error_message .= 'Please make a valid selection on your Urgency Level. <br />';
    }
    if($_POST['notes'] == ""){
        $error_message .= 'Please make a valid entry on your Notes Section. <br />';
    }
    //if error message isnt blank, display it and die
    if (strlen($error_message) > 0) {
        died($error_message);
    } else {
         redirect("submit_2.php?teacher=" . $_POST['teacher'] . "&request=" . $_POST['request'] . "&date=" . $_POST['date'] . "&urgency=" . $_POST['urgency'] . "&notes=" . str_replace(array("\n", "\t", "\r"), ' ', $_POST['notes']));
    }
}else{
   died('There appears to be an unknown problem with the form you submitted.'); 
}

?> 


