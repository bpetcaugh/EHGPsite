<?php
// Code by Eric Ghildyal
session_start();
include 'functions_2.php';
include 'includeInc_2.php';
dohtml_header("Access Archives");
$db = get_database_connection();
?>
<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.action = "accessArchives_2.php";
        formObject.submit();
    }
    function send()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>
  <body>

    <?php

        //Set up heading: Date, links to HGP Home Page, EHGP, and Logout
        $date = date('Y-m-d');
        echo "<table class='centered'><tr><td>";
        echo "<h2>" . date('l', strtotime($date)) . "<br />" . $date . "</h2></td></tr>";
        homeLogout();

        echo "<form name='theForm' method='post' action='accessArchives_2.php'>
          <tr> <td> Select the archive you'd like to view: 
	<select id='date' name='date' onchange='refresh()'>";

	        $currYear = date("Y")+1; //Gets current year to compare with
    	    $headingNum = 1;
  	      $headings[0] = ""; // First option defaults to an empty option

 	       // Headings to display, counts up the years until the current year and makes them headings
 	       for($j = 2012; $j < $currYear; $j++){
  	        $headings[$headingNum] = $j;
	          $headingNum++;
	        }

 	       $isView = false;
	        if(isset($_POST['date'])){    //if page has been refreshed
  	          $isView = true;
  	      }
	
  	      //Populates the options in the <select> element
   	     for ($i = 0; $i < count($headings); $i++) {

   	       echo "<option value=" . $headings[$i];
   	       if (($isView && $_POST['date'] == $headings[$i])) {  //if refreshed
   	           echo " selected=selected";
   	           $view = $i;
   	       }
          echo ">" . $headings[$i] . "</option>";
        }
        echo "</select> </td> </tr> </form>";

        //Makes button using the selected URL
        if(isset($_POST['date'])){
	//echo $_POST['date'];
          echo '<tr class="centeredButton">
      					<td colspan="2"><a class="glossy-button blue" href="' . base_url() . $_POST['date'] . '/"> Go! </a></td>
      				</tr>';
          //makeButton("Go!", $_POST['date'] . "/");

        }
        echo "</table>";
  dohtml_footer(true);
?>
