<?php
// Code by Eric Ghildyal
//TODO: After "acccept" is clicked, the form does not refresh correctly
session_start();
include 'functions_2.php'; //added _2 to update file
admin_only(); //Changed from att_admin_only() to admin_only()
password_protect("login_2.php?permitverify=1");
include 'includeInc_2.php';
dohtml_header("Permit Verify");
$db = get_database_connection();
?>
<head>
<script type='text/javascript'>
        /*function refresh()
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
    <br>

<?php       		//Set up heading: Date, links to HGP Home Page, EHGP, and Logout
    				$date = date('Y-m-d');
                    echo "<h2 align=center>" . date('l', strtotime($date)) . "<br>" . $date . "</h2>";
                    echo "<center><a href='http://www.holyghostprep.org'>Holy Ghost Prep Home Page</a></center>";
                    echo "<center>&nbsp&nbsp<a href='index_2.php'>EHGP Home</a></center>";
                    echo "<center>&nbsp&nbsp<a href='logout.php'>Logout</a></center><br><br>";
                    echo "";
                    echo "<form name='theForm' method='post' action='permitverify.php'>";//EG added
?>
    <br/>
    <table align=center>
      <tr> View By: <select name='view' onchange='refresh()'>
    <?php

    $headings[0] = "Most Recent";
    $headings[1] = "Name";
    $headings[2] = "Make";
    $headings[3] = "Model";
    $headings[4] = "Year";
    $headings[5] = "Color";
    $headings[6] = "License Plate";
    $headings[7] = "Permit Number";

    for ($i = 0; $i < count($headings); $i++) {
        echo "<option value='$i'>";
        echo $headings[$i] . "</option>";
    }
    echo "</select>  </tr> </form>";


    if(isset($view)){
      if($view == 0){
        $order = "id";
      }else if($view == 1){
        $order = "studentid";
      }else if($view == 1){
        $order = "make";
      }else if($view == 1){
        $order = "model";
      }else if($view == 1){
        $order = "year";
      }else if($view == 1){
        $order = "color";
      }else if($view == 1){
        $order = "licenseplate";
      }else if($view == 1){
        $order = "permitnumber";
      }
    }else{
      $order = "id"; //defult to sorting my most recent
    }

    //Gets all results from database, sorted accordingly
    $verify = 0; // 0 is unverified
    $pcheck = $db->prepare("SELECT * FROM parkingpermit WHERE verify=:verify ORDER by :order ASC"); //get all unverified
    $pcheck->bindvalue(":verify", $verify);
    $pcheck->bindvalue(":order", $order);
    $pcheck->execute();
    $result = $pcheck->fetchAll();

    ?>

    <br/>
    <br/>
    <td>
        <table id="permits" align=center border=1><tr><th>First Name</th><th>Last Name</th><th>Make</th><th>Model</th><th>Year</th><th>Color</th><th>Licenseplate</th><th>Permit Number</th></tr>
          <?php

              $i = 0;

              foreach ($result as $row){
                $sid = $row['studentid'];
                //$teacher = false;

                //checks to see if it is a teacher
                /*if (is_teacher_id($sid)){
                    $statement0 = $db->prepare("SELECT * FROM teacher WHERE id=:id");
                    $statement0->bindValue(":id", $sid);
                    $statement0->execute();
                    $teacher = true; */
                $statement0 = $db->prepare("SELECT * FROM student WHERE id=:id");
                $statement0->bindValue(":id", $sid);
                $statement0->execute();
                $student = $statement0->fetch();

              /* <tr>
                  <td> <?php if (!$teacher){
                      echo $student['firstname'];
                      }else{
                          echo 'Teacher'; //displays the first name as teacher if not a student
                      }?></td>
                  <td> <?php if (!$teacher){
                      echo $student['lastname'];
                      }else{
                      echo $student['name']; //displays teacher name if teacher
                      }?></td>
              */
              ?>
              <form name="theForm" method="post" action="permitverify.php">
                  <td> <?php echo $student['firstname']; ?></td>
                  <td> <?php echo $student['lastname']; ?></td>
                  <td> <?php echo $row['make']; ?></td>
                  <td> <?php echo $row['model']; ?></td>
                  <td> <?php echo $row['year']; ?></td>
                  <td> <?php echo $row['color']; ?></td>
                  <td> <?php echo $row['licenseplate']; ?></td>
                  <td> <?php echo "<input type='text' name='pnumber" . $i . "'
                                  value='" . $row['permitnumber'] . "'/>"; ?> </td>

                  <td> <?php echo " <input type='hidden' name='permitid' value='" .$row['id']. "' /> <input type='submit' name='submit' value='Accept'/>
                                  <br>"; ?> </td>
                  </tr>
              </form>
            <?php
                // $verify defaults to 0 and is only changed if the button is pressed
                $verify = 0;

                //Checks if accept button was pressed
                if (isset($_POST['submit'])){

                  //Checks if the permit number was updated
                  if (isset($_POST["pnumber" . $i]) && ($_POST["pnumber" . $i])!=NULL){ //isset() added to prevent "Notice: Undefined index"
                      $permitnumber = ($_POST["pnumber" . $i]);
                  }else{
                      $permitnumber = $row['permitnumber'];
                  }

                  // Updates verify and permitnumber at the same time
                  $id = $_POST['permitid'];
                  $sql = "UPDATE parkingpermit SET verify=:verify, permitnumber=:permitnumber WHERE id=:id";
                  $pupdate = $db->prepare($sql);
                  $pupdate->bindValue(":id", $id);
                  $pupdate->bindValue(":permitnumber", $permitnumber);
                  $pupdate->bindValue(":verify", 1);
                  $pupdate->execute();
              }
                $i++;
              }
            echo "</table>";

          echo '<FORM> <INPUT TYPE="button" onClick="history.go(0)" VALUE="Refresh"> </FORM>';
        //$_POST['submit'] = NULL;

        /*foreach ($result as $row){
            $id = $row['id'];

            //checks to see if the permitnumber was updated, if not use the old number
            if (($_POST["pnumber" . $i .""])!=NULL){
                $permitnumber = ($_POST["pnumber" . $i . ""]);
            }else{
                $permitnumber = $row['permitnumber'];
            }

            $sql = "UPDATE parkingpermit SET permitnumber=:permitnumber WHERE id=:id";
            $pupdate = $db->prepare($sql);
            $pupdate->bindValue(":permitnumber", $permitnumber);
            $pupdate->bindValue(":id", $id);
            $pupdate->execute();


            //checks to see if it was verified, if not make it unverified (keep it the same)
            if (($_POST["pverified" . $i . ""])!=NULL){
                //$verified = ($_POST["pverified" . $i . ""]);
                $verified = 1;
            }else{
                $verified = 0;
            }

            $sql2 = "UPDATE parkingpermit SET verify=:verified WHERE id=:id";
            $pupdate = $db->prepare($sql2);
            $pupdate->bindValue(":verified", $verified);
            $pupdate->bindValue(":id", $id);
            $pupdate->execute();

            $i++;
        }*/

  dohtml_footer(true);
?>
