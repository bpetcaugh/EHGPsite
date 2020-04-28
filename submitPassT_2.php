<?php
session_start();
include 'functions_2.php';
password_protect();
admin_only();
include 'includeInc_2.php';
dohtml_header("");

$db = get_database_connection();

if (isset($_POST['newpassword']) && $_POST['newpassword'] && isset($_POST['teacherid'])) { // "$_POST['newpassword']" is extra
    //If confirmation is correct
    if ($_POST['newpassword'] == $_POST['confirmnewpassword']) {
        $query = $db->prepare("UPDATE teacher SET password=:password WHERE seq=:teacher");
        $query->bindValue(":password", md5($_POST['newpassword']));
        $query->bindValue(":teacher", $_POST['teacherid']);
        $query->execute();

        echo "<body bgcolor=#CCCCCC>";
        echo "<h1 align=center>Password Changed</h1>";
    } else {
        redirect("chgpassT_2.php");
    }
} else { //tried to submit nothing
    echo "<h1 align=center>Failed</h1>";
}
//echo <table class='centered'>
endAndBeginTable();
homeLogout();
endAndBeginTable();

$db = null;
?>
</table>
<?php
dohtml_footer(true);
?>
