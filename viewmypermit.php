<?php
session_start();
include'functions.php';
password_protect();


$db = get_database_connection();

if (isset($_GET['licenseplate'])) {
    $licenseplate = $_GET['licenseplate'];
    $sid = $_SESSION['id'];
    $query = $db->prepare("DELETE FROM parkingpermit WHERE studentid=:studentid AND licenseplate=:licenseplate");
    $query->bindValue(":licenseplate", $licenseplate);
    $query->bindValue(":studentid", $sid);
    $query->execute();
    if ($query->rowCount() < 1) {
        die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    }
}
?>
<html>

    <head>
        <title>View Permit Status</title>
         <script type='text/javascript'>

                    function makeConfirm()
                    {
                        return confirm('Are you sure that you want to delete this permit?\n\
                                There is no way to undo this action.');
                    }
         </script>
    </head>
    <h1 align="center">Existing Permits</h1>
    </br>
    </br>
    </br>

    <body bgcolor=#CCCCCC>
    <center><a href=parkingpermit.php>Apply for new Permits</a></br>
        <a href=index.php>Home</a>&nbsp&nbsp<a href=logout.php>Logout</a></center>
    <?php
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        //get students id
        $statement = $db->prepare("SELECT * FROM student WHERE username=:username AND password=:password");
        $statement->bindValue(":username", $username);
        $statement->bindValue(":password", $password);
        $statement->execute();
        //get students permits
        $row1 = $statement->fetch();
        $id = $row1['id'];
        $query = $db->prepare("SELECT * FROM parkingpermit WHERE studentid=:studentid");
        $query->bindValue(":studentid", $id);
        $query->execute();
        //print students permits
        echo "<table align=center border=1><tr><th>Student</th><th>Make</th><th>Model</th>
        <th>Color</th><th>Year</th><th>License Plate</th><th>Permit Number</th><th>Verified</th></tr>";
        while ($row = $query->fetch()) {
            //convert studentid to full name
            $stuid = $row['studentid'];
            $curName = getFullName($stuid);
            $YorN = "no";
            if ($row['verify'] == "1") {
                $YorN = "yes";
            }
            echo "</tr><td>" . $curName . "</td><td>" . $row['make'] .
            "</td><td>" . $row['model'] . "</td><td>"
            . $row['color'] . "</td><td>" . $row['year'] . "</td><td>" . $row['licenseplate'] . "</td><td>"
            . $row['permitnumber'] . "</td><td>"
            . $YorN . "</td><td> <a href=editppstudent.php?licenseplate=" . $row['licenseplate'] . ">Edit</a></td>
                <td><a  href='viewmypermit.php?licenseplate=" . $row['licenseplate'] . "' onclick='return makeConfirm();'>Remove</a></td></tr>";
        }
        echo "</table>";

        if ($query->rowCount() == 0)
            echo "<h3 align=center> No Parking Permits Existing.</h3>";
        $db = null;

        echo "</body></html>";
    } else {
        die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    }
    ?>


