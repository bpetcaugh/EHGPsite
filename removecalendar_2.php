<?PHP
//edited by Vincent Pillinger
session_start();
include 'functions_2.php';
admin_only();
include 'includeInc_2.php';
dohtml_header("Remove Calendar Day");
?>
<script type="text/javascript"  language="JavaScript">
    function checkValidDate(tBox) {
        if (!isValidDate(tBox.value)) {
            alert("Please enter a valid date in the format YYYY-MM-DD.");
            tBox.focus();
        }
    }
    function isValidDate(s) {
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
</script>

    <form name=datesRemove action='submit_2.php' method='post'>
         <table class='centered'>
             <? homeLogout(); ?>
    </table><table class="centered"><tr><td><p>When a calendar day is removed using this utility, letter days and room assignments from this day forward will be shifted forward <br>
        one school calendar day: each calendar day takes on the previous letter, and room assignments are moved forward to the next existing<br>
        calendar day. Room assignments from the last calendar day are shifted to the next weekday to be dealt with manually according to circumstances.</p></td></tr>
   <tr><td>
            
                <?php
                $tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
                echo "Remove Date: <t/><input type=text name=removeDate value='" . date('Y-m-d', $tomorrow) . "' onBlur='checkValidDate(document.datesRemove.removeDate)'><br>";
                ?>
                <input type=submit value='Submit'><br><br>

        
   </td></tr></table></form>

<? dohtml_footer(true)  ?>;