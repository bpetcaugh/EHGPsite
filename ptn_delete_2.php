<?php
//Created and edited by Ricky Wang
session_start();
include 'functions_2.php';
password_protect();
admin_only();
include 'includeInc_2.php';
dohtml_header("Parent Teacher Night Data Delete");
?>
<script >
	//$("#delete").click(
	function confirm_del(){ 
		if(confirm("This will DELETE All the Data of Parent Teacher Night, Are you sure?")){
		var formObject = document.forms['deleteptn'];
        formObject.submit();
	}else{ 
		return false; 
	} 
};
</script> 
<?
	//Form
	echo "<form name='deleteptn' method='post' action='submit_ptn_delete_2.php'>";
	echo "<input type='hidden' name='deleteptn1' value='true'>";
	echo "</form>";
	//Button
	echo "<table class='centered'><tr></tr><tr class='centeredButton'><td width=50%></td><td class='centered' colspan=2><a class='glossy-button blue' id='delete' href='javascript:confirm_del()'>Delete All Data</a></td><td width=50%></td></tr>";
	echo "</table>";
	
	dohtml_footer(true);
?>