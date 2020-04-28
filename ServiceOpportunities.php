<?PHP
include 'functions.php';
password_protect();

$db = get_database_connection();

if ($_SESSION['username']) {
    $username = $_SESSION['username'];
    $result = mysql_query("SELECT * FROM teacher WHERE username='$username'");
    $row = mysql_fetch_array($result);
    if ($_SESSION['username'] == $row['username'] && $_SESSION['password'] == $row['password']) {
        $teacherid = $row['id'];
?>

        <script type='text/javascript'>
            function refresh()
            {
                var formObject = document.forms['theForm'];
                formObject.action="ServiceOpportunities.php";
                formObject.submit();
            }
        </script>

         <html>
            <body bgcolor=#CCCCCC>
                <br>
                <table align=center><td>

                        <form name='theForm' method='post' action='ServiceOpportunities.php'>

            <?php
            //Set up header: date, home page link, EHGP home page, Logout
            $button = boldbuttons;
            $pixels = 200;
            print_header("Service Opportunities", $pixels, $button);
            echo "";

             echo "<table align=center border=1><tr>
                 <th>Date</th>
                 <th>Spots available</th>
                 <th>Hours</th>
                 <th>Agency</th>
                 <th>Notes</th>
                 </tr>";

             $result = mysql('SELECT * FROM serviceopportunities');
              while ($row = mysql_fetch_array($result)) {

              ?> <tr>
                        <td><?php echo $result['name']; ?></td>
                        <td><?php echo $result['lastname']; ?></td>
                        <td><?php echo $result['grade']; ?></td>
                        <td><?php echo $row['date']; ?></td>

                        <?php

              }

            ?>

            </form>



</table>
    </body>
<?php
}
else
{
	redirect("login.php?ServiceOpportunities=1");
}
}
else
{
		redirect("login.php?ServiceOpportunities=1");
}
$db = null;
?>