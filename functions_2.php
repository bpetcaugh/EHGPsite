<?php

//Use sessions instead of cookies
//session_start();
//set a global variable for use with service programs
//FIX THIS LATER
$thisgradyear = get_Grad_Year();

/**
 * 
 * Returns a PDO object that represents the database connection
 * 
 * */
 
 function get_Grad_Year() {
	$year = date("y");
	$month = date("m");
	if($month > 07){
		$gradYear = ($year + 1) * 1000;	
	}else{
		$gradYear = $year * 1000;	
	}
	return $gradYear; 
 }
 
function get_database_connection() {
    //Connect to the Database
    $host = "localhost";
    $dbname = "ehgp_data";
    $user = "ehgp_user";
    $pass = "ehgp_password";

    return new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
}

/** 
 *
 * Returns the base url of the website
 */
function base_url() {
    return "https://ehgp.holyghostprep.org/";
}

/**
 * 
 * Returns the full url path for the file
 * @param String $file the file or file path from the sever's root (example/ex.php)
 */
function get_link($file) {
    return base_url() . $file;
}

/**
 * 
 * Redirects the user to the specific file. Note: this can only be done if nothing is echoed out
 * @param String $file the file or file path from the sever's root (example/ex.php)
 */
function redirect($file) {
    header("Location: " . get_link($file));
}

/**
 *
 * Logs in by adding the username and password sessions.
 * @param String $username the username
 * @param String $password the md5 hashed password
 */
function login($username, $password) {
    if (valid_login($username, $password)) {
        if (valid_teacher_login($username, $password)) {
            $_SESSION['username'] = $username;     //add a timeout here sorta?
            $_SESSION['password'] = $password;
            $_SESSION['id'] = get_teacher_id($username);
            $_SESSION['name'] = get_teacher_name($username);
            $_SESSION['isTeacher'] = true;
            return TRUE;
        }
        $_SESSION['username'] = $username;     //add a timeout here sorta?
        $_SESSION['password'] = $password;
        $_SESSION['id'] = get_student_id($username);
        $_SESSION['name'] = get_student_name($username);
        $_SESSION['grade'] = get_student_grade($username);
        $_SESSION['isTeacher'] = false;
        return TRUE;
    }
    return FALSE;
}

/**
 *
 * Checks whether the given username and md5-hashed password are valid to log in.
 * Note that if there are multiple users that match the criteria (which should not happen) this
 * function will return false
 * @param String $username the username of the user
 * @param String $password the md5 hashed password
 */
function valid_login($username, $password) {
    return (valid_teacher_login($username, $password) || valid_student_login($username, $password));
//    if (!isset($username) && !isset($password))
//        return FALSE;
//    
//    $db = get_database_connection();
//    $statement = $db->prepare("SELECT * FROM teacher WHERE username=:username AND password=:password");
//    $statement->bindValue(":username", $username);
//    $statement->bindValue(":password", $password);
//    $statement->execute();
//    
//    return ($statement->rowCount() == 1);
}

/**
 *
 * Checks whether the given username and md5-hashed password are valid to log in for a teacher.
 * Note that if there are multiple users that match the criteria (which should not happen) this
 * function will return false
 * @param String $username the username of the user
 * @param String $password the md5 hashed password
 */
function valid_teacher_login($username, $password) {
    if (!isset($username) && !isset($password))
        return FALSE;

    $db = get_database_connection();
    $statement = $db->prepare("SELECT * FROM teacher WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    return ($statement->rowCount() == 1);
}

/**
 *
 * Checks whether the given username and md5-hashed password are valid to log in for a student.
 * Note that if there are multiple users that match the criteria (which should not happen) this
 * function will return false
 * @param String $username the username of the user
 * @param String $password the md5 hashed password
 */
function valid_student_login($username, $password) {
    if (!isset($username) && !isset($password))
        return FALSE;
    //temporary for testing of student login modifications to login function
    //return FALSE;

    $db = get_database_connection();
    $statement = $db->prepare("SELECT * FROM student WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    return ($statement->rowCount() == 1);
}

//replaced by two functions below it to specify teacher or student database
function get_id($username) {
    $db = get_database_connection();
    $statement = $db->prepare("SELECT id FROM teacher WHERE username=:username");
    $statement->bindValue(":username", $username);
    $statement->execute();

    return $statement->fetchObject()->id;
}

function get_teacher_id($username) {
    $db = get_database_connection();
    $statement = $db->prepare("SELECT id FROM teacher WHERE username=:username");
    $statement->bindValue(":username", $username);
    $statement->execute();

    return $statement->fetchObject()->id;
}

function get_student_id($username) {
    $db = get_database_connection();
    $statement = $db->prepare("SELECT id FROM student WHERE username=:username");
    $statement->bindValue(":username", $username);
    $statement->execute();

    return $statement->fetchObject()->id;
}

//replaced by two functions below it to specify teacher or student database
function get_name($username) {
    $db = get_database_connection();
    $statement = $db->prepare("SELECT name FROM teacher WHERE username=:username");
    $statement->bindValue(":username", $username);
    $statement->execute();

    return $statement->fetchObject()->name;
}

function get_teacher_name($username) {
    $db = get_database_connection();
    $statement = $db->prepare("SELECT name FROM teacher WHERE username=:username");
    $statement->bindValue(":username", $username);
    $statement->execute();

    return $statement->fetchObject()->name;
}

function get_student_name($username) {
    $db = get_database_connection();
    $statement = $db->prepare("SELECT firstname FROM student WHERE username=:username");
    $statement->bindValue(":username", $username);
    $statement->execute();

    return $statement->fetchObject()->firstname;
}

function get_student_grade($username) {
    $db = get_database_connection();
    $statement = $db->prepare("SELECT grade FROM student WHERE username=:username");
    $statement->bindValue(":username", $username);
    $statement->execute();

    return $statement->fetchObject()->grade;
}

/**
 * Checks to see if the user is logged in. If not it redirects them to the param page or login.php by defaut.
 * @param String $page the page that the user should be redirected to
 */
function password_protect($page = "login_2.php") {
    if (!check_logged_in()) {
        header("Location: " . base_url() . $page);
        exit;
    }
}

/**
 * Checks to see if the user is logged in.
 * @return Boolean True if the user is logged in. False otherwise.
 */
function check_logged_in() {
    if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
        return valid_login($_SESSION['username'], $_SESSION['password']);
    }
    return false;
}

/**
 * Checks to see if the user is an admin
 * @param String $username the username of the user
 * @param String $password the password of the user
 * @return Boolean true if the user is an admin. False otherwise.
 */
function is_admin($username, $password) {
    $db = get_database_connection();
    $statement = $db->prepare("SELECT * FROM teacher WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    //This should never happen
    if ($statement->rowCount() != 1)
        return false;

    $row = $statement->fetch();

    return ($row['isadmin'] > 0);
}

/**
 * Checks to see if the user is a super admin
 * @param String $username the username of the user
 * @param String $password the password of the user
 * @return Boolean true if the user is a super admin. False otherwise.
 */
function is_super_admin($username, $password) {
    $db = get_database_connection();
    $statement = $db->prepare("SELECT * FROM teacher WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    //This should never happen
    if ($statement->rowCount() != 1)
        return false;

    $row = $statement->fetch();

    return ($row['isadmin'] == 1);
}

/**
 * Checks to see if the user is an attendance admin
 * @param String $username the username of the user
 * @param String $password the password of the user
 * @return Boolean true if the user is an attendance admin. False otherwise.
 */
function is_att_admin($username, $password) {
    $db = get_database_connection();
    $statement = $db->prepare("SELECT * FROM teacher WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    //This should never happen
    if ($statement->rowCount() != 1)
        return false;

    $row = $statement->fetch();

    return (($row['isadmin'] == 2) || ($row['isadmin'] == 1));
}
function is_req_admin($username, $password) {
    $db = get_database_connection();
    $statement = $db->prepare("SELECT * FROM teacher WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    //This should never happen
    if ($statement->rowCount() != 1)
        return false;

    $row = $statement->fetch();
    
    if (($row['isadmin'] == 4) || ($row['isadmin'] == 1))
        return true;
    
    return false;
}

/**
 * Checks to see if the user is a service admin
 * @param String $username the username of the user
 * @param String $password the password of the user
 * @return Boolean true if the user is a service admin. False otherwise.
 */
function is_serv_admin($username, $password) {
    $db = get_database_connection();
    $statement = $db->prepare("SELECT * FROM teacher WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    //This should never happen
    if ($statement->rowCount() != 1)
        return false;

    $row = $statement->fetch();

    return (($row['isadmin'] == 3) || ($row['isadmin'] == 1));
}

/**
 * Checks to see if the user is a teacher
 * @param String $username the username of the user
 * @param String $password the password of the user
 * @return Boolean true if the user is a teacher. False otherwise.
 */
function is_teacher($username, $password) {
    $db = get_database_connection();
    $statement = $db->prepare("SELECT * FROM teacher WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    //This should never happen
    if ($statement->rowCount() != 1)
        return false;
    if ($statement->rowCount() == 1)
        return true;

    return false; //default for security
}

/**
 *
 * Only allows an admin to access the page. Include this at the top of the page
 */
function admin_only() {
    if (isset($_SESSION['username']) && isset($_SESSION['password']) && !is_admin($_SESSION['username'], $_SESSION['password'])) {
        die("You do not have access to this page!");
    }
}

/**
 *
 * Only allows a super admin to access a page section
 */
function super_admin_only() {
    if (isset($_SESSION['username']) && isset($_SESSION['password']) && !is_super_admin($_SESSION['username'], $_SESSION['password'])) {
        die("You do not have access to this page!");
    }
    return true;
}

/**
 *
 * Only allows an attendance admin to access a page section
 */
function att_admin_only() {
    if (isset($_SESSION['username']) && isset($_SESSION['password']) && !is_att_admin($_SESSION['username'], $_SESSION['password'])) {
        die("You do not have access to this page!");
    }
    return true;
}

/**
 *
 * Only allows a server admin to access a page section
 */
function serv_admin_only() {
    if (isset($_SESSION['username']) && isset($_SESSION['password']) && !is_serv_admin($_SESSION['username'], $_SESSION['password'])) {
        die("You do not have access to this page!");
    }
    return true;
}

/**
 *
 * Only allows a teacher to access the page. Include this at the top of the page
 */
function teacher_only() {
    if (!(isset($_SESSION['username']) && isset($_SESSION['password'])) ||
            (!is_teacher($_SESSION['username'], $_SESSION['password']))) {
        die("You do not have access to this page!");
    }
}

//Returns the current grade of a student with the given graduation year.
function get_grade($gradyear) {
    global $thisgradyear;
    $grade = $thisgradyear + 12 - $gradyear;
    if ($grade > 12)
        $grade = 13;
    return $grade;
}

function getService() {
    $db = get_database_connection();
    $servdb = $db->prepare("SELECT * FROM service ORDER BY student, verified, date");
    $servdb->execute();
    //This should never happen
    if ($servdb->rowCount() < 0) {//changed from <1 7-30-15 mmm
        echo "ERROR IN DATABASE SELECT";
        return false;
    }
    return $servdb->fetchAll();
}

function getStudents($gr) {
    $db = get_database_connection();
    $studb = $db->prepare("SELECT * FROM student WHERE grade=:gr ORDER BY grade, lastname, firstname ASC");
    $studb->bindValue(":gr", $gr);
    $studb->execute();
    //This should never happen
    if ($studb->rowCount() < 0) {//changed from <1 7-30-15 mmm
        echo "ERROR IN DATABASE SELECT";
        return false;
    }
    return $studb->fetchAll();
}

function getServiceHours($cn2) {
    $db = get_database_connection();
    $servdb2 = $db->prepare("SELECT sum(servicehours)AS totalHours FROM service WHERE student=:cn AND verified='1'");
    $servdb2->bindValue(":cn", $cn2); // GROUP BY :cn
    $servdb2->execute();
    //This should never happen
    if ($servdb2->rowCount() < 1) {
        return 0;
    }
    $tshrow = $servdb2->fetch();
    return $tshrow['totalHours'];
}

//Buttons Headers
function print_header($titleName, $pixels, $button) {
    echo "<center><h1>" . $titleName . "</h1></center>";
    $date = date('Y-m-d');
    echo "<h2 align=center>" . date('l', strtotime($date)) . "<br>" . $date . "</h2>";
    echo "<table border=0 align=center>
		<tr><td align=center width='" . $pixels . "'px>
		<a class=boldbuttons href=http://www.holyghostprep.org>
		<span>Holy Ghost Prep Home Page</span></a></td></tr>";
    echo "<tr><td align=center width='" . $pixels . "'px>
		<a class='" . $button . "' href=index.php><span>EHGP Home</span></a></td></tr>";
    echo "<tr><td align=center width='" . $pixels . "'px>
		<a class='" . $button . "' href=logout.php><span>Logout</span></a></td></tr>";
    echo "</table>";
}

//Takes a student id and returns the students full name
function getFullName($studentid) {
    $db = get_database_connection();
    $query = $db->prepare("SELECT firstname,lastname FROM student WHERE id = :id");
    $query -> bindValue(":id", $studentid);
    $query -> execute();
    $row = $query ->fetch();
    $fullname = $row['lastname'] . ", " . $row['firstname'] ;
    return $fullname;
}

function ticketsDisplay($statement, $username, $password, $viewers, $views){        //added by CK 3/10/14
    $db = get_database_connection(); 
    while ($tickets = $statement->fetch()) {      //while there are still support tickets, Display the table
            $probID = $tickets['id'];
            $probNum = $tickets['problem'];
            $sth = $db->prepare("SELECT * FROM problems WHERE id = :id");
            $sth->bindValue(":id", $probNum);
            $sth->execute();
            $problem = $sth->fetch();       //the list of problems in the database to compare to the ticket

            $sth2 = $db->prepare("SELECT * FROM teacher WHERE id = :id");
            $sth2->bindValue(":id", $tickets['teacher']);
            $sth2->execute();
            $teachers = $sth2->fetch();
            $teacher = $teachers['name'];               //display name of teacher's ticket
            if ($_SESSION['name'] == $teacher) {
                $teacher = "Me";
            }

            $urgency = $tickets['urgency'];         //urgency level of the ticket
            if ($urgency == 1) {
                $urgLevel = "High";
            } else if ($urgency == 2) {
                $urgLevel = "Medium";
            } else {
                $urgLevel = "Low";
            }

            $statusLevel = $tickets['status'];              //status level of the ticket
            $statuses[0] = "Pending";
            $statuses[1] = "In Progress MJ";
			$statuses[2] = "In Progress DJ";
            $statuses[3] = "Completed";
            $status = $statuses[$statusLevel];              //display name of status
           
            if($statusLevel != 3){                  //if status is not completed, find it's ticket no.
                $ticks = $db->prepare("SELECT * FROM support ORDER BY id ASC");
                $ticks->execute();
                $tickNum = 1;
                while(($ticket = $ticks->fetch()) && ($ticket['id'] != $probID)){       //while it is still checking and the current ticket is not up, add to tickno. counter
                    if($ticket['status']!=3){
                       $tickNum++;
                    }   
                }
            }else{ $tickNum = "--"; }           //already completed, no ticket number
            
            ?><tr>
                <td><?php echo $tickNum; ?></td>
                <td><?php echo $teacher; ?></td>
                <td><?php echo $problem['name']; ?></td>
                <td><?php echo $tickets['notes']; ?></td>
                <td><?php echo $urgLevel; ?></td>
                <td><?php echo $tickets['date']; ?></td>
                <td><?php
            if (is_super_admin($username, $password)) {             //ability to edit status level if admin
                echo "<form action=viewtickets.php method='post'>";
                echo "<select name='statusChange'>";
                for($i = 0; $i <4; $i++){           //pending, in progress, completed
                    echo "<option value='$i'";
                    if ($i == $statusLevel)  {      //select the ticket's current status level
                        echo " selected=selected";
                    }
                    echo ">" . $statuses[$i] . "</option>";                   
                }
                echo "</select><br>";
                echo "<input type='hidden' name='probID' value='" . $probID ."'>";         //hidden inputs for
                echo "<input type='hidden' name='viewers' value='" . $viewers."'>";        //the viewtickets page
                echo "<input type='hidden' name='views' value='" . $views."'>";            //to have the correct
                echo "<textarea rows='3' cols='30' name='comm' id='comm'>" . $tickets['comments'] . "</textarea>";
				echo "<input type='submit' name='statEdit' value='Submit'>";            //selections when page is refreshed
				echo "</form>";
            } else {
                echo $status;       //if not admin, just display ticket status level
           }            
            ?></td>
            </tr>
            <?php
        }
}
function requestsDisplay($statement, $username, $password, $viewers, $views){        //added by CK 3/10/14
    $db = get_database_connection(); 
    while ($tickets = $statement->fetch()) {      //while there are still support tickets, Display the table
            $probID = $tickets['id'];
            $probNum = $tickets['request'];
            $sth = $db->prepare("SELECT * FROM requests WHERE id = :id");
            $sth->bindValue(":id", $probNum);
            $sth->execute();
            $problem = $sth->fetch();       //the list of problems in the database to compare to the ticket

            $sth2 = $db->prepare("SELECT * FROM teacher WHERE id = :id");
            $sth2->bindValue(":id", $tickets['teacher']);
            $sth2->execute();
            $teachers = $sth2->fetch();
            $teacher = $teachers['name'];               //display name of teacher's ticket
            if ($_SESSION['name'] == $teacher) {
                $teacher = "Me";
            }

            $urgency = $tickets['urgency'];         //urgency level of the ticket
            if ($urgency == 1) {
                $urgLevel = "High";
            } else if ($urgency == 2) {
                $urgLevel = "Medium";
            } else {
                $urgLevel = "Low";
            }

            $statusLevel = $tickets['status'];              //status level of the ticket
            $statuses[0] = "Pending";
            $statuses[1] = "In Progress";
            $statuses[2] = "Completed";
            $status = $statuses[$statusLevel];              //display name of status
           
            if($statusLevel != 2){                  //if status is not completed, find it's ticket no.
                $ticks = $db->prepare("SELECT * FROM mainrequest ORDER BY id");
                $ticks->execute();
                $tickNum = 1;
                while(($ticket = $ticks->fetch()) && ($ticket['id'] != $probID)){       //while it is still checking and the current ticket is not up, add to tickno. counter
                    if($ticket['status']!=2){
                       $tickNum++;
                    }   
                }
            }else{ $tickNum = "--"; }           //already completed, no ticket number
            
            ?><tr>
                <td><?php echo $tickNum; ?></td>
                <td><?php echo $teacher; ?></td>
                <td><?php echo $problem['name']; ?></td>
                <td><?php echo $tickets['notes']; ?></td>
                <td><?php echo $urgLevel; ?></td>
                <td><?php echo $tickets['date']; ?></td>
                <td><?php
            if (is_req_admin($username, $password)) {             //ability to edit status level if admin
                echo "<form action=viewmaintenance.php method='post'>";
                echo "<select name='statusChange'>";
                for($i = 0; $i <3; $i++){           //pending, in progress, completed
                    echo "<option value='$i'";
                    if ($i == $statusLevel)  {      //select the ticket's current status level
                        echo " selected=selected";
                    }
                    echo ">" . $statuses[$i] . "</option>";                   
                }
                echo "</select>";
                echo "<input type='hidden' name='probID' value='" . $probID ."'>";         //hidden inputs for
                echo "<input type='hidden' name='viewers' value='" . $viewers."'>";        //the viewtickets page
                echo "<input type='hidden' name='views' value='" . $views."'>";            //to have the correct
                echo "<input type='submit' name='statEdit' value='Submit'>";            //selections when page is refreshed
                echo "</form>";
            } else {
                echo $status;       //if not admin, just display ticket status level
           }            
            ?></td>
            </tr>
            <?php
        }
}
function isMobile(){			//added by CK 3/2014 for the mobile EHGP site
    $useragent=$_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
        return true;
    return false;
    
}
?>