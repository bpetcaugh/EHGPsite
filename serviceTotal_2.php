<?php
// Created by Eric Ghildyal '15

session_start();
include 'functions_2.php';
include 'includeInc_2.php';
dohtml_header("Service Summary");
serv_admin_only();
password_protect();
$db = get_database_connection();

//Set up heading: Date, links to HGP Home Page, EHGP, and Logout
$date = date('Y-m-d');
echo "<table class='centered'><tr><td>";
echo "<h2>" . date('l', strtotime($date)) . "<br />" . $date . "</h2></td></tr>";
homeLogout();

?>
<head>
<script type='text/javascript'>
        function refresh()
        {
            var formObject = document.forms['theForm'];
            formObject.submit();
        }
</script>
</head>

<br>

<form name='theForm' method='post' action='serviceTotal_2.php'>
  <tr> <td> Grade: <select name='grade' onchange='refresh()'>

<?php

// Headings to display
$headings[0] = ""; //blank heading displays first
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

  echo "<table class='centered' border=1>
  <tr><td>ID</td><td>Name</td><td>Total Hours</td></tr>";

foreach($students as $row){
  $classnum = $row['classnum'];
  $totalServHrs = getServiceHours($classnum);
  $name = $row['lastname'] . ", " . $row['firstname'];
  $grade = $row['grade'];

  if(!isset($totalServHrs)){
    $totalServHrs = 0; //no service hours
  }

  echo "<tr><td>" . $classnum . "</td><td>" . $name . "</td><td>" . $totalServHrs. "</td></tr>";
}

echo "</table>";
$db = null;
echo "<table class='centered'><td class='centered'>";
homeLogoutService();
echo "</td></table>";
dohtml_footer(true);
?>
