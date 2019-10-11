<?PHP
//edited by Vincent Pillinger
session_start();
include 'functions_2.php';
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
        dohtml_header("View Agency Activity");
        //database access working check echo $username,$teacherid;	
        ?>
        
                <script type='text/javascript'>
                    function refresh()
                    {
                        var formObject = document.forms['theForm'];
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
                
           
           
         
            <table class=centered><tr><td>
                    <form name='theForm' method='post' action='serviceAgencies_2.php'>
                        <?php
                        //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
                        $date = date('Y-m-d');
                        echo "<h2>" . date('l', strtotime($date)) . "<br>" . $date . "</h2></td></tr>";
                        homeLogoutService();
						tableRowSpace();
						
                        //Drop down for agencies list
                        $agid = 0;
                        $agency = "agency";

                        $stha = $db->prepare("SELECT * FROM agencies ORDER BY name");
                        $stha->execute();

                        //This should never happen
                        if ($stha->rowCount() < 1)
                            return false;

                        echo "<tr><td>Select:<select name='" . $agency . "' onchange='refresh()'>";
                        echo "<option value=0>Select Agency</option>";

                        while ($agdbrow = $stha->fetch()) { ///modified 5-23-15 by mmm -- agencies and slashes
							$agencyName = stripslashes($agdbrow['name']);
                            echo "<option value='" . $agencyName . "' ";
							//echo "Agency posted" . $_POST[$agency];
							//$agencySelected = $_POST[$agency];
							//$agencySelected = addslashes($agencySelected);
                            if (isset($_POST[$agency]) && $_POST[$agency] == $agencyName) { // $agencySelected  $agdbrow['name']
                                echo "selected";
                                $agid = $agdbrow['id'];
                            }
                            echo ">" . stripslashes($agencyName) . "</option>";
                        }
                        echo "</select></td></tr></table>";

                        //Not sure if the next two line are necessary, I just left them in in case
                        echo "<input type=hidden value='" . $agid . "' name=agid>";
                        echo "<input type=hidden value='" . $teacherid . "' name=teacherid>";
                        //old end of php
                        //echo "<input type='submit' name='submit' value='Submit'><br><br>";
                        //old start of php
//ADD A TO THE PAGE A DROP DOWN THAT LET'S YOU JUST SEE THE HOURS FOR EACH GRADE LEVEL IN ASCENDING ORDER
//WHOSE FULFILLED REQUIREMENTS
//ADD A DROP DOWN FOR REASONS WHY THEY WERE REJECTED
//DATABASE DUMP ORDERED BY GRADE: FIRST/LAST/TOTAL SERVICE HOURS
                        //Set up queries for all my table displays and set variable values
                        $i = 0;
                        $totalhours = 0;
                        if (!isset($_POST['submit'])) {
                            $verified = 1;
                            //$agid=4; //temporary hardcoding
                            echo "<table class='centered' border=1>";
                            echo "<tr><th>First Name</th><th>Last Name</th><th>Grade</th><th>Date</th><th>Hours</th></tr>";
                            //$result = mysql_query("SELECT * FROM service WHERE agency = $agid AND verified = 1 ORDER by date");
                            $sth2 = $db->prepare("SELECT * FROM service WHERE agency = :agency AND verified = :verified ORDER by date");
                            //$sth2 = $db->prepare("SELECT * FROM service WHERE agency = :agency ORDER by date");
                            $sth2->bindValue(":agency", $agid);
                            $sth2->bindValue(":verified", $verified);
                            $sth2->execute();

                            while ($servdbrow = $sth2->fetch()) {
                                //$student = mysql_query("SELECT * FROM student WHERE id = $row[student].");
                                $sid = $servdbrow['student'];
                                $sth3 = $db->prepare("SELECT * FROM student WHERE id = :sid");
                                $sth3->bindValue(":sid", $sid);
                                $sth3->execute();
                                $studbrow = $sth3->fetch(); //mysql_fetch_array($student);
                                //Display the table and track total hours for the agency
                                ?>
                                <tr>
                                    <td><?php echo $studbrow['firstname']; ?></td>
                                    <td><?php echo $studbrow['lastname']; ?></td>
                                    <td><?php echo $studbrow['grade']; ?></td>
                                    <td><?php echo $servdbrow['date']; ?></td>
                                    <td><?php echo $servdbrow['servicehours']; ?></td>
                                </tr>	
                                <?php
                                $totalhours = $totalhours + $servdbrow['servicehours'];
                                $i++;
                            }
                            echo "<tr><h3 class='centered'><br />Students have volunteered " . $i . " times performing a total of " . $totalhours . " hours.<br><br></h3>";
                            echo "</tr></table>";//above header not in td so it appears at top of table
                        }
                        ?>
                    </form>
                    <?php
                } else {
                    redirect("");
                    //echo "<script language=\"JavaScript\">";
                    //echo "window.location = 'login_2.php?ServiceAgencies' ";
                    //echo "/script><";
                }
            } else {
                redirect("");
                //echo "<script language=\"JavaScript\">";
                //echo "window.location = 'login_2.php?ServiceAgencies' ";
                //echo "/script><";
            }
                $db= null;
                dohtml_footer(true);
            ?>

    

