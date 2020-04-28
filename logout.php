<?PHP
session_start();//added 2-5
include 'functions.php';
//regenerate_session_id();//added 2-5
session_destroy(); //php function to destroy session variables

redirect(); //goes back to index page, because no page is specified!
?>