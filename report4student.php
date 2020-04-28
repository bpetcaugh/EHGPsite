<?php
session_start();
include 'functions.php';
password_protect();
//Displaying Infractions for Students
//Written by Ryan Raiker '12
//March/April, 2012

$db = get_database_connection();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
	$password = $_SESSION['password'];

    $statement = $db->prepare("SELECT * FROM student WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();
	
    $row1 = $statement->fetch();
    if ($_SESSION['username'] == $row1['username'] && $_SESSION['password'] == $row1['password']) {
        $sid = $row1['id'];
		$firstname = $row1['firstname'];
		$lastname = $row1['lastname'];
                $grade = $row1['grade'];
	}
}
?>
    <html>
		<head>
			<script type='text/javascript'>
            function refresh(){
                    var formObject = document.forms['theForm'];
                formObject.submit();
            }
            </script>
	<link rel="stylesheet" type="text/css" href="css.css" />
    <link rel ="stylesheet" type ="text/css" href ="table.css" />

		<title>Lates, Absentees & Infractions</title>
        </head>
<?php       
	echo "<body bgcolor=#CCCCCC>";
	echo "<center><h1>View All Lates, Absentees, and Infractions</h1></center>";
    echo "<center><h2>Welcome " . $firstname . " view your information below.</h2></center>";
    echo "<br/>";      

    echo "<center><a href=index.php>EHGP Home</a>&nbsp&nbsp<a href=logout.php>Logout</a></center><br />";
    echo "<center><a href=http://www.holyghostprep.org>Holy Ghost Prep Home Page</a></center>";
    echo "<hr>";

$tempSessionName=$lastname . ", " . $firstname;  //assign $tempSessionName to the user logged in
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Lates displayed here
echo "<center><b>".$firstname." ".$lastname."'s Lates.</b></center><br/>";
        $query = $db->prepare("SELECT * FROM late WHERE name LIKE :tmpname AND grade LIKE :gr"); //where added to stop whole table from being selected
        $query->bindValue(":tmpname", $tempSessionName);
        $query->bindValue(":gr", $grade);
        $query->execute();
        echo "<table align=center border=1><tr><th>Teacher</th><th>Period</th><th>Minutes Late</th><th>Date</th></tr>";          
    while ($row = $query->fetch()) {
        $tempRowName = $row['name'];
        if (strcmp($tempSessionName,  $tempRowName) == 0){
            echo "<tr><td>" . $row['teacher'] . "</td><td>" . $row['period'] . "</td><td>" . $row['minutes'] . "</td><td>". $row['date']."</td>";
            echo "</tr>";
        }
    }
        echo "</table>";
        echo "<hr>";

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Absences displayed here
echo "<center><b>".$firstname." ".$lastname."'s Absences.</b></center><br/>";

    //$rows = $db->query("SELECT * FROM absentee ORDER BY date");
    $query = $db->prepare("SELECT * FROM absentee WHERE name LIKE :tmpname AND grade LIKE :gr");
    $query->bindValue(":tmpname", $tempSessionName);
    $query->bindValue(":gr", $grade);
    $query->execute();
    echo "<table align=center border=1><tr><th>Teacher</th><th>Notes</th><th>Date</th></tr>";           
    while ($row = $query->fetch()) {
        $tempRowName = $row['name'];
        if (strcmp($tempSessionName,  $tempRowName) == 0){
                echo "<tr><td>" . $row['teacher'] . "</td><td>" . $row['notes'] . "</td><td>". $row['date']."</td>";
                echo "</tr>";
        }
    }
    echo "</table>";
    echo "<hr>";

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Dress code violations displayed here
 echo "<center><b>".$firstname." ".$lastname."'s Dress Code Violations.</b></center><br/>";
    $query = $db->prepare("SELECT * FROM dress WHERE name LIKE :tmpname AND grade LIKE :gr");
     $query->bindValue(":tmpname", $tempSessionName);
    $query->bindValue(":gr", $grade);
    $query->execute();
    echo "<table align=center border=1><tr><th>Violation</th><th>Notes</th><th>Date</th></tr>";           
    while ($row = $query->fetch()) {
        $tempRowName = $row['name'];
        if (strcmp($tempSessionName,  $tempRowName) == 0){
            //echo "i got here<br/>";
            echo "<td>" . $row['violation'] . "</td><td>" . $row['notes'] . "</td><td>". $row['date']."</td>";
            echo "</tr>";
        }
}       
    echo "</table>";    
	$db = null;    
?>
</body>
</html>
