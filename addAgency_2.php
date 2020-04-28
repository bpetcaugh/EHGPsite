<?PHP
//edited by Vincent Pillinger
session_start();
include 'functions_2.php';
serv_admin_only();
password_protect("login_2.php?agency=1");
include 'includeInc_2.php';
dohtml_header("Add Service Agency");
?>

    <table class='centered'><form action='submit_2.php' method='post'>
                <?php
                homeLogoutService();
                //$tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
                //echo "Date:<input type=text name=date value='" . date('Y-m-d', $tomorrow) . "'><br>"; 
                ?>
                <br>
                <tr><td><p>Type in the name of the agency to be added below. <br><br>
                        Use the View Agency Activity button to be certain 
                        <br>that you are not adding a duplicate before 
                        <br> adding an agency here. DO NOT USE SPECIAL 
						<br> CHARACTERS! NO QUOTES OR APOSTROPHES!</p></td></tr>
         
                <?php
                echo "<tr><td><input type='text' name='agency' size=50></td></tr>";
                ?>
                <tr><td><input type='submit' name='submit' value='Submit'></td></tr>
                   
            </form>
            
        </table>
<?dohtml_footer(true);?>