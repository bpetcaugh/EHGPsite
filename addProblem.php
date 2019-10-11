<?PHP               //CK 3/10/14
session_start();
include 'functions_2.php';
super_admin_only();
password_protect("login_2.php?problem=1");
include 'includeInc_2.php';
dohtml_header("Add Type of Problem");
?> 

    <table class='centered'><form action='submit_2.php' method='post'>
                <?php
                homeLogout();
                ?>
                <br>
                <tr><td><p>Type in the type of problem below if there is not one already created. <br><br> </p></td></tr>
         
                <?php
                echo "<tr><td><input type='text' name='newProblem' size=50></td></tr>";
                ?>
                <tr><td><input type='submit' name='submit' value='Submit'></td></tr>
                   
            </form>
            
        </table>
<?dohtml_footer(true);?>
