<?PHP
session_start();
include 'functions.php';
serv_admin_only();
password_protect();
$db = get_database_connection();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $tchdb1 = $db->prepare("SELECT * FROM teacher WHERE username=:username AND password=:password");
    $tchdb1->bindValue(":username", $username);
    $tchdb1->bindValue(":password", $password);
    $tchdb1->execute();
    $tchdbrow = $tchdb1->fetch();
    
    if ($_SESSION['username'] == $tchdbrow['username'] && $_SESSION['password'] == $tchdbrow['password']) {
         $teacherid = $tchdbrow['id'];
	//database access working check     echo $username,$teacherid;	
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css.css" />
    <link rel ="stylesheet" type ="text/css" href ="table.css" />
    <script type='text/javascript'>
        function refresh()
        {
            var formObject = document.forms['theForm'];
            formObject.action="serviceVerifyA2.php";
            formObject.submit();
        }
    </script>
    <title>Service Verification Form</title>
</head>
<body bgcolor=#CCCCCC>
    <h1 align="center">Service Verification Form</h1>
    <br>
<?php 				   //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
    $date = date('Y-m-d');
    echo "<h2 align=center>" . date('l', strtotime($date)) . "<br>" . $date . "</h2>";
    echo "<center><a href=http://www.holyghostprep.org>Holy Ghost Prep Home Page</a></center>";
    echo "<center>&nbsp&nbsp<a href=index.php>EHGP Home</a></center>";
    echo "<center>&nbsp&nbsp<a href=logout.php>Logout</a></center><br><br>";
    echo " ";
?>
    <br>
    <table align=center><td>
        <form name='theForm' method='post' action='serviceVerifyA4.php'>
<?php 
   { //of if SUBMIT
    	//Drop down for agencies list ?????????????????????????????????
        $agidsel = 0;//$servdbrow2['agency'];
        //$sql7 = "SELECT * FROM agencies WHERE id=:agidsel";
        //$agdb1 = $db->prepare($sql7);
        //$agdb1->bindvalue(":agidsel",$agidsel);
        //$agdb1->execute();
        //$agdbrow1 = $agdb1->fetch();
        $nameOfSelected = "Select Agency";//$agdbrow1['name'];

        //$agid = 0;
        $agency = "agency";
        $i = 0;
        $agdb2 = $db->prepare("SELECT * FROM agencies ORDER BY name");
        $agdb2->execute();
        //This should never happen
        if ($agdb2->rowCount() < 1) return false;
	echo "Select:<select name='agid'>";
        echo "<option value='" . $agidsel . "' >" . $nameOfSelected . "</option>";
        while ($agdbrow2 = $agdb2->fetch()) {
            $i++;
            echo "<option value='" . $agdbrow2['id'] . "' ";
            if (isset($_POST['agid']) && $_POST['agid'] == $agdbrow2['id']) {   //?1
                echo "selected";
                $agid = $agdbrow2['id'];
                $agency = $agdbrow2['name']; // sets $sss5
						//$agencyupdate = "agid";
            }
            echo ">" . $agdbrow2['name'] . "</option>";
        }
        echo "</select>";
        //Not sure if the next two line are necessary, I just left them in in case
        
        //echo "<input type=hidden value='" . $agid . "' name='agid'>";
        //echo "<input type=hidden value='" . $teacherid . "' name=teacherid>";
	//echo $_POST['agid'];
      }
?>
            <center><input type='submit' name='submit' value='Submit'><br><br></center>
		</form>

       </td></table>

<?php
	} 
	else { //if isset
            redirect("login.php?serviceVerifyA2.php");
	} //if Session
}//if isset
$db = null;
//</form>
?>
        	
	</body>
</html>