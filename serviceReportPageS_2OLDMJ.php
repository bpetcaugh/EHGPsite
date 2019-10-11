<?php
//edited by Vincent Pillinger
session_start(); //added 2-5-12
include 'functions_2.php';
password_protect();
?>
<style type="text/css">
    input {
        background-color: #FFFFFF;
        border: 2px solid #900000;
        font-family: verdana;
        font-size: 14px;
        color: #555555;
    }
</style>
<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.action = "serviceReportPageS_2.php";
        formObject.submit();
    }

    function displayGrade() {
        alert($GET_['grade']);
        tBox.focus();
    }

    function addDate() {
        var box = document.datesAdd.skipList;
        var date = document.datesAdd.addSkip.value;
        if (!isValidDate(date)) {
            alert("Please enter a valid date in the format YYYY-MM-DD.");
            return;
        }
        var optn = document.createElement("OPTION");
        optn.value = date;
        optn.text = date;
        var i = 0;
        for (i = 0; i < box.options.length && compareStrings(box.options[i].value, date) < 0; i++) {
        }
        if (i < box.options.length) {
            if (compareStrings(box.options[i].value, date) == 0)
                return;
            var afterDate = new Array();
            while (i < box.options.length) {
                afterDate.push(box.options[i]);
                box.remove(i);
            }
            box.options.add(optn);
            for (i = 0; i < afterDate.length; i++)
                box.options.add(afterDate[i]);
        } else
            box.options.add(optn);
    }
    function removeDate() {
        document.datesAdd.skipList.remove(document.datesAdd.skipList.selectedIndex);
    }
    function compareStrings(s1, s2) {
        var len1 = s1.length;
        var len2 = s2.length;
        var n = (len1 < len2 ? len1 : len2);

        for (i = 0; i < n; i++) {
            var a = s1.charCodeAt(i);
            var b = s2.charCodeAt(i);
            if (a != b) {
                return(a - b);
            }
        }
        return(len1 - len2);
    }
    function checkValidDate(tBox) {
        if (!isValidDate(tBox.value)) {
            alert("Please enter a valid date in the format YYYY-MM-DD.");
            tBox.focus();
        }
    }
    function checkValidLetter(tBox) {
        var c = tBox.value.charCodeAt(0);
        if (!((c >= 65 && c <= 72) || c == 88)) { //A-H or X
            alert("Please enter a valid letter day (A-H or X, uppercase).");
            tBox.focus();
        }
    }
    function isValidDate(s) {
        if (s.length != 10)
            return false;
        var year = parseInt(s.substring(0, 4), 10);
        //alert(year);
        //tBox.focus();

        if (isNaN(year) || year < 1000)
            return false;
        if (s.charAt(4) != '-')
            return false;
        var month = parseInt(s.substring(5, 7), 10);
        //alert(month);
        //tBox.focus();

        if (isNaN(month) || month < 0 || month > 12)
            return false;
        var maxDay;
        switch (month) {
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                maxDay = 31;
                break;
            case 4:
            case 6:
            case 9:
            case 11:
                maxDay = 30;
                break;
            case 2:
                if (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0))
                    maxDay = 29;
                else
                    maxDay = 28;
                break;
            default:
                return false;
        }
        if (s.charAt(7) != '-')
            return false;
        var day = parseInt(s.substring(8, 10), 10);
        // alert(day);
        // tBox.focus();
        if (isNaN(day) || day < 0 || day > maxDay)
            return false;
        return true;
    }

    function send()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>

<?php
$db = get_database_connection();

if (isset($_SESSION['username'])) {
    include 'includeInc_2.php';
    dohtml_header("Service Reporting");//were javascript functions not available???
?>
<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.action = "serviceReportPageS_2.php";
        formObject.submit();
    }

    function displayGrade() {
        alert($GET_['grade']);
        tBox.focus();
    }

    function addDate() {
        var box = document.datesAdd.skipList;
        var date = document.datesAdd.addSkip.value;
        if (!isValidDate(date)) {
            alert("Please enter a valid date in the format YYYY-MM-DD.");
            return;
        }
        var optn = document.createElement("OPTION");
        optn.value = date;
        optn.text = date;
        var i = 0;
        for (i = 0; i < box.options.length && compareStrings(box.options[i].value, date) < 0; i++) {
        }
        if (i < box.options.length) {
            if (compareStrings(box.options[i].value, date) == 0)
                return;
            var afterDate = new Array();
            while (i < box.options.length) {
                afterDate.push(box.options[i]);
                box.remove(i);
            }
            box.options.add(optn);
            for (i = 0; i < afterDate.length; i++)
                box.options.add(afterDate[i]);
        } else
            box.options.add(optn);
    }
    function removeDate() {
        document.datesAdd.skipList.remove(document.datesAdd.skipList.selectedIndex);
    }
    function compareStrings(s1, s2) {
        var len1 = s1.length;
        var len2 = s2.length;
        var n = (len1 < len2 ? len1 : len2);

        for (i = 0; i < n; i++) {
            var a = s1.charCodeAt(i);
            var b = s2.charCodeAt(i);
            if (a != b) {
                return(a - b);
            }
        }
        return(len1 - len2);
    }
    function checkValidDate(tBox) {
        if (!isValidDate(tBox.value)) {
            alert("Please enter a valid date in the format YYYY-MM-DD.");
            tBox.focus();
        }
    }
    function checkValidLetter(tBox) {
        var c = tBox.value.charCodeAt(0);
        if (!((c >= 65 && c <= 72) || c == 88)) { //A-H or X
            alert("Please enter a valid letter day (A-H or X, uppercase).");
            tBox.focus();
        }
    }
    function isValidDate(s) {
        if (s.length != 10)
            return false;
        var year = parseInt(s.substring(0, 4), 10);
        //alert(year);
        //tBox.focus();

        if (isNaN(year) || year < 1000)
            return false;
        if (s.charAt(4) != '-')
            return false;
        var month = parseInt(s.substring(5, 7), 10);
        //alert(month);
        //tBox.focus();

        if (isNaN(month) || month < 0 || month > 12)
            return false;
        var maxDay;
        switch (month) {
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                maxDay = 31;
                break;
            case 4:
            case 6:
            case 9:
            case 11:
                maxDay = 30;
                break;
            case 2:
                if (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0))
                    maxDay = 29;
                else
                    maxDay = 28;
                break;
            default:
                return false;
        }
        if (s.charAt(7) != '-')
            return false;
        var day = parseInt(s.substring(8, 10), 10);
        // alert(day);
        // tBox.focus();
        if (isNaN(day) || day < 1 || day > maxDay)
            return false;
        return true;
    }

    function send()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>

<?php
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $statement = $db->prepare("SELECT * FROM student WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    $row1 = $statement->fetch();
    if ($_SESSION['username'] == $row1['username'] && $_SESSION['password'] == trim($row1['password'])) {
        $sid = $row1['id'];
        $firstname = $row1['firstname'];
        $lastname = $row1['lastname'];
        ?>


        <form name='theForm' method='post' action='serviceExternalVerify_2.php'>
            <table class='centered'>

                <?php
                homeLogoutService();
				tableRowSpace();
				endAndBeginTable();
                echo "<tr><td>Your Student ID is " . $_SESSION['id'] . "</td></tr>";
				tableRowSpace();
				echo "<input type=hidden name=student value=" . $_SESSION['id'] . ">";
                ?>
				    <table class="centered"><tr><td width=5%></td>
					<td width=90%>ALL service should be reported below, even service done through a school sponsored function.
						For school sponsored functions, such as the Cares Walk, the sponsoring teacher will verify your service, so
						no Service Verification Form is needed to be turned in to Mr. Fitzpatrick. ALL other service reported online
						must also have a Service Verification Form turned in to Mr. Fitzpatrick to verify the service performed.
					</td><td width=5%></td></tr></table> 
                <table>
        
				
				<tr><td width='70%'>            
							<?php
                            if (isset($_POST['servicehours'])) {
                                $tempservicehours = $_POST['servicehours'];
                            } else {
                                $tempservicehours = "";
                            }
                            echo "Enter Service Hours: <t /><input type=text name=servicehours value='" . $tempservicehours . "' size=3>";
                            ?>
							
                        </td>
                        <td width='30%'>
                            <table border='2'><tr><td>
                                        <a onMouseOver="alert('For service performed at the same site on multiple days, \ntotal the hours and enter them here. Be sure to submit \nthe required Service Verification Form to Mr. Fitzpatrick.')">Can I total hours performed on different dates at the same site?</a>
                                        <br />
                                    </td></tr></table>
                        </td></tr><tr><td width='70%'>
                            
							<?php
                            if (isset($_POST['date'])) {
                                $tempdate = $_POST['date'];
                            } else {
                                $tempdate = "";
                            }
                            echo "Date of Service (YYYY-MM-DD):   <t /><input type=text name=date value='" . $tempdate . "' size=10 onBlur='checkValidDate(document.theForm.date)'>";
                            ?>
							
                        </td>
                        <td width="30%">
                            <table border='2'>
                                <tr><td>
                                        <a onMouseOver="alert('For service performed at the same site on multiple days, \nyou need only enter the last date service was performed.')">If service is performed at the same site on multiple days, do I need to enter every day?</a><br />
                                    </td></tr></table>
                        </td></tr><tr><td width='70%'>
                            
                            
							<?php
//agency drop down
                            $agid = 0; //not working for 2013; try to fix here; ck had name instead of id for option value value
                            $agency = "agency";
                            $stha = $db->prepare("SELECT * FROM agencies ORDER BY name");
                            $stha->execute();
                            if ($stha->rowCount() < 1)
                                return false;
                            echo "Select: <select name='" . $agency . "' onchange=refresh()>";
                            echo "<option value=0>Select Agency</option>";
                            while ($row2 = $stha->fetch()) {
                                //echo "<option value='" . $row2['name'] . "' ";
                                echo "<option value=\"{$row2['name']}\"";//Ricky Wang MMM concat change 4-22-16
                                if (isset($_POST[$agency]) && $_POST[$agency] == $row2['name']) {
                                    echo "selected";
                                    $agid = $row2['id'];
                                }
                                //echo ">" . $row2['name'] . "</option>";
                                echo ">{$row2['name']}</option>";//Ricky Wang MMM concat change 4-22-16
                            }
                            echo "</select>"; 
							//next two lines to see where problem is
							//echo $agid . "AGID";
							//if (isset($_POST[$agency])) echo $_POST[$agency];
                            //Not sure if the next two line are necessary, I just left them in in case
                            echo "<input type=hidden value='" . $agid . "' name=agid>";
                            //echo "<input type=hidden value='" . $teacherid . "' name=teacherid>";
                            ?>
							
                        </td><td width="30%">
                            <table border='2'>
                                <tr><td>
                                        <a onMouseOver="alert('If your service agency is not in the drop down list, \nsend Mr. Fitzpatrick an email and ask him to add \nthe agency for you. To properly enter your service online, \nyour agency must appear in the drop down list.')">My service agency isn't listed...how can I report my service properly? What should I do?</a><br />
                                    </td></tr></table>
                        </td></tr>
                </table>
                <br /><br />
                <table>
                    <tr><td>Please describe the type of service<br>that you performed at the service site:</td>
                        <td><textarea rows=5 cols=50 name='notes'></textarea></td></tr>
                </table>
                <br /><br /><center>
                    <input type='button' value='Submit' onclick='send()'><br><br>
                    </form>
					
                    <?php
                }
            } else {
                redirect("login_2.php?serviceReportPageS_2.php");
            }
            $db = null;
            echo "</td></table>";
            dohtml_footer(true);
            ?>


