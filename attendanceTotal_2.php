<?php
// Created by Eric Ghildyal '15

session_start();
include 'functions_2.php';
include 'includeInc_2.php';
dohtml_header("Attendance Summary");
serv_admin_only();
password_protect();

//Set up heading: Date, links to HGP Home Page, EHGP, and Logout
$date = date('Y-m-d');
echo "<table class='centered'><tr><td>";
echo "<h2>" . date('l', strtotime($date)) . "<br />" . $date . "</h2></td></tr>";
homeLogout();

?><head>
<script type='text/javascript'>
        function refresh()
        {
            var formObject = document.forms['theForm'];
            formObject.submit();
        }
</script>
</head>



<form name='theForm' method='post' action='attendanceTotal_2.php'>
  <tr> <td> Grade: <select name='grade' onchange='refresh()'>

<?php

// Headings to display
$headings[0] = "Select a Grade"; //blank heading displays first - changed to select a grade by mmm 7-30-15
$headings[1] = "Freshman";
$headings[2] = "Sophomore";
$headings[3] = "Junior";
$headings[4] = "Senior";


$isView = false;
if(isset($_POST['grade'])){    //if page has been refreshed
    $isView = true;
}

for ($i = 0; $i < count($headings); $i++) {

  echo "<option value='$i'";
  if (($isView && $_POST['grade'] == $i)) {  //if refreshed
      echo " selected=selected";
      $view = $i;
  }
  echo ">" . $headings[$i] . "</option>";
}
echo "</select> </td> </tr> </form>";

if(isset($_POST['grade'])){
  $grade = ($_POST['grade']+8);
}else{
  $grade = 0;
}
$students = getStudents($grade);

?>
<br>

<table class='centered' border=1><tr><td>ID</td><td>Name</td><td>Total Absences</td></tr>

<?php
$db1 = get_database_connection();

foreach($students as $row){
  $classNum = $row['id'];

  $absences = $db1->prepare("SELECT * FROM absentee WHERE classnum=:classnum ORDER BY name DESC");
  $absences->bindValue(":classnum", $classNum);
  $absences->execute();

  $countAbs = 0.0;
  while($date = $absences->fetch()){
    if(strpos($date['notes'],".5") === false){ //if .5 is in 'notes' in the databse
      $countAbs = $countAbs + 1.0; // .5 not found
    }else{
      $countAbs = $countAbs + 0.5;
    }
  }

  echo "<tr><td> ". $classNum ." </td> <td> ". getFullName($classNum) ." </td> <td> ". $countAbs ." </td></tr>";

}



echo "</table>";
$db = null;
echo "<table class='centered'><td class='centered'>";
homeLogoutAdminTools();
echo "</td></table>";
dohtml_footer(true);
?>
