<?PHP
//Edited by Christian Kardish

session_start();
include 'functions_2.php';
include 'includeInc_2.php';
dohtml_header('Service Deficiency Summary');
serv_admin_only();
password_protect();
$db = get_database_connection();

//global $thisgradyear; //unused
//$jryrcn = $thisgradyear+1000;  //change this every year

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
        ?><head>
            <link rel="stylesheet" type="text/css" href="css_2.css" />
            <link rel ="stylesheet" type ="text/css" href ="table.css" />
            <script type='text/javascript'>
                function refresh()
                {
                    var formObject = document.forms['theForm'];
                    formObject.action = "serviceDeficiencySummaryAll_2.php";
                    formObject.submit();
                }
            </script>
            <title>Service Deficiency Summary</title>
        </head>


        <br>
        <?php
        //Set up heading: Date, links to HGP Home Page, EHGP, and Logout (done)
        $date = date('Y-m-d');
        echo "<h2 align=center>" . date('l', strtotime($date)) . "<br>" . $date . "</h2>";
        echo " ";
        ?>
		<form name='theForm' method='post' action='serviceDeficiencySummaryAll_2.php'>
      <tr><table class='centered'><td width ='33%'></td> <td width='33%'> <b> View By: </b> <select name='view' onchange='refresh()'>
    <?php

    // Headings to display
		$headings[0] = "All Grades";
		$headings[1] = "Freshman";
		$headings[2] = "Sophomore";
		$headings[3] = "Junior";
		$headings[4] = "Senior";
		$headings[5] = "Freshman and Sophomore";
		$headings[6] = "Junior and Senior";

    $isView = false;
    if(isset($_POST['view'])){    //if page has been refreshed
        $isView = true;
    }

    for ($i = 0; $i < count($headings); $i++) {
      echo "<option value='$i'";
      if (($isView && $_POST['view'] == $i)) {  //if refreshed
          echo " selected=selected";
          $view = $i;
      }
      echo ">" . $headings[$i] . "</option>";
    }
    echo "</select> </td><td width='33%'></td> </tr> </form>";

    $start =9;
	$end=13;
	$multiple=true;
    if(isset($_POST['view'])){
      $view = $_POST['view'];
      if($view == 0){
        $start = 9;
		$end=13;
      }else if($view == 1){
        $start =9;
		$end=10;
      }else if($view == 2){
        $start = 10;
		$end=11;
      }else if($view == 3){
        $start= 11;
		$end=12;
      }else if($view == 4){
        $start = 12;
		$end=13;
      }else if($view == 5){
        $start = 9;
		$end=11;
      }else if($view == 6){
        $start = 11;
		$end=13;
      }
    } else {
      $start=9; 
	  $end=13;//defaults to 'most recent'
    } ?>
        <br />
        <table class='centered'><td width ='33%'></td><td width='33%' class='centered'>
                <!--        <form name='theForm' method='post' action='serviceVerifyS4.php'>//-->

                <?php { //of if SUBMIT
                    $stidsel = 0; //$servdbrow2['agency'];
                    $firstname = " no assignment ";
                    $lastname = " no assignment ";
					$idnum=0;
                    $grade = $start;
					echo "<table class='centered' border=1>";
                    echo "<tr><td>ID Number</td><td>Name:</td><td>Hours</td></tr>";
					while ($grade!=$end) {
					$rowst2 = getStudents($grade);
//$rows = getService();
                    foreach ($rowst2 as $row2) {
                        $cn = $row2['classnum'];
                        $totalServHrs = getServiceHours($cn);
                        $name = $row2['lastname'] . ", " . $row2['firstname'];
                        $grade = $row2['grade'];
						$idnum=$row2['id'];
                        if (!isset($totalServHrs))
                            $totalServHrs = 0;
                        if ((($grade==9||$grade==10)&&($totalServHrs < 10))||($grade==11||$grade==12)&&($totalServHrs < 20)){ // && ($cn >= $jryrcn) && ($cn < ($jryrcn + 1000))) {
                            echo "<tr><td>" . $idnum. "</td><td>". $name . "</td><td>" . $totalServHrs. "</td></tr>";
                        }
                    }
					$grade++;
					}
					echo "</td></tr>";
                    echo "</table>";
                }
                ?>
            </td><td width='33%'></td></table> <br /> <br />
        <?php
    } else { //if isset
        redirect("login_2.php?index_2.php");
    } //if Session
}//if isset
$db = null;
echo "<table class='centered'><td class='centered'>";
homeLogoutService();
echo "</td></table>";
dohtml_footer(true);
//</form>
?>
