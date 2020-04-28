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
                formObject.action="ServiceAddOpportunities.php";
                formObject.submit();
            }
        </script>

         <html>
            <body bgcolor=#CCCCCC>
                <br>
                <table align=center><td>

                        <form name='theForm' method='post' action='ServiceAddOpportunities.php'>

            <?php
            //Set up header: date, home page link, EHGP home page, Logout
            $button = boldbuttons;
            $pixels = 200;
            print_header("Add Service Opportunities", $pixels, $button);
            echo "";
            
            if ($_POST['submit']){

                $result5 = mysql_query("SELECT * FROM agencies");
                while ($row5 = mysql_fetch_array($result5)) {
					if ($_POST['agency'] == $row5['name']) {
						$agid = $row5['id'];
						mysql_query("INSERT INTO serviceopportunities (date, spots, hours, notes, agency) VALUES ('" . $_POST['date'] . "','" . $_POST['spots'] . "','" . $_POST['hours'] . "','" . $_POST['notes'] . "' , '" . $agid . "' )");
					}
               }
	        }

            echo "Date (YYYY-MM-DD): <t/><input type=text name=date value= ><br><br>";
            echo "Spots: <t/><input type=text name=spots value= ><br><br>";
            echo "Service Hours: <t/><input type=text name=hours value= ><br><br>";
            echo "Notes: <textarea rows=4 cols=50 name='notes'></textarea><br><br>";
    
	        $agid = 0;
            $agency = "agency";
            $result5 = mysql_query("SELECT * FROM agencies");
            echo "<select name='" . $agency . "' onchange='refresh()'>";
            echo "<option value=0>Select Agency</option>";

            while ($row5 = mysql_fetch_array($result5)) {
                        echo "<option value='" . $row5['name'] . "' ";
                        echo ">" . $row5['name'] . "</option>";
            }
            ?>
            <center><input type='submit' name='submit' value='Submit'><br><br></center>
            </form>

</table>
    </body>
<?php
	}
	else
	{
		redirect("login.php?ServiceAddOpportunities=1");
	}
}
else
{
			redirect("login.php?ServiceAddOpportunities=1");
}
$db = null;
?>