
<?php
session_start();
include 'functions_2.php';
password_protect();
$db = get_database_connection();

if (isset($_SESSION['username'])) {
    include 'includeInc_2.php';
    dohtml_header("Student Schedule");
?>
<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>
<?PHP
	$color = array("#001F3F","#0074D9","#7FDBFF","#2ECC40","#FFDC00","#FF851B","#FF4000","#FE2EF7","#B10DC9","#111111","#DDDDDD","#AAAAAA","#996600","#FFFFFF",);
	$colorcount=0;
	function addcolor($courses,$pieces){
		global $color, $colorcount;
		for($x=0;$x<sizeof($courses);$x++){
			if($courses[$x][1] == $pieces[1]){
				return $courses[$x][7];
			}
		}
		$colorcount++;
		return $color[$colorcount-1];
	}
	function findperiod($haystack, $needle){
		if(strpos($haystack, $needle) !== FALSE)	return TRUE;
		//find occurrences of 6-7
		if (strpos($needle,"6") !== FALSE){
			$letter = substr($needle,-3);
			$newneedle = "6-7" . $letter;
			if(strpos($haystack, $newneedle) !== FALSE)	return TRUE;
		}
		//find occurrences of 7-8
		elseif (strpos($needle,"7") !== FALSE){
			$letter = substr($needle,-3);
			$newneedle = "7-8" . $letter;
			if(strpos($haystack, $newneedle) !== FALSE)	return TRUE;
		}
		$hays = explode(" ",$haystack);
		for($x=0;$x<sizeof($hays);$x++){
			//find things like 1(C-D)
			if (strlen($hays[$x])==6 && substr($hays[$x],1,1)=="("){
				$newhaystack = substr($hays[$x],0,3) . ")";
				if(strpos($newhaystack, $needle) !== FALSE)	return TRUE;
				$newhaystack = substr($hays[$x],0,2) . substr($hays[$x],4,2);
				if(strpos($newhaystack, $needle) !== FALSE)	return TRUE;
			}
			//find things like 6-7(A,H)
			elseif(strlen($hays[$x])==8){
				$newhaystack = substr($hays[$x],0,5) . ")";
				if(findperiod($newhaystack, $needle))	return TRUE;
				$newhaystack = substr($hays[$x],0,4) . substr($hays[$x],6,2);
				if(findperiod($newhaystack, $needle))	return TRUE;
			}
			//find things like 10(A-B)
			elseif(strlen($hays[$x])==7){
				$newhaystack = substr($hays[$x],0,4) . ")";
				if(findperiod($newhaystack, $needle))	return TRUE;
				$newhaystack = substr($hays[$x],0,3) . substr($hays[$x],5,2);
				if(findperiod($newhaystack, $needle))	return TRUE;
			}
			//find things like 6-8(A)
			elseif(strlen($hays[$x])==6 && substr($hays[$x],0,3)=="6-8"){
				$letter = substr($hays[$x],4,1);
				$newhaystack = "6(" . $letter . ")";
				if(strpos($newhaystack, $needle) !== FALSE)	return TRUE;
				$newhaystack = "7(" . $letter . ")";
				if(strpos($newhaystack, $needle) !== FALSE)	return TRUE;
				$newhaystack = "8(" . $letter . ")";
				if(strpos($newhaystack, $needle) !== FALSE)	return TRUE;
			}
		}
		return FALSE;
	}
	echo "<table class='centered'>";
	homeLogout();
	tableRowSpace();
	echo "</table>";
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    $statement = $db->prepare("SELECT * FROM student WHERE username=:username AND password=:password");
    $statement->bindValue(":username", $username);
    $statement->bindValue(":password", $password);
    $statement->execute();

    $row1 = $statement->fetch();
    echo "<center><h1>" . $row1['firstname']," ",$row1['lastname'] . "</h1></center>";
	if(!isset($_GET["Sem"]))
		$_GET["Sem"]="YR";
	?>
	<center>
	<form name='theForm' action=stusched_2BMNEW.php method=get>
	<select name='Sem' onchange='refresh()'>
		<option value="YR">Both Semesters</option>
		<option value="S1"
		
		<?php
		if ($_GET["Sem"]=="S1") echo " selected";
		?>
		>Semester 1</option>
		<option value="S2"
		<?php
		if ($_GET["Sem"]=="S2") echo " selected";
		?>
		>Semester 2</option>
	</select>
	</form>
	</center><br>
	<?PHP
	//MOVED FROM HERE TO BELOW BM
	$courses = array();

	$myfile = fopen("directory/cours.txt", "r") or die("Unable to open file!");
	$count=0;
	while(!feof($myfile)) {
		$pieces = array_pad(explode("	", fgets($myfile)),8,"	");
		if ($row1['id'] == $pieces[0]){
			$pieces[7] = addcolor($courses,$pieces);
			$count++;
			$courses = array_pad($courses, $count, $pieces);	
		}

	}
	//MOVED FROM BELOW TO HERE BM
	$yearlyDigits = substr($courses[0][6], 0, 2); // first two digits from $courses[0][6] that should represent the year. ex. 25, for the year 2015/2016 BM
	//echo "<hr>" . "$yearlyDigits" . "<br>"; //BM
	
	$term = $yearlyDigits;
	$term .= "00" ; // 00 is for yearly view. ex. for yearly view of 2015/2016 "2500". BM
	$YRTerm = $term; // reference to the year number for boolean check in line 172 BM
	$YRTerm = intval($YRTerm, 10); //makes string to int BM
	//echo "$term" . "<br>";
	if($_GET["Sem"]=="S1") {	
		$term = substr_replace($term, "1", -1); // 1 is for Semester 1 view. ex. for s1 view of 2015/2016 "2501". BM
		//echo "$term" . "<br>";
		}
	if($_GET["Sem"]=="S2") {
		$term = substr_replace($term, "2", -1);; // 2 is for semester 2 view. ex. for s2 view of 2015/2016 "2502". BM
		//echo "$term" . "<br>";
		}
	$term = intval($term, 10); // makes sting to int BM
	
	$periods = array(
	array("1(A)","2(A)","3(A)","4(A)","5(A)","6(A)","7(A)","8(A)","9(A)","10(A)"),
	array("1(B)","2(B)","3(B)","4(B)","5(B)","6(B)","7(B)","8(B)","9(B)","10(B)"),
	array("1(C)","2(C)","3(C)","4(C)","5(C)","6(C)","7(C)","8(C)","9(C)","10(C)"),
	array("1(D)","2(D)","3(D)","4(D)","5(D)","6(D)","7(D)","8(D)","9(D)","10(D)"),
	array("1(E)","2(E)","3(E)","4(E)","5(E)","6(E)","7(E)","8(E)","9(E)","10(E)"),
	array("1(F)","2(F)","3(F)","4(F)","5(F)","6(F)","7(F)","8(F)","9(F)","10(F)"),
	array("1(G)","2(G)","3(G)","4(G)","5(G)","6(G)","7(G)","8(G)","9(G)","10(G)"),
	array("1(H)","2(H)","3(H)","4(H)","5(H)","6(H)","7(H)","8(H)","9(H)","10(H)")
	);
	
	//WHERE TERM STUFF USED TO BE BEFORE MOVED UP BY BM
	
	 echo "<center><table border=1><tr><th width=3%></th><th width=9%>1</th><th width=11%>2</th><th width=9%>3</th><th width=9%>4</th>";
	echo "<th width=9%>5</th><th width=9%>6</th><th width=4%>7</th><th width=9%>8</th><th width=9%>9</th><th width=9%>10</th></tr>";
	for ($row = 0; $row < 8; $row++) {
		echo "<tr class='smaller'><td>" . chr($row+65) . "</td>";
		for ($col = 0; $col < 10; $col++) {
			echo "<td>";
			$count=0;
			for($x = 0; $x < count($courses); $x++) {
				if ((findperiod($courses[$x][5], $periods[$row][$col]) == TRUE) && ($courses[$x][6]==$term ||$courses[$x][6]==$YRTerm || $_GET["Sem"]=="YR")){ 
				//I added booleans to the second part of the condition statement, this was to check for term (selected S1, S2 or YR) and always to check YR. Removed hard coding; changed to term. BM
					if($count){echo "<hr>";}
					echo "<font color=" . $courses[$x][7] . ">" . $courses[$x][1] . "<br>" . $courses[$x][2] . " " . $courses[$x][3] . " " . $courses[$x][4] . "</font>";
					$count++;
				}
			}
			
			echo "</td>";
	}
	echo "</tr>";
}
	echo "</table></center>";
	
}
else {
    redirect("login_2.php");
}

$db = null;
dohtml_footer(true);
?>

