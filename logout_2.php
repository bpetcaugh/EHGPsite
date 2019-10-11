<?PHP
//Edited by Christian Kardish

session_start();//added 2-5
include 'functions_2.php';
//regenerate_session_id();//added 2-5
session_destroy(); //php function to destroy session variables

redirect("index_2.php"); //goes back to index page, because no page is specified!
?>