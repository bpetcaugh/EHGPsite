<?php               //CK 3/10/14
session_start();
include 'includeInc_2.php';
include 'functions_2.php';
dohtml_header("Facility Maintenance Request");
teacher_only(); 
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


<?php
$db = get_database_connection();

if (isset($_SESSION['username'])) {
    ?>
    <script type='text/javascript'>
        function refresh()
        {
            var formObject = document.forms['theForm'];
            formObject.action = "maintenancerequest.php";
            formObject.submit();
        }
        function checkValidEntry(tBox, tBox2, tBox3){
            var message = "";
            message = message.concat(checkValidSelection(tBox));
            if(message == ""){
                message = message.concat(checkValidSelection(tBox2));
            }     
            var error = message.concat(checkValidNotes(tBox3));
            if(error == ""){
                send();
            }else{
               alert(error);
               tBox.focus();
               refresh();
            }       
        }
        function checkValidSelection(tBox) {
            var message = "";
            if (!isValidSelection(tBox.value)) {
                message = "Please select a type of request and/or an urgency level from the drop down menus. ";
            }
            return message;
        }
        function checkValidNotes(tBox) {
            var message = "";
            var notes = tBox.value.trim();
            if (!isValidNotes(notes)) {
                message = "Please enter information about the request in the notes section. ";
            }
            return message;
        }        
        function isValidSelection(s) {
            if (s == 0) {
                return false;
            }
            return true;
        }
        function isValidNotes(s) {
            if (s == "") {
                return false;
            }
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

    $statement = $db->prepare("SELECT * FROM teacher WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    $row1 = $statement->fetch();
    if ($_SESSION['username'] == $row1['username'] && $_SESSION['password'] == $row1['password']) {
        $name = $row1['name'];
        //serviceExternalVerify_2.php is where submit_2.php is now below
        ?>
        <form name='theForm' method='post' action='mainExternalVerify.php'>  
            <table class='centered'>

                <?php
                homeLogout();
                if(isset($_GET['date'])){
                    $date = $_GET['date'];
                }else{
                    $date = mktime(0, 0, 0, date("m"), date("d"), date("Y")); 
                    $date = date('Y-m-d', $date);
                }
                echo "<input type=hidden name=teacher value=" . $_SESSION['id'] . ">";
                echo "<input type=hidden name=date value=" . $date .">";
                ?>				    
                <table>   
                    <tr><td width='70%'>            
                            <?php
                            if (isset($_POST['request'])) {
                                
                            } else {
                                $probID = 0;
                            }
                            $probs = $db->prepare("SELECT * FROM requests ORDER BY id");
                            $probs->execute();
                            if ($probs->rowCount() < 1)
                                return false;                            
                             echo "Select Location of Request: <select name='request'>";
                             echo "<option value=0>Select...</option>";
                             while ($row2 = $probs->fetch()) { 
                                echo "<option value='" . $row2['id'] . "' ";
                                if (isset($_POST['request']) && $_POST['request'] == $row2['name']) {
                                    echo "selected";
                                    $probID = $row2['id'];
                                }
                                echo ">" . $row2['name'] . "</option>"; 
                            }
                            echo "</select>";
                            ?>

                        </td>
                        <td width='30%'>HIGH urgency should only be for issues hindering teaching. </td>        <!--added 3/17-->
                        </tr><tr><td width='70%'><br />

                            <?php
                            $urgency[0] = "Select...";
                            $urgency[1] = "High";   
                            $urgency[2] = "Medium";
                            $urgency[3] = "Low";
                            $length = count($urgency);
                             echo "Select Your Request's Level of Urgency: <select name='urgency'>";
                             for($i=0;$i<$length;$i++){
                                 echo "<option value='$i'";
                                 if (isset($_POST['urgency']) && $_POST['urgency'] == $urgency[$i]) {
                                    echo "selected";
                                    $urgencyId = $i;
                                }
                             echo ">" . $urgency[$i] . "</option>"; 
                            }
                            echo "</select>";                       
                            ?>
                        </td><td width='30%'>MEDIUM urgency should only be for issues that create an inconvenience.</td>        <!--added 3/17-->
                        </tr>
                        <tr><td></td><td width='30%'>LOW urgency should only be for ideas/suggestions or for items needed in the furture.</td></tr>            <!--added 3/17-->
                </table>    
                <br />
                <table>
                    <tr><td>Please describe your request in 100 <br />characters or less in the space provided.</td>
                        <td><textarea rows=3 cols=50 name='notes'></textarea></td></tr>
                </table>
                <br /><br /><center>
                    <input type='submit' value='Submit' onclick='checkValidEntry(document.theForm.urgency, document.theForm.request, document.theForm.notes)'><br><br>
                    </form>

                    <?php
                }
            } else {
                redirect("login_2.php");
            }
            $db = null;
            echo "</td></table>";
            dohtml_footer(true);
            ?>
