<?PHP
//edited by Vincent Pillinger
session_start();
include 'functions_2.php';
admin_only();
include 'includeInc_2.php';
dohtml_header("Add Calendar Days");
?>
<script language="JavaScript">
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
        return true;
        if (s.length != 10) return false;
        var year = parseInt(s.substring(0,4),10);
        if (isNaN(year) || year < 1000)
            return false;
        if (s.charAt(4) != '-')
            return false;
        var month = parseInt(s.substring(5,7),10);
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
                                            if (isNaN(day) || day < 0 || day > maxDay)
                                                return false;
                                            return true;
                                        }
                                        function send() {
                                            var box = document.datesAdd.skipList;
                                            box.multiple = true;
                                            for (i=0;i<box.options.length;i++)
                                                box.options[i].selected=true;
                                            box.name = "skipList[]";
                                            document.datesAdd.submit();
                                        }
</script>
<form name=datesAdd action='submit_2.php' method='post'>
<table class='centered'>
    <? homeLogout(); ?>
    </table><table class="centered"><tr><td>Calendar days added using this utility will automatically be assigned letter days based on input and room schedulings<br>
        based on the autoroomschedule database table. Weekends are automatically skipped; other skip days must be added to the list below.</td></tr>
    <tr><td>
                <?php
                $tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
                $nextday = mktime(0, 0, 0, date("m"), date("d") + 2, date("Y"));
                echo "Start Date: <t/><input type=text name=startDate value='" . date('Y-m-d', $tomorrow) . "' onBlur='checkValidDate(document.datesAdd.startDate)'><br>";
                echo "End Date:   <t/><input type=text name=endDate   value='" . date('Y-m-d', $nextday) . "' onBlur='checkValidDate(document.datesAdd.endDate)'><br>";
                echo "Letter Day: <t/><input type=text name=letterDay value='A' onBlur='checkValidLetter(document.datesAdd.letterDay)'><br>";
                ?>
                <br>Skip Dates:<br>
                <select style="width:120px;" size="6" name="skipList"></select>
                <input type=button value="Remove Selected" onClick="removeDate()"><br>
                <?php
                echo "Add Skip Date: <input type=text name=addSkip value='" . date('Y-m-d', $tomorrow) . "'>";
                echo "<input type=button value='Add' onClick='addDate()'><br>";
                ?>
                <input type=button value='Submit' onClick="send()"><br><br>
        </td></tr>
    </table></form>
<?dohtml_footer(true)?>