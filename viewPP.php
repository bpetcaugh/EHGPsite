<?php
session_start();
include 'functions.php';
att_admin_only();
password_protect();
$db = get_database_connection();
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $checkRow = false;
    if (isset($_GET['remove'])) {
        $tempRemove = $_GET['remove'];
        $tempVerify = $_GET['verify'];
        if (isset($tempVerify)) {
            if (isset($_GET['newPermit'])) { //for addition of permits
                $tempPermit = $_GET['newPermit'];
                $query = $db->prepare("UPDATE parkingpermit SET verify=:verify, permitnumber=:permitnum WHERE studentid=:studentid");
                $query->bindValue(":studentid", $tempRemove);
                $query->bindValue(":verify", $tempVerify);
                $query->bindValue(":permitnum", $tempPermit);
                $query->execute();
                $checkRow = true;
            } else {
                redirect("selectPermitNumber.php?remove=" . $tempRemove . "&action=" . $action);
            }
        } else if (isset($_GET['licenseplate'])) {//for removal of permits
            $licenseplate = $_GET['licenseplate'];
            $query = $db->prepare("DELETE FROM parkingpermit WHERE studentid=:studentid AND licenseplate=:licenseplate");
            $query->bindValue(":licenseplate", $licenseplate);
            $query->bindValue(":studentid", $tempRemove);
            $query->execute();
            $checkRow = true;
        }if ($checkRow) {
            if ($query->rowCount() == 0) {
                die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
            } else {
                redirect("viewPP.php?action=" . $action);
            }
        }
    }
}
?>
<html>
    <head>
        <script type='text/javascript'>
            function makeConfirm()
            {
                return confirm('Are you sure that you want to delete this permit?\n\
                                There is no way to undo this action.');
            }
            function refresh()
            {
                var formObject = document.forms['theForm'];
                formObject.submit();
            }
        </script>
    </head>
    <link rel="stylesheet" type="text/css" href="css.css" />
    <body bgcolor=#CCCCCC>

        <?php
        $action = 'studentid';
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        }

        echo '<h1 align="center">Parking Permits</h1><br>';

        //drop down menu decarlation and page header
        echo "<h2 align=center>" . 'Order by' . "<br></h2>
            <br><center><form name='theForm' action='viewPP.php' 
             method='get'><select name='action' onchange='refresh()'>";
        //options that can be picked, also selects the option that has been selected before the past page reset
        $options = array('studentid', 'make', 'model', 'color', 'year', 'licenseplate', 'permitnumber', 'verify');

        foreach ($options as $option) {
            echo "<option value=" . $option;
            if ($option == $action) {
                echo " selected=selected";
            }
            echo ">" . $option . "</option>";
        }

        echo "</select>&nbsp&nbsp<a href=index.php>Home</a>&nbsp&nbsp<a href=logout.php>Logout</a></center><br><hr>";

        $query = $db->prepare("SELECT * FROM parkingpermit ORDER BY {$action}");
        $query->execute();


        //print out table that displays all of the current parking permits
        echo "<table align=center border=1><tr><th>Student</th><th>Make</th><th>Model</th>
        <th>Color</th><th>Year</th><th>License Plate</th><th>Permit Number</th><th>Verified</th></tr>";
        while ($row = $query->fetch()) {
            //convert studentid to full name
            $stuid = $row['studentid'];
            $curName = getFullName($stuid);
            $YorN = "no";
            $verifable = true;
            if ($row['verify'] == "1") {
                $YorN = "yes";
                $verifable = false;
            }

            $licenseplate = $row['licenseplate'];
            echo "</tr><td>" . $curName . "</td><td>" . $row['make'] .
            "</td><td>" . $row['model'] . "</td><td>"
            . $row['color'] . "</td><td>" . $row['year'] . "</td><td>" . $licenseplate . "</td><td>"
            . $row['permitnumber'] . "</td><td>"
            . $YorN . "</td><td>" . "<a href='viewPP.php?remove=" . $stuid . "&licenseplate=" . $licenseplate . "&action=" . $action . "'onclick='return makeConfirm();'>Remove</a></td><td>"
            . "<a href=editppadmin.php?sid=" . $stuid . "&licenseplate=" . $licenseplate . ">Edit</td>";
            if ($verifable)
                echo "<td><a href=viewPP.php?remove=" . $stuid . "&verify=1&action=" . $action . ">Verify</a></td>";
            echo "</tr>";
        }
        echo "</table>";

        if ($query->rowCount() == 0)
            echo "<h3 align=center> No Parking Permits Existing.</h3>";
        $db = null;

        echo "</body></html>";
        ?>
    
