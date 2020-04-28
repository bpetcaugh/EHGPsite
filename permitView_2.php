<?php
// Code by Eric Ghildyal
session_start();
include 'functions_2.php';
admin_only();
password_protect();
include 'includeInc_2.php';
dohtml_header("View Permits");
$db = get_database_connection();
?>
<head>
<script type='text/javascript'>
        /*function refresh() // This code may or may not work...
        {
            var formObject = document.forms['theForm'];
            formObject.action="permitverify.php";
            formObject.submit();
        } */

        function refresh()
        {
            var formObject = document.forms['theForm'];
            formObject.submit();
        }

        function send()
        {
            var formObject = document.forms['theForm'];
            formObject.submit();
        }

      </script>
</head>
<body>

<?php
        //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
        $date = date('Y-m-d');
        echo "<table class='centered'><tr><td>";
        echo "<h2>" . date('l', strtotime($date)) . "<br />" . $date . "</h2></td></tr>";
        homeLogout();
?>

    <form name='theForm' method='post' action='permitView_2.php'>
      <tr> <td> View By: <select name='view' onchange='refresh()'>
    <?php

    // Headings to display
    $headings[0] = "Most Recent";
    $headings[1] = "Name";
    $headings[2] = "Make";
    $headings[3] = "Model";
    $headings[4] = "Year";
    $headings[5] = "Color";
    $headings[6] = "License Plate";
    $headings[7] = "Permit Number";
    $headings[8] = "Verified";

    $isView = false;
    if(isset($_POST['view'])){    //if page has been refreshed
        $isView = true;
    }

    for ($i = 0; $i < count($headings); $i++) {

      echo "<option value='$i'";
      if (($isView && $_POST['view'] == $i)) {  //if refreshed
          echo " selected=selected";
          $view = $i;
      }
      echo ">" . $headings[$i] . "</option>";
    }
    echo "</select> </td> </tr> </form>";

    $order = " ORDER BY ";

    if(isset($_POST['view'])){
      $view = $_POST['view'];
      if($view == 0){
        $order = $order . "id DESC"; // sorted descending so the newest appears at the top
      }else if($view == 1){
        $order = $order . "studentid";
      }else if($view == 2){
        $order = $order . "make";
      }else if($view == 3){
        $order = $order . "model";
      }else if($view == 4){
        $order = $order . "year";
      }else if($view == 5){
        $order = $order . "color";
      }else if($view == 6){
        $order = $order . "licenseplate";
      }else if($view == 7){
        $order = $order . "permitnumber";
      }else if($view == 8){
        $order = $order . "verify";
      }
    } else {
      $order = $order . "id DESC"; //defaults to 'most recent'
    }

    //Gets all results from database, ordered accordingly
    $statementBegining = "SELECT * FROM parkingpermit";
    $pcheck = $db->prepare($statementBegining . $order); // This must be two variables, not a string concatenated with a variable
    $pcheck->execute();
    $result = $pcheck->fetchAll();

    ?>

    <br/>
    <br/>
    <td>
        <table id="permits" align=center border=1><tr><th>First Name</th><th>Last Name</th><th>Make</th><th>Model</th><th>Year</th><th>Color</th><th>Licenseplate</th><th>Permit Number</th><th>Verified</th></tr>
          <?php

              $i = 0;

              foreach ($result as $row){
                $sid = $row['studentid'];
                $statement0 = $db->prepare("SELECT * FROM student WHERE id=:id");
                $statement0->bindValue(":id", $sid);
                $statement0->execute();
                $student = $statement0->fetch();


              ?>

                  <td> <?php echo $student['firstname']; ?></td>
                  <td> <?php echo $student['lastname']; ?></td>
                  <td> <?php echo $row['make']; ?></td>
                  <td> <?php echo $row['model']; ?></td>
                  <td> <?php echo $row['year']; ?></td>
                  <td> <?php echo $row['color']; ?></td>
                  <td> <?php echo $row['licenseplate']; ?></td>
                  <td> <?php echo $row['permitnumber'];?> </td>
                  <td> <?php echo ($row['verify'] == '1') ? "Yes" : "No"; // Displays 'yes' or 'no' instead of '0' or '1'?> </td>
                  </tr>

            <?php
              $i++;
              }
            echo "</table>";

  dohtml_footer(true);
?>
