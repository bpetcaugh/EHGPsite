<?php
session_start();
include 'functions.php';
password_protect();
admin_only();

$db = get_database_connection();

if (isset($_POST['newpassword']) && $_POST['newpassword']) {
    if ($_POST['newpassword'] == $_POST['confirmnewpassword']) {
        if (is_admin($_SESSION['username'],$_SESSION['password'])) {
//            if ($_SESSION['isTeacher'] && ) {
//                $query = $db->prepare("UPDATE teacher SET password=:password WHERE username=:username");
//                $query->bindValue(":password", md5($_POST['newpassword']));
//                $query->bindValue(":username", $_SESSION['username']);
//                $query->execute();
//            }else {
                $query = $db->prepare("UPDATE student SET password=:password WHERE passnameid=:passnameid");
                $query->bindValue(":password", md5($_POST['newpassword']));
                $query->bindValue(":passnameid", $_SESSION['passnameid']);
                $query->execute();
            }

            //Update the password
            //$_SESSION['password'] = md5($_POST['newpassword']);
            echo "<body bgcolor=#CCCCCC>";
            //echo $_SESSION['password'];
            echo "<h1 align=center>Password Changed</h1>";
        } else {
            redirect("chgpassS.php");
        }
    //}
} else { //tried to submit "nothing"
    echo "<body bgcolor=#CCCCCC>";
    echo "<h1 align=center>Failed</h1>";
    //echo "<center>When adding an absentee, late or dress violation you must select a student.</center>";
}
echo "<br><center><a href=index.php>Home</a></center></body>";
$db = null;
?>
