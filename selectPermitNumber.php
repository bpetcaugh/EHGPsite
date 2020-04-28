<?php
session_start();
include 'functions.php';
att_admin_only();
password_protect();
?>
<html>
    <head>
        <script type='text/javascript'>
            function promptText(message, x, y) {
                var newPermit = prompt(message);
                var newLoc = "viewPP.php?remove="
                        + x + "&verify=1" + "&action=" + y + "&newPermit=" + newPermit;
                window.location = newLoc;
            }
        </script>
    </head>
    <link rel="stylesheet" type="text/css" href="css.css" />
    
<?php   
    if (isset($_GET['action']) && isset($_GET['remove'])){
         $tempRemove = $_GET['remove'];
         $action = $_GET['action'];
         $tempString = "Please enter students Parking Permit number";

         echo "<script>promptText( '" . $tempString . "', '" . $tempRemove . "', '" . $action . "')</script>";
    } 
    else{
        die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    }
?>