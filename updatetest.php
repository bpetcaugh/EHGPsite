<?PHP
include 'functions.php';
$db=get_database_connection();

$query=$db->prepare("UPDATE service SET role='B' WHERE id=50");
$query->execute();
 
?>
