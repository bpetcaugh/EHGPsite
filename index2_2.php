<?php
session_start();
include 'functions_2.php';
$db = get_database_connection();

$doneButtons = false;
$title="EHGP";
include 'includeInc_2.php';
dohtml_header("EHGP");

               
if (check_logged_in()) {
    $isTeacher = $_SESSION['isTeacher'];
    echo "<tr class'centered'><td></td><td><h3 class='centered'>Welcome " . $_SESSION['name'] . "</h3></td><td></td></tr>";
    ?>
    <table class="centered">
        <?php
        if ($isTeacher) {
            ?>  
            <tr class="centeredButton">
                <td colspan="2"><a class="glossy-button blue" href=chgpass_2.php>Change Password</a></td>
            </tr>
            <tr class="twoCenteredButtons">
                <td ><a class='glossy-button blue' href='login_2.php?announcement=1'><span>Add Announcement</span></a></td>
                <td ><a class="glossy-button blue" href="readannouncements_2.php"><span>Read Announcements</span></a></td>
            </tr>
            <tr class="twoCenteredButtons">
                <td ><a class="glossy-button blue" href="login_2.php?absentee=1"><span>Add Absentee</span></a></td>
                <td ><a class="glossy-button blue" href="viewabsentee_2.php"><span>View Absentees</span></a></td>
            </tr>
            <tr class="twoCenteredButtons">
                <td ><a class="glossy-button blue" href="login_2.php?late=1"><span>Add Late</span></a></td>
                <td ><a class="glossy-button blue" href="viewlate_2.php"><span>View Lates</span></a></td>
            </tr>
            <tr class="twoCenteredButtons">
                <td ><a class="glossy-button blue" href="login_2_2.php?dress=1"><span>Add Dress Violation</span></a></td>
                <td ><a class="glossy-button blue" href="viewdress_2.php"><span>View Dress Violations</span></a></td>
            </tr>
            <tr class="twoCenteredButtons">
                <td ><a class="glossy-button blue" href="login_2.php?lockdown=1"><span>Add Lockdown</span></a></td>
                <td ><a class="glossy-button blue" href="viewlockdown_2.php"><span>View Lockdowns</span></a></td>
            </tr>
            <tr class="twoCenteredButtons">
                <td ><a class="glossy-button blue" href="login_2.php?test=1"><span>Test Calendar</span></a></td>
                <td ><a class="glossy-button blue" href="login_2.php?scheduleRoom=1"><span>Schedule Computer Labs</span></a></td>
            </tr>
            <tr class="twoCenteredButtons">
                <td ><a class="glossy-button blue" href="serviceAgencies_2.php"><span>View Agency Activity</span></a></td>
                <td ><a class="glossy-button blue" href="login_2.php?scheduleMeeting=1"><span>Schedule Meeting Rooms</span></a></td>
            </tr>
            <?php
            if (is_admin($_SESSION['username'], $_SESSION['password'])) {
                if (is_serv_admin($_SESSION['username'], $_SESSION['password'])) {
                    ?>
                    <tr class="twoCenteredButtons">
                        <td ><a class="glossy-button blue" href="servindstu_2.php"><span>View Reported Service</span></a></td>
                        <td ><a class="glossy-button blue" href="servindstuv_2.php"><span>View Verified Service</span></a></td>
                    </tr>
                    <tr class="twoCenteredButtons">
                        <td><a class="glossy-button blue" href="serviceReporting_2.php"><span>Report Service</span></a></td>
                        <td><a class="glossy-button blue" href="serviceVerify_2.php"><span>Verify Reported Service</span></a></td>
                    </tr>
                    <tr class="twoCenteredButtons">
                        <td><a class="glossy-button blue" href="serviceVerifyA2b_2.php"><span>Verify Service by Agency</span></a></td>
                        <td><a class="glossy-button blue" href="serviceVerifyS2b_2.php"><span>Verify Service by Student</span></a></td>
                    </tr>
                    <tr class="twoCenteredButtons">
                        <td><a class="glossy-button blue" href="addAgency_2.php"><span>Add Service Agency</span></a></td>
                        <td><a class="glossy-button blue" href="serviceShow_2.php"><span>Show All Service Records</span></a></td>
                    </tr>
                    <tr class="twoCenteredButtons">
                        <td><a class="glossy-button blue" href="serviceSummary12fr_2.php"><span>Insufficient Fr</span></a></td>
                        <td><a class="glossy-button blue" href="serviceSummary12so_2.php"><span>Insufficient So</span></a></td>
                    </tr>
                    <tr class="twoCenteredButtons">
                        <td><a class="glossy-button blue" href="serviceSummary12jr_2.php"><span>Insufficient Jr</span></a></td>
                        <td><a class="glossy-button blue" href="serviceSummary12sr_2.php"><span>Insufficient Sr</span></a></td>
                    </tr>
                    <tr class="twoCenteredButtons">
                        <td><a class="glossy-button blue" href="serviceSummary12frso_2.php"><span>Insufficient Fr/So</span></a></td>
                        <td><a class="glossy-button blue" href="serviceSummary12jrsr_2.php"><span>Insufficient Jr/Sr</span></a></td>
                    </tr>

                    <tr class="twoCenteredButtons">
                        <td><a class="glossy-button blue" href="serviceTotal12frso_2.php"><span>Total Service Fr/So</span></a></td>
                        <td><a class="glossy-button blue" href="serviceTotal12jrsr_2.php"><span>Total Service Jr/Sr</span></a></td>
                    </tr>


                    <?php
                } //service only
                if (is_att_admin($_SESSION['username'], $_SESSION['password'])) {
                    ?>
                    <tr class="twoCenteredButtons">
                        <td><a class="glossy-button blue" href="editabsentee_2.php"><span>Edit Absentee</span></a></td>
                        <td><a class="glossy-button blue" href="editlate_2.php"><span>Edit Late</span></a></td>
                    </tr>
                
                    <?php
                } //attendance only
                if (is_super_admin($_SESSION['username'], $_SESSION['password'])) {
                    ?>
                    <tr class="twoCenteredButtons">
                        <td><a class="glossy-button blue" href="login_2.php?calendar=1"><span>Add Calendar Days</span></a></td>
                        <td><a class="glossy-button blue" href="login_2.php?rcalendar=1"><span>Remove Calendar Days</span></a></td>
                    </tr>
                    <?php
                }//super only
            } //isAdmin
        } else {  //not a Teacher
            ?>
            <tr class="twoCenteredButtons">
                <td><a class="glossy-button blue" href="readannouncements_2.php"><span>Read Announcements</span></a></td>
                <td><a class="glossy-button blue" href="scheduleViewS_2.php"><span>Computer Lab Usage</span></a></td>
            </tr>
            <tr class="centeredButton">
                <td align=center colspan=2><a class="glossy-button blue" href="TimeSchedules.pdf"><span>Bell Schedules</span></a></td>
            </tr>
            
            <tr>ALL service should be reported below, even service done through a school sponsored function.
                For school sponsored functions, such as the Cares Walk, the sponsoring teacher will verify your service, so
                no Service Verification Form is needed to be turned in to Mr. Fitzpatrick. ALL other service reported online
                must also have a Service Verification Form turned in to Mr. Fitzpatrick to verify the service performed.</tr>
            <tr class="twoCenteredButtons">
                <td><a class="glossy-button blue" href="serviceReportPageS_2.php"><span>Report Your Service</span></a></td>
                <td><a class="glossy-button blue" href="servindstuaS_2.php"><span>View All Reported Service</span></a></td>
            </tr>
            <tr class="twoCenteredButtons">
                <td><a class="glossy-button blue" href="servindstuvS_2.php"><span>View Verified Service</span></a></td>
                <td><a class="glossy-button blue" href="servindsturS_2.php"><span>View Rejected Service</span></a></td>
            </tr>
            
            <tr class="twoCenteredButtons">
                <td><a class="glossy-button blue" href="http://www.holyghostprep.org/uploaded/documents/Service_Documents/CSPVerify.pdf"><span>Service Verification Form</span></a></td>
                <td><a class="glossy-button blue" href="http://www.holyghostprep.org/uploaded/documents/Service_Documents/ServiceWebsites.pdf"><span>Service Site Links</span></a></td>
            </tr>
            <tr class="twoCenteredButtons">
                <td><a class="glossy-button blue" href="http://www.holyghostprep.org/uploaded/documents/Service_Documents/CSPproj0809.pdf"><span>Service Opportunities</span></a></td>
                <td><a class="glossy-button blue" href="http://www.holyghostprep.org/uploaded/documents/Service_Documents/CSPbro0809.pdf"><span>Service Handbook</span></a></td>
            </tr>
            <tr class="twoCenteredButtons">
                <td><a class="glossy-button blue" href="http://www.holyghostprep.org/page.cfm?p=298"><span>Service Home Page</span></a></td>
                <td><a class="glossy-button blue" href="../docs/Update.pdf"><span>Monthly Service Update</span></a></td>
            </tr>
            
            <?php
        } //isTeacher
        ?>
        <tr class="centeredButton">
            <td align=center colspan=2><a class="glossy-button blue" href="logout_2.php"><span>Logout</span></a></td>
        </tr>
    </table>
    <?php
    $doneButtons = true;
} //logged in
if (!$doneButtons) {
    ?>
    <table class="centered">
        
        <tr class="centeredButton">
            <td class="centeredButton"><a class="glossy-button blue" href="readannouncements_2.php"><span>Read Announcements</span></a></td>
        </tr>
        <tr class="centeredButton">
            <td class="centeredButton"><a class="glossy-button blue" href="TimeSchedules.pdf"><span>Bell Schedules</span></a></td>
        </tr>
        <tr class="centeredButton">
            <td class="centeredButton"><a class="glossy-button blue" href="scheduleViewS_2.php"><span>Computer Lab Usage</span></a><br></td>
        </tr>
        <tr class="centeredButton">
            <td class="centeredButton"><a class="glossy-button blue" href="login_2.php?home=1"><span>Login</span></a></td>
        </tr>
    </table>
    <br><br>

    <?php
}

//This puts the day, month, and year in seperate variables
$day = date('d');
$month = date('m');
$year = date('Y');
$day_of_week = date('D');

//Here we generate the first day of the week
$minus = 0;
switch ($day_of_week) {
    case "Mon": $minus = 1;
        break;
    case "Tue": $minus = 2;
        break;
    case "Wed": $minus = 3;
        break;
    case "Thu": $minus = 4;
        break;
    case "Fri": $minus = 5;
        break;
    case "Sat": $minus = 6;
        break;
}

//This counts the days in the week, up to 7 and calendar days up to 28
$day_count = 0;
$cal_count = 0;
?>
<table border=1  class="calendar">
    <tr><th class="weekDays">Sunday</th><th class="weekDays">Monday</th><th class="weekDays">Tuesday</th><th class="weekDays">Wednesday</th><th class="weekDays">Thursday</th><th class="weekDays">Friday</th><th class="weekDays">Saturday</th></tr>
    <?php
    //Keep going while there are days in the month or we haven't completed a full week
    echo "<tr>";
    while ($day_count < 7 && $cal_count < 28) {
        echo "<td class='valign'>";
        $current = mktime(0, 0, 0, $month, $cal_count + $day - $minus, $year);
        if (date('d', $current) == date('d')) {
            echo "<b>" . date('d') . "</b>";
        } else {
            echo date('d', $current) . "<br>";
        }

        $date = date("Y-m-d", $current);
        $sql = "SELECT * FROM calendar WHERE date=:date";
        $query = $db->prepare($sql);
        $query->bindValue(":date", $date);
        $query->execute();

        if ($query->rowCount() == 0) {
            echo "<p></p>";
        } else {
            echo "<p>";
            echo $query->fetchObject()->letter;
            echo "</p>";
        }

        $query = null;
        echo "</td>";
        $day_count++;
        $cal_count++;

        //Make sure we start a new row every week
        if ($day_count > 6) {
            $day_count = 0;
            echo "</tr>";
            if($cal_count <28){
                echo "<tr>";
            }
        }
    }
    $db = null;
    ?>
</table>
<?php
dohtml_footer(true);
?>