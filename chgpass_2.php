<?php
session_start();
include 'functions_2.php';
password_protect();
teacher_only();
include 'includeInc_2.php';
dohtml_header("Change Password");
?>


<table class="centered">
    <tr class="centered">
        <td class ="centered">

            <form action=submit_2.php method='post' name='theForm'>

                New Password: <input type='password' name='newpassword' /><br>

                Confirm New Password: <input type='password' name='confirmnewpassword' /><br>

                <input type=submit name=submit value='Change Password'/>

            </form>

        </td>
    </tr>

    <?php
	tableRowSpace();
    homeLogout();
    ?>

</table>
<?php
dohtml_footer(true);
?>
