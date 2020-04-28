<?PHP
include 'functions.php';
password_protect();

$db = get_database_connection();

if ($_SESSION['username']) {
    $username = $_SESSION['username'];
    $result = mysql_query("SELECT * FROM teacher WHERE username='$username'");
    $row = mysql_fetch_array($result);
    if ($_SESSION['username'] == $row['username'] && $_SESSION['password'] == $row['password']) {
        $teacherid = $row['id'];
?>

        <script type='text/javascript'>
            function refresh()
            {
                var formObject = document.forms['theForm'];
                formObject.action="ServiceVerify.php";
                formObject.submit();
            }
        </script>

         <html>
            <link rel ="stylesheet" type ="text/css" href ="table.css" />
                <br>
                <table align=center><td>
                        
                        <form name='theForm' method='post' action='ServiceVerify.php'>
                

           
            <?php
            //Set up header: date, home page link, EHGP home page, Logout
            $button = boldbuttons;
            $pixels = 200;
            print_header("Service Verify", $pixels, $button);
            echo "";


if ($_POST['submit']) {
            $i = 0;
            $result = mysql_query("SELECT * FROM service WHERE verified = 0 ORDER by student");
                while ($row = mysql_fetch_array($result)) {
                   $i++;

                    if ($_POST["role$i"]) {
                      mysql_query("UPDATE service SET role = '" . ($_POST["role$i"]) . "' WHERE id = '" . $row['id'] . "'");
                         }

                   mysql_query("UPDATE service SET servicehours  = '" . ($_POST["hours$i"]) . "' WHERE id = '" . $row['id'] . "'");
              
                   mysql_query("UPDATE service SET agency  = '" . ${$agid . $i} . "' WHERE id = '" . $row['id'] . "'");                        
                        


                   if ($_POST["verifiedValue$i"]) {
                      mysql_query("UPDATE service SET verified = '" . ($_POST["verifiedValue$i"]) . "' WHERE id = '" . $row['id'] . "'");
        }
    }
}





             //Set up query, only display unverified ones
            $result = mysql_query("SELECT * FROM service WHERE verified = 0 ORDER by student");
            //if ($row = mysql_fetch_array($result)) {
                


            echo "<center>For this page, do not use the refresh button, it will result in incorrect submissions.</center>";

                //Table header
            ?>

                <table id ="customers" align=center border=1><tr><th>First Name</th><th>Last Name</th><th>Grade</th><th>Date</th><th>Agency</th><th>Hours</th><th>Notes</th><th>Role</th><th>Verified</th></tr>
                <?php
                //Set up more queries for table displays
                $i = 0;

                while ($row = mysql_fetch_array($result)) {
                    $student = mysql_query("SELECT * FROM student WHERE id = $row[student]. ");
                    $row2 = mysql_fetch_array($student);
                    $agency = mysql_query("SELECT * FROM agencies WHERE id = $row[agency]. ");
                    $row3 = mysql_fetch_array($agency);
                    $i++;
                //Display table results
                    
                        echo "<tr class=alt>";
                            ?>
                        <td><?php echo $row2['firstname']; ?></td>
                        <td><?php echo $row2['lastname']; ?></td>
                        <td><?php echo $row2['grade']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo //$row3['name']

                    $agid = 0;
                    $agency = "agency";
                    $result5 = mysql_query("SELECT * FROM agencies");
                    echo "<select name='agency" . $i . "' onchange='refresh()'>";
                    echo "<option value= '" . $row3['name'] . "' >" . $row3['name'] . "</option>";

                    while ($row5 = mysql_fetch_array($result5)) {
                        echo "<option value='" . $row5['name'] . "' ";
                        if ($_POST['agency'] == $row5['name']) {
                          echo "selected";
                            $agid= $row5['id'];
                            ${$agid . $i} = $row5['id']; // sets $sss5

                            $agencyupdate = "agid";
                        }
                        echo ">" . $row5['name'] . "</option>";
                    }
                    echo "</select>";

                    //Not sure if the next two line are necessary, I just left them in in case
                    echo "<input type=hidden value='" . $agid . "' name=agid>";

                    echo "<input type=hidden value='" . $teacherid . "' name=teacherid>";
                        ?></td>
                        <td><?php $hours = "hours$i";
                        echo "<input type=text name='". $hours ."' value='" . $row['servicehours'] . "'><br><br>";
                        //NEED TO FIX IT SO THAT THE VALUE UPDATED INTO THE DATABASE IS THE PREVIOUS VALUE IF IT REMAINS UNTOUCHED!!!!
                        ?></td>

                        <td><?php echo $row['notes']; ?></td>
                        <td>
                    <?php
                    //Radio Box for Role in service, set them equal to either L, I or B
                    //Figured out double quotes would make the variable appear and I was doing INSERT instead of UPDATE for my queries
                    echo "<input type='radio' value = 'L' name='role" . $i . "' > Leadership"; ?><br><?php echo "<input type='radio' value = 'I' name='role" . $i . "' > Initiative"; ?><br><?php echo "<input type='radio' value = 'B' name='role" . $i . "' > Both"; ?><br><?php

                    ?>
                </td>
                <td>
                    <?php
                    //Radio Box for Verification INSERT 1 for verified and 2 for not verified so that each request won't keep appearing even though its already been denied
                    echo "<input type='radio' value = '1' name='verifiedValue" . $i . "' > Verified"; ?><br><?php echo "<input type='radio' value = '2' name='verifiedValue" . $i . "' > Rejected"; ?><br><?php
  
                    ?>
                </td>
                    <?php
                                echo "</tr>";

                }
                ?>
                </table>
                <?php

                echo "</table>";
                echo"";
            
            //}
                    ?>




            <center><input type='submit' name='submit' value='Submit'><br><br></center>

        </form>

    </table>


</body>
<?php
        } else {
            echo "<script language=\"JavaScript\">";
            echo "window.location = 'login.php?ServiceVerify.php' ";
            echo "</script>";
        }
    } else {
        echo "<script language=\"JavaScript\">";
        echo "window.location = 'login.php?ServiceVerify.php' ";
        echo "</script>";
    }
?>