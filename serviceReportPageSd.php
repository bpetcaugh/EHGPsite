<html>
    <head>
        <title>Service Reporting</title>
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
                formObject.action="serviceReportPageS.php";
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
                for (i=0;i<box.options.length && compareStrings(box.options[i].value,date)<0;i++) {}
                if (i<box.options.length) {
                    if (compareStrings(box.options[i].value,date)==0) return;
                    var afterDate = new Array();
                    while (i < box.options.length) {
                        afterDate.push(box.options[i]);
                        box.remove(i);
                    }
                    box.options.add(optn);
                    for (i=0;i<afterDate.length;i++)
                        box.options.add(afterDate[i]);
                } else box.options.add(optn);
            }
            function removeDate() {
                document.datesAdd.skipList.remove(document.datesAdd.skipList.selectedIndex);
            }
            function compareStrings(s1,s2) {
                var len1 = s1.length;
                var len2 = s2.length;
                var n = (len1<len2 ? len1 : len2);

                for(i=0;i<n;i++) {
                    var a = s1.charCodeAt(i);
                    var b = s2.charCodeAt(i);
                    if(a!=b) {
                        return(a-b);
                    }
                }
                return(len1-len2);
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
                if (s.length != 10) return false;
                var year = parseInt(s.substring(0,4),10);
                //alert(year);
                //tBox.focus();

                if (isNaN(year) || year < 1000)
                    return false;
                if (s.charAt(4) != '-')
                    return false;
                var month = parseInt(s.substring(5,7),10);
                //alert(month);
                //tBox.focus();

                if (isNaN(month) || month < 0 || month > 12)
                    return false;
                var maxDay;
                switch (month) {
                    case 1: case 3: case 5: case 7: case 8: case 10: case 12:
                                                maxDay = 31;
                                                break;
                                            case 4: case 6: case 9: case 11:
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
                                                    var day = parseInt(s.substring(8,10),10);
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
        <link rel="stylesheet" type="text/css" href="css.css" />
    </head>
    <?PHP
    include 'functions.php';
    password_protect();

    $db = get_database_connection();

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];

        $statement = $db->prepare("SELECT * FROM student WHERE username=:username AND password=:password");
        $statement->bindValue(":username", $username);
        $statement->bindValue(":password", $password);
        $statement->execute();

        $row1 = $statement->fetch();
        if ($_SESSION['username'] == $row1['username'] && $_SESSION['password'] == $row1['password']) {
            $sid = $row1['id'];
            $firstname = $row1['firstname'];
            $lastname = $row1['lastname'];
            ?>
    <body bgcolor=#CCCCCC>
        <center><h1>Service Report</h1></center>
        <br>
        <table align=center><td>
                <form name='theForm' method='post' action='submit.php'>
                    <!--where style was //-->

                            <?php

                            echo "<br />";

                            echo "<center>Your Student ID is " . $_SESSION['id'] . "<br /><br /><br /><input type=hidden name=student value=" . $_SESSION['id'] . "></center>";
                            ?>
                    <table border='1'><tr><td width='70%'>
                                        <?php
                                        echo "Enter Service Hours: <t /><input type=text name=servicehours value='" . $_POST['servicehours'] . "' size=3>";
                                        ?>
                            </td>
                            <td width='30%'>
                                <table border='2'><tr><td>
                                            <a onMouseOver="alert('For service performed at the same site on multiple days, \ntotal the hours and enter them here. Be sure to submit \nthe required Service Verification Form to Mr. Fitzpatrick.')">Can I total hours performed on different dates at the same site?</a>
                                            <br /><br />
                                        </td></tr></table>
                            </td></tr><tr><td width='70%'>
                                        <?php
                                        echo "Date of Service (YYYY-MM-DD):   <t /><input type=text name=date value='" . $_POST['date'] . "' size=10 onBlur='checkValidDate(document.theForm.date)'>";
                                        ?>
                            </td>
                            <td width="30%">
                                <table border='2'>
                                    <tr><td>
                                            <a onMouseOver="alert('For service performed at the same site on multiple days, \nyou need only enter the last date service was performed.')">If service is performed at the same site on multiple days, do I need to enter every day?</a><br />
                                        </td></tr></table>
                            </td></tr></table>
                    <br />
                            <?php

//agency drop down
                            $agid = 0;
                            $agency = "agency";
                            $stha = $db->prepare("SELECT * FROM agencies ORDER BY name");
                            $stha->execute();
                            if ($stha->rowCount() < 1)
                                return false;
                            echo "Select: <select name='" . $agency . "' onchange=refresh()>";
                            echo "<option value=0>Select Agency</option>";
                            while ($row2 = $stha->fetch()) {
                                echo "<option value='" . $row2['name'] . "' ";
                                if ($_POST[$agency] == $row2['name']) {
                                    echo "selected";
                                    $agid = $row2['id'];
                                }
                                echo ">" . $row2['name'] . "</option>";
                            }
                            echo "</select>";
                            //Not sure if the next two line are necessary, I just left them in in case
                            echo "<input type=hidden value='" . $agid . "' name=agid>";
                            echo "<input type=hidden value='" . $teacherid . "' name=teacherid>";
                            ?>
                    <br><br>
                    <table>
                        <tr><td>Please describe the type of service<br>that you performed at the service site:</td>
                            <td><textarea rows=5 cols=50 name='notes'></textarea></td></tr>
                    </table>
                    <br /><br /><center>
                        <input type='button' value='Submit' onclick='send()'><br><br>
                        <a href=index.php>Home</a>
                        <a href=logout.php>Logout</a></center>
                </form>
                        <?php
                    }
                }
                else {
                    redirect("login.php?serviceReportPageS");
                }
                $db = null;
                ?>
            </td></table>
    </body>
</html>
