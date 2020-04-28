<?php
//edited by Vincent Pillinger
/*
Developed by Evan Hopkins and Liam Cain 2012
JQuery and CSS by Liam Cain
(3/29/12)-Original Version
*/
session_start();
include 'functions_2.php';
password_protect();
att_admin_only();//Mr. Chapman
include 'includeInc_2.php';
dohtml_header("Edit Lates");
include 'dateselectorlate_2.php';//date selection dropdown
?>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style>
	form{display:inline;}
	#sorters { text-align:center; margin-bottom:20px; line-height:2;}
	.center { text-align: center;}
	table {	border-width:1px;border-bottom-color: #999;margin: 0 auto;}
	td {padding: 0px 5px; text-align: right;}
	.check { margin-left:10px; display: inline;}
	#message {color:red; font-weight: bold;}
	#stu_search {text-align:center; color:white; display: block; line-height: 2; }
	div#footer { padding: 10px 20px; text-shadow: #202020 0 2px 0; background-color:#5e5e5e; border-radius: 5px; color: white; position: fixed; bottom: 70px; right: 2%; width: 70%; margin-left:5%; display: none; line-height:1.5; }
	div#footer::after {
	content: ""; position: absolute; bottom: -15px; right: 15px; border-width: 15px 15px 0; border-style: solid; border-color:#5e5e5e  transparent; display: block;}
	div#footer::before { content:"Instructions"; display: block; text-align: center; font-size: 16pt; border-bottom: dotted 2px;}
	.icon { position: fixed; right: 2%; bottom: 1%; background-color:#a1a1a1; text-align:center; font-size:24pt; height:40px; width:40px; -moz-border-radius: 20px; -webkit-border-radius: 20px; border-radius: 20px; color:white;}
	#print, #summary { position: fixed; right: 6.5%; bottom: 1%; line-height: 1.7; background-color:#a1a1a1; text-align:center; font-size:16pt; height:40px; width:80px; -moz-border-radius: 20px; -webkit-border-radius: 20px; border-radius: 20px; color:white;}
	#summary {right: 14%; width:100px;}
	#printDate {text-align: center; display: none;}
	tbody tr:nth-child(odd) {
	   }
	.tableborder {}
</style>
<?php 
if (isset($_POST['note']))
	edit();//update note of id
else if (isset($_POST['id']))
	remove();//remove entry of id
main();

function main(){
	//stores url (including GET vars) in pageName var
	$pageName = basename($_SERVER['PHP_SELF']);
	if (isset($_GET['date']))
		$date= $_GET['date'];
	else
		$date= date('Y-m-d');//gets date according to server
        echo "<table class='centered'>";
        homeLogout();
        echo "</table>";
	echo "<div id='sorters'>";
	dateSelectorLate($pageName);//date selection dropdown
	$data= get_data($date);
	echo "<br/>Search by Student:<form><input type='text' id='filter'/></form>
	</div>";
	echo "<h2 id='printDate'>$date</h2>";

	/*Start of student table...*/
	echo "<table id='table' border=1>
	<tr>
		<th></th>
		<th>Name</th>
		<th>Grade</th>
		<th>Teacher</th>
                <th>Period</th>
                <th>Minutes Late</th>
		<th>Note</th>
		<th></th>
	</tr>";

 //       echo "<table align=center border=1><tr><th>Student</th><th>Grade</th><th>Teacher</th><th>Period</th><th>Minutes Late</th></tr>";
 //       while ($row = $query->fetch()) {
 //           echo "<tr><td>" . $row['name'] . "</td><td>" . $row['grade'] . "</td><td>" . $row['teacher'] . "</td><td>" . $row['period'] . "</td><td>" . $row['minutes'] . "</td>";
 //           if (($_SESSION['name'] == $row['teacher']) || (is_att_admin($_SESSION['username'], $_SESSION['password'])))
 //               echo "<td><a href=viewlate_2.php?remove=" . $row['id'] . "&date=" . $date . ">Remove</a></td>";
 //           echo "</tr>";
 //       }
 //       echo "</table>";


	foreach($data as $info){
		$id=$info['id'];
		echo "<tr>";
		echo "<form method='post' action='editlate_2.php?date=$date'>
			<input type='hidden' name='id' value='" .$id. "'>
			<td><input type='submit' value='Remove' name='submit' /></td>
			</form>";
		// Rearrange name: firstname name first; lastname 3
			// if someone has III or Jr, compensates
		$name= explode(", ", $info['name']);
		//if (isset($name[2])){   //or  || $name.length())
                $displayname= (isset($name[2])) ? $name[2]." ".$name[0]." ".$name[1] :$name[1]." ".$name[0];
		echo "<td class='pname'><a class='togglename' href='javascript:void(0);'>". $displayname;
		echo "</a></td>";
		echo "<td>".$info['grade']."</td>";
		echo "<td>".$info['teacher']."</td>";
                echo "<td>".$info['period']."</td>";
                echo "<td>".$info['minutes']."</td>";
//                <td>" . $row['period'] . "</td><td>" . $row['minutes'] . "</td>"
//changed here above 9-19-12

		//htmlspecialchars filters out code injections
		echo "<td>". htmlspecialchars($info['notes'], ENT_QUOTES, 'UTF-8')."</td>";
		echo "<form method='post' action='add-notelate_2.php'>
			<input type='hidden' name='id' value='$id'>
			<input type='hidden' name='date' value='$date'>
			<td><input type='submit' value='Edit Note' name='submit' /></td></form>";
		echo "</tr>";
	}
	echo "</table>";
}
function remove(){//removes etnry in absentee database
    if (isset($_POST['id']))//extra???
        $id = $_POST['id'];//id of entry to remove
    $db = get_database_connection();
    $statement = $db->prepare("DELETE FROM late WHERE id=:id");
    $statement->bindValue(":id", $id);
    $statement->execute();
	$_POST['id']=null;//clear id
	$db= null;
}

function get_data($date){//gets entire absentee database
	$db = get_database_connection();
    $statement = $db->prepare("SELECT * FROM late WHERE date=:date ORDER BY grade, name ASC");
    $statement->bindValue(":date", $date);
    $statement->execute();
	$db= null;
	return $statement->fetchAll();
}
function edit(){//changes note in **absentee**/late database for specified id
	$note = $_POST['note'];
	$id = $_POST['id'];
	$db = get_database_connection();
    $statement = $db->prepare("UPDATE late SET notes=:note WHERE id=:id");
    $statement->bindValue(":id", $id);
	$statement->bindValue(":note", $note);
    $statement->execute();
	$_POST['note']=null;
	$_POST['id']=null;//clears id
	$db= null;
}
 ?>
 	<div id="footer">
 	 	> Select a date from the dropdown.<br/>
 	 	> Use "Search for Student" to quickly parse through the list, hiding any student that does not match the query.<br/>
 	 	> To get the entire history of a particular student, type their name in the search box and press the link that appears saying "Search for a complete history."  <br/> > Clicking on a student's name will display a list of all his absences.
 	</div>
 	<!-- Buttons at the bottom -->
 	<!--<div id="summary">Summary</div>//-->
 	<div id="print">Print</div>
 	<div class="icon">?</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

 <script>
 // when the page finishes loading
 $(document).ready(function(){

 	$(".togglename").click(function(){
 		var $q = $(this).text();
 		var $str = nameToSQL($q);
 		window.location = "stu-late_2.php?stu="+$str;
 	});

// Hides unneccessary buttons and junk when pressing print or whatever.
 	$(".icon").click(function () {
 	  $("#footer").toggle();
 	});
 	$("#print").click(function () {
 		$("select").toggle();
 		$("input").toggle();
 	  	$("#sorters").toggle();
 	  	$("#printDate").toggle();
 	  	$(".icon").toggle();
 	  	$("table, table td, table th").toggleClass("tableborder");
		var $url = window.location;
		window.print();
		window.location = $url;
 	});
// 'Unexplodes' the name: first name last, lastname first
// Compensates for people with dumb names like III or Jr.
 	function nameToSQL (name) {
 		if (name.indexOf(' ') > 0) {  //if search contains space
		   		var $temp = name.split(" ", 3);//switch firstname and lastname
		   		var $firstname;
		   		var $lastname;
		   		var $suffix;
		   		if (name.indexOf(' ') < 3) {
		   			$firstname = $temp[0]+" "+$temp[1];
		   			$lastname = $temp[2]; 
		   			$suffix = "";
		   		} else {
		   			$firstname = $temp[0];
		   			$lastname = $temp[1];
		   			$suffix = ($temp[2]) ?", "+$temp[2] :"";
		   		};
		   		return $lastname+$suffix+", "+$firstname;
		   } else {
		   		return name;
		   };
 	}

 	// JQUERY: Filters the table if the student name doesn't match the text in the input field
	 $('#filter').keyup(function() {
		   $('#message').remove();
		   $('#stu_search').remove();
		   var $q = $(this).val();
		   var $str = nameToSQL($q);

		   if ($q.length > 0) {
		   		$('#table').before("<a id='stu_search' href='stu-late_2.php?stu="+$str+"'>Click here for a complete history of lates matching:\t'"+$q+"'</a>");
		   };

		   $('#table tr:not(:first)').each(function() {
		       var $name = $(this).find(".pname").text();
		       //'gi' means ignore case
		       if ($name.search(new RegExp('(' + $q + ')', 'gi'), "<b>$1</b>") < 0) {
		       		$(this).hide();
		       } else {
		       		$(this).show();
		       };
		   });
		   if ( $("#table tr:visible").length === 1){
		   		$('#table').after("<p id='message'>No results found.</p>");
		   }
	 });
 });
 </script>
<?dohtml_footer(true);?>
