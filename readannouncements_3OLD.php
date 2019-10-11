<head>
<style type="text/css">
<!--

@media print
{
.noprint {display:none;}
}

@media screen
{
...
}

-->
</style>
</head>
<?php
session_start();
include 'functions_2.php';
$db = get_database_connection();

if (isset($_GET['remove']) && check_logged_in()) {
    $query = $db->prepare("DELETE FROM announcements WHERE id=:id AND teacher=:teacher");
    $query->bindValue(":id", $_GET['remove']);
    $query->bindValue(":teacher", $_SESSION['name']);
    $query->execute();

    if ($query->rowCount() != 1)
        die("Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    else
        redirect("readannouncements_2.php?date=" . $_GET['date']);
}
if (isset($_GET['edit']) && check_logged_in()) {
    $announcements = $db->prepare("SELECT * FROM announcements WHERE id=:id AND teacher=:teacher");
    $announcements->bindValue(":id", $_GET['edit']);
    $announcements->bindValue(":teacher", $_SESSION['name']);
    $announcements->execute();    
    
    if ($announcements->rowCount() != 1){
        die($announcements->rowCount()." Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
    }else{
        $row = $announcements -> fetch();
        //$announcement = $row['announcement']; //issue to be fixed later: if announcement contains something like a & the edit will not work exactly right
        $grade = $row['grade'];
            
        redirect("addannouncement_2.php?date=" . $_GET['date'] ."&?grade=" .$grade. "&?id=".$_GET['edit']);        
    }
}

include 'includeInc_2.php';
dohtml_header("Daily Announcements");
?>
<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script> 

<!--<body> mmm removed 3-10-14 //-->
    <?php
    $date = date('Y-m-d');
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
    }
	
    echo "<table class='centered'>";
    homeLogout();
    echo "<tr class='centered'><td class='centered'>";
    echo "</td></tr>";
    echo "<tr class='centered'>
			<td class='centered'>";
    echo "<h2>" . date('l', strtotime($date)) . ", " . $date . "</h2></td></tr>";
	
	echo "<tr class='centered'>
			<td class='centered'>";
    echo"<form name='theForm' action='readannouncements_2.php' method='get'>Date to View: <select name='date' onchange='refresh()'>";

    $rows = $db->query("SELECT * FROM announcements ORDER BY date DESC");
    $temp = 0;
    echo "<option value=''></option>";
    foreach ($rows as $row) {
        if ($temp != $row['date']) {
            $temp = $row['date'];
            echo "<option value=" . $temp;
            if ($temp == $date) {
                echo " selected=selected";
            }
            echo ">" . $temp . "</option>";
        }
    }
    echo "</select></td></tr></table><br/><hr/>";
//==============================================

	//Ap 5/20/15
	echo "<form name='theForm' method='get' action='readannouncements_2.php'>";
	 echo "<table class='centered'>";
	 echo "<tr class='centered'><td class='centered'>";
	echo "Filter Announcement View By: ";
	echo "<select name='view' onchange='refresh()'>";

	// Headings to display
		$headings[0] = "All Grades";
		$headings[1] = "Freshman";
		$headings[2] = "Sophomore";
		$headings[3] = "Junior";
		$headings[4] = "Senior";
		$headings[5] = "Freshman-Sophomore";
		$headings[6] = "Junior-Senior";;

    $isView = false;
    if(isset($_GET['view'])){    //if page has been refreshed
        //echo "page reset!";
		$isView = true;
    }

    for ($i = 0; $i < count($headings); $i++) {
      echo "<option value='$i'";
      if (($isView)&& $_GET['view'] == $i) {  //if refreshed
     	  echo " selected=selected";
          $view = $i;
      }
      echo ">" . $headings[$i] . "</option>";
    }
    echo "</select> </td> </tr> </table></form>";

    $grade="null";
	 if(isset($_GET['view'])){
      $view = $_GET['view'];
	  if($view == 0){
        $grade="All Grades";
      }else if($view == 1){
        $grade=" Freshman ";
      }else if($view == 2){
        $grade=" Sophomore ";
      }else if($view == 3){
        $grade=" Junior ";
      }else if($view == 4){
        $grade=" Senior ";
      }else if($view == 5){
        $grade=" Freshman-Sophomore ";
      }else if($view == 6){
        $grade=" Junior-Senior ";
      }
	  } else {
		//echo "no";
      $grade="All Grades";//defaults to 'most recent'
    } 
	echo "<br>";
	echo "<br>";
	//echo "<br>";
//==============================================
    $query = $db->prepare("SELECT * FROM announcements WHERE date=:date ORDER BY code");
    $query->bindValue(":date", $date);
    $query->execute();

    while ($row = $query->fetch()) {
//Austin Pietrak 7-17-16 mmm
			if($grade=="All Grades"||strlen(strstr($row['grade'],$grade))>0||$row['grade']=="All Grades"||strlen(strstr($grade,$row['grade']))>0) {

        echo "<b>From: " . $row['teacher'] . "<br>";
        echo "To: " . $row['grade'] . "</b><br>";
        echo nl2br("<p> " . $row['announcement']) . "</p>";
        if (isset($_SESSION['name']) && ($_SESSION['name'] == $row['teacher'])){
            $announcement = $row['id'];
            echo "<a href=readannouncements_2.php?edit=" . $announcement . "&date=" . $date . ">Edit This Announcement </a></td>";  
            echo "<a href=readannouncements_2.php?remove=" . $row['id'] . "&date=" . $date . ">Remove This Announcement</a></td>";
        }
        echo "<hr>";
    }
	}//ap if

    if ($query->rowCount() == 0)
        echo "<h3 class='centered'>No Announcements Today.</h3>";

    $db = null;
    ?>
<table class="centered">
<?php
homeLogout();
?>
</table>
<?php 
dohtml_footer(true);
?>