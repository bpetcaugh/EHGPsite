<?php
session_start();
include 'functions_2.php';
password_protect("login_2.php");
$db = get_database_connection();
include 'includeInc_2.php';
dohtml_header("Student Directory");
?>
<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>
<?php
echo "<table class='centered'>";
homeLogout();
echo "</table>";

echo "<table class='centered'>";
echo "<tr><td>Search by Last Name:<form name='theForm' action='directory_2.php' method='get' onsubmit=refresh()><input type=text name=search value='";
	if (isset($_GET["search"])){echo $_GET["search"];}
	else echo "";
	echo "'><input type=submit value=Submit></form></td></tr>";
echo "</table>";

echo "<table class='centered' border=1><font color=white>";
$count = 0;
$myfile = fopen("directory/directory.txt", "r") or die("Unable to open file!");
// Output one line until end-of-file
while(!feof($myfile)) {
    if ($count==0){
        echo "<tr class='smaller'>";
    }
	$pieces = array_pad(explode(",", fgets($myfile)),20," ");
	if ($pieces[15] != 1 && $pieces[1] != " "){
    if (isset($_GET["search"])){
	if (strrpos(strtolower($pieces[1]), strtolower($_GET["search"])) !== FALSE || $_GET["search"] == ""){
		echo "<td>" . $pieces[0] . " " . $pieces[1] . "   " . $pieces[2];
        if ($pieces[18] != 1){
          echo "<br>" . $pieces[3] . " " . $pieces[4] . " " . $pieces[5];
        }
        if ($pieces[19] != 1){
		  echo "<br>" . $pieces[6] . " " . $pieces[7] . " " . $pieces[8];
        }
        if ($pieces[17] != 1){
            echo "<br>" . $pieces[9] . "<br>" . $pieces[10] . ", " . $pieces[11] . " " . $pieces[12];
        }
        if ($pieces[16] != 1){
            echo "<br>" . $pieces[14];
        }
        echo "<br>" . $pieces[13];
        echo "</td>";
        if ($count==2){
        echo "</tr>";
        $count=0;
    }
    else
        $count++;
	}
	}
	else{
        echo "<td>" . $pieces[0] . " " . $pieces[1] . "   " . $pieces[2];
        if ($pieces[18] != 1){
          echo "<br>" . $pieces[3] . " " . $pieces[4] . " " . $pieces[5];
        }
        if ($pieces[19] != 1){
		  echo "<br>" . $pieces[6] . " " . $pieces[7] . " " . $pieces[8];
        }
        if ($pieces[17] != 1){
            echo "<br>" . $pieces[9] . "<br>" . $pieces[10] . ", " . $pieces[11] . " " . $pieces[12];
        }
        if ($pieces[16] != 1){
            echo "<br>" . $pieces[14];
        }
        echo "<br>" . $pieces[13];
        echo "</td>";
        if ($count==2){
        echo "</tr>";
        $count=0;
    }
    else
        $count++;
	}
    }
}
fclose($myfile);
echo "</font></table>";
dohtml_footer(true);
?>