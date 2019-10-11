<?php
session_start();
include 'functions_2.php';
include 'includeInc_2.php';
password_protect();
$db = get_database_connection();

$sid = $_SESSION['id'];
$statement = $db->prepare("SELECT * FROM student WHERE id=" . $sid);
$statement->execute();
$row = $statement->fetch();

$query = $db->prepare("SELECT * FROM nhstutors WHERE name='" . $_POST[$_POST['period']] . "'");
$query->execute();
$tutor = $query->fetch();

$teacheremail = substr($_POST['class1'], strpos($_POST['class1'], ";")+1);
$helpclass = substr($_POST['class1'], 0, strpos($_POST['class1'], ";"));

$headers = "From: ". $_POST['email'] . "\r\n" . "Reply-To: " . $_POST['email'] . "\r\n" . "Bcc: ngriffiths@holyghostprep.org,apollock@holyghostprep.org,jhercus@holyghostprep.org\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$to = $tutor['email'] . ", phoelzle@holyghostprep.org, " . $teacheremail;
$subject = "You have been requested to tutor " . $row['lastname'] . ", " . $row['firstname'];
$message    = "<strong>You have been requested to tutor " . $row['firstname'] . " " . $row['lastname'] . "</strong><br>";
$message 	= $message . "\r\n\r\nClass: " . $helpclass . "<br>";
$message    = $message . "\r\n\r\nHe needs help with:\r\n" . $_POST['desc'] . "<br>";
$message    = $message . "\r\n\r\n<strong>He wants to meet: " . $_POST['period'] . "</strong><br>";
$message    = $message . "\r\n\r\nYou must reply all to this email to let the student know that you received his request and to meet at the front table in the library during the requested period.<br>";
$message    = $message . "\r\n\r\n<strong>Tutor: You must complete the <a href='https://docs.google.com/forms/d/e/1FAIpQLSfZD3hPJB1z39d1MKtESXYQAgMwX670GPLuu1oo63BK_ram2g/viewform?usp=sf_link'>Tutor Feedback Form</a> within 24 hours of the tutoring session.</strong><br>";
$message    = $message . "\r\n\r\n<strong>Student: You must complete the <a href='https://docs.google.com/forms/d/e/1FAIpQLSedLHl3IEM0OS2I-AfO4qtK2XDR1KmpGlt0P9lqQvkM9uCdcQ/viewform'>Student Feedback Form</a> within 24 hours of the tutoring session.</strong><br>";
$message    = $message . "\r\n\r\nIf you are unable to tutor the student because you don't feel confident with the subject/topic or are unavailable, you must find a replacement tutor and notify Mr. Hoelzle.";
mail($to, $subject, $message, $headers);


$db = null;
dohtml_header("Thank you.<br>" . $_POST[$_POST['period']] . " will contact you shortly.");
echo "<table class='centered'>";
homeLogout();
echo "</table>";
dohtml_footer(true);
?>