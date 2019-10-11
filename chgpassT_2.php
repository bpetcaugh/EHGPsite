<?php
/*Fred Kummer '13
 * Adapted by Robert Conway '13
 * Fixed by Eric Ghildyal '15 */
session_start();
include 'functions_2.php';
password_protect();
include 'teacherpicker_2.php';
super_admin_only();
include 'includeInc_2.php';
dohtml_header("Change Password");
?>

<head>
    <!-- <script type="text/javascript" src="strengthmeter_2.js"></script> -->
    <link rel="stylesheet" type="text/css" href="chgpasscss_2.css" />
    <script>
        function confirmPass() {
            var pass = document.forms['theForm2']['newpassword'].value;
            var conf = document.forms['theForm2']['confirmnewpassword'].value;
            if (pass !== conf) {
                alert("Your confirmation does not match what you originally typed");
                return false;
            }
            return true;
        }

        function refresh(){
          var formObject = document.forms['theForm'];
          formObject.submit();
        }
    </script>
</head>

<table class="centered">

    <td>

      <table border="1" class="centered250">
          <tr>
              <td >Passwords must be at least 8 characters and contain a lowercase letter, uppercase letter, and a digit.</td>
          </tr>
      </table>

        <?php
        teacherSelector('chgpassT_2.php');

        echo "<form action='submitPassT_2.php' method='post' onsubmit='return confirmPass()' name='theForm2'>";

        if (isset($_GET['teacher'])) {
            $_SESSION['passnameid'] = $_GET['teacher'];
          }
        ?>

            New Password: <input type='password' name='newpassword' id='pass' /><br/>

            Confirm New Password: <input type='password' id ='confirm' name='confirmnewpassword' /><br>

          <?php
          if(isset($_GET['teacher'])){
            echo "<input type=hidden name='teacherid' id='teacherid' value='" . $_GET['teacher'] . "' />";
          }
          ?>
            <!-- <label for="passwordStrength">Password strength</label> -->

            <!-- <div id="passwordDescription">Password not entered</div>

            <table class="centered">
            <tr class="centeredButton"><td class="centered">
            <div id="passwordStrength" class="strength0"></div><br/>
            </td></tr>
            </table>
          -->
            <input type=submit id='subPass' name=submit value='Change Password'/>

        </form>

    </td>

    <?php
    homeLogout();
    ?>
</table>
<?php
dohtml_footer(true);
?>
