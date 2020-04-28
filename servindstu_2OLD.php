<?PHP
//edited by Vincent Pillinger
session_start();
include 'functions_2.php';
teacher_only();
password_protect();

$db = get_database_connection();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $statement = $db->prepare("SELECT * FROM teacher WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    $row1 = $statement->fetch();
    if ($_SESSION['username'] == $row1['username'] && $_SESSION['password'] == $row1['password']) {
    
        $teacherid = $row1['id'];
        include 'includeInc_2.php';
        dohtml_header("View Reported Service");
        //database access working check echo $username,$teacherid;	
        ?>

                <script type='text/javascript'>
                    function refresh()
                    {
                        var formObject = document.forms['theForm'];
                        formObject.action = "servindstu_2.php";
                        formObject.submit();
                    }

                    function displayGrade() {
                        alert($GET_['grade']);
                        tBox.focus();
                    }

                    function send()
                    {
                        var formObject = document.forms['theForm'];
                        formObject.submit();
                    }

                </script>

            <table class='centered'><tr><td>
                    <form name='theForm' method='post' action='submit_2.php'>
                        <?php
                        //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
                        $date = date('Y-m-d');
                        echo "<h2>" . date('l', strtotime($date)) . "<br>" . $date . "</h2></td></tr>";
                        homeLogoutService();
						tableRowSpace();
                       
                        //Drop down for students list
                        $agid = 0;
                        $stulist = "lastname";
                        $sid = 0;

                        $stha = $db->prepare("SELECT * FROM student ORDER BY lastname,firstname");
                        $stha->execute();

                        //This should never happen
                        if ($stha->rowCount() < 1)
                            return false;

                        echo "<tr><td>Select:<select name='" . $stulist . "' onchange='refresh()'>";
                        echo "<option value=0>Select Student</option>";

                        while ($studbrow2 = $stha->fetch()) {
                            echo "<option value='" . $studbrow2['id'] . "' ";
                            if (isset($_POST[$stulist]) && $_POST[$stulist] == $studbrow2['id']) {
                                echo "selected";
                                $sid = $studbrow2['id'];
                                $lastname = $studbrow2['lastname'];
                                $firstname = $studbrow2['firstname'];
                            }
                            echo ">" . $studbrow2['lastname'] . ", " . $studbrow2['firstname'] . "</option>";
                        }
                        echo "</select>";

                        //Not sure if the next two line are necessary, I just left them in in case
                        echo "<input type=hidden value='" . $sid . "' name=stuid>";
                        echo "<input type=hidden value='" . $teacherid . "' name=teacherid>";
                        //old end of php

                        echo "<input type='submit' name='submit' value='Submit'></td></tr></table>";



                        //old start of php
//ADD A TO THE PAGE A DROP DOWN THAT LET'S YOU JUST SEE THE HOURS FOR EACH GRADE LEVEL IN ASCENDING ORDER
//WHOSE FULFILLED REQUIREMENTS
//ADD A DROP DOWN FOR REASONS WHY THEY WERE REJECTED
//DATABASE DUMP ORDERED BY GRADE: FIRST/LAST/TOTAL SERVICE HOURS
                        //Set up queries for all my table displays and set variable values
                        $i = 0;
                        $totalhours = 0;
                        if (isset($_POST['submit'])) {
                            //$verified = 1;  
                            //$agid=4; //temporary hardcoding
                            echo "<table class='centered' border=1>";
                            echo "<tr><th>Agency ID</th><th>Agency Name</th><th>Date</th><th>Notes</th><th>Hours</th></tr>";
                            //$result = mysql_query("SELECT * FROM service WHERE agency = $agid AND verified = 1 ORDER by date");
                            $sth2 = $db->prepare("SELECT * FROM service WHERE student = :sid ORDER by date");
                            //$sth2 = $db->prepare("SELECT * FROM service WHERE agency = :agency ORDER by date");
                            $sth2->bindValue(":sid", $sid);
                            //$sth2->bindValue(":verified", $verified);
                            $sth2->execute();

                            while ($servdbrow = $sth2->fetch()) {
                                //$student = mysql_query("SELECT * FROM student WHERE id = $row[student].");
                                //$sid = $servdbrow['student'];
                                $sth3 = $db->prepare("SELECT * FROM agencies WHERE id = :agid");
                                $sth3->bindValue(":agid", $servdbrow['agency']);
                                $sth3->execute();
                                $agdbrow = $sth3->fetch(); //mysql_fetch_array($student);
                                //Display the table and track total hours for the agency
                                ?>
                                <tr>
                                    <td><?php echo $agdbrow['id']; ?></td>
                                    <td><?php echo $agdbrow['name']; ?></td>
                                    <td><?php echo $servdbrow['date']; ?></td>
                                    <td width="150"><?php echo $servdbrow['notes']; ?></td>
                                    <td><?php echo $servdbrow['servicehours']; ?></td>
                                </tr>	
                <?php
                $totalhours = $totalhours + $servdbrow['servicehours'];
                $i++;
            }
            echo "<p>" . $firstname . " " . $lastname . " has volunteered " . $i . " times performing a total of " . $totalhours . " hours.";
            echo "  <br><br>Note that all of the reported service may not be verified. <br><br>Choose the 'View Verified Service' button to see the service hours reported ";
            echo "by the student which have been approved for credit toward required hours.<br><br>";
            echo "</p></table>";
        }
        ?>
                    </form>
                        <?php
                    } else {
                        redirect("login_2.php?servindstu");
                    }
                } else {
                    redirect("login_2.php?servindstu");
                }
                $db = null;
               dohtml_footer(true);
                ?>

    