<?php
//Much of original code by Liam Cain. Updated and edited by Fred Kummer
session_start();
include 'functions_2.php';
//From regular functions.
password_protect();
include 'includeInc_2.php';

?>

<script>
	//Edited for redesign by Fred Kummer
	function refresh(){
		var formObject = document.forms['theForm'];
		formObject.submit();
	}
</script>

<?php
	$rows = get_teachers();
	$seq = 0;//added mmm
	$seqid = 0;//added mmm
	$seqs = 0;//added mmm
	$db = get_database_connection();
	foreach ($rows as $row) {
		$name = $row['name'];
		$id = $row['id'];
		$seq = $seq + 1; 
		$query = $db->prepare("UPDATE teacher SET seq=:seq WHERE name=:name");
		$query->bindValue(":seq",$seq);
		$query->bindValue(":name",$name);
		$query->execute();
		echo $name . " " . $id . " has a sequence of " . $seq . " done <br/>";
		//added mmm
	//	if ($seq == $teacher) {//mmm  adjustment to make teacher id coordinate to sequence id???
	//		$seqs = $id;
	//		$seqid = 0 + $id + $seq;
	//	}
	}
	 foreach ($rows as $row) {
	 	echo $row['name']. "<br />";
	 }
	 $db=null;

function get_teachers(){
	$db = get_database_connection();
    //$statement = $db->prepare("SELECT name, id FROM teacher");
    $statement = $db->prepare("SELECT * FROM teacher WHERE isptn=1 ORDER BY last, first");
    $statement->execute();
	$db= null;
	return $statement->fetchAll();
}
?>