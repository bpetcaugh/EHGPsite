<?php
function dohtml_header($title) {
    ?>
	<!DOCTYPE html>
    <html>
        <!-- holyghostprep.org/ehgp -->

        <!--[if lt IE 7]> <html class="no-js ie6 ie" lang="en"> <![endif]-->
        <!--[if IE 7]>    <html class="no-js ie7 ie" lang="en"> <![endif]-->
        <!--[if IE 8]>    <html class="no-js ie8 ie" lang="en"> <![endif]-->
        <!--[if IE 9 ]>   <html class="no-js ie9 ie" lang="en"> <![endif]-->
        <!--[if gt IE 9]> <html class="no-js" lang="en"> <![endif]-->
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
            <title><?php echo "$title"; ?></title>
            <style type="text/css">
                @import url(css_2.css);
            </style>    

            <script type="text/javascript">
                function refresh(form)
                {
                    form.submit();
                }
            </script>
            <link rel="stylesheet" type="text/css" href="css_2.css" />
            <link rel="stylesheet" href="css_2-print.css" type="text/css" media="print">
        </head>
        <body>
            <table class='centered'>
                <tr>
                    <td class='headerLeft'> 
                    </td>
                    <td class='headerCenter'>
                
                    <img src="Header1.jpg" class="headerMap" usemap="#headermap" alt="Holy Ghost Prep"/>
                    <!--<map name="headermap">
                        <area shape="rect" coords="225,34,615,123" href="http://www.holyghostprep.org" alt="HGP Home" />
                        <area shape="circle" coords="161,70,65" href="http://www.holyghostprep.org" alt="HGP Home" /> 

                        <area shape="rect" coords="695,9,788,24" href="http://www.holyghostprep.org/page.cfm?p=317" alt="News And Events" />
                        <area shape="rect" coords="815,9,909,24" href="http://www.holyghostprep.org/page.cfm?p=76" alt="Donate to HGP" />
                        <area shape="rect" coords="931,9,988,24" href="http://www.holyghostprep.org/page.cfm?p=299" alt="Calender" />

                        <area shape="rect" coords="644,125,715,144" href="http://www.holyghostprep.org/page.cfm?p=2" alt="About HGP" />
                        <area shape="rect" coords="740,125,808,144" href="http://www.holyghostprep.org/page.cfm?p=3" alt="Academics" />
                        <area shape="rect" coords="837,125,906,144" href="http://www.holyghostprep.org/page.cfm?p=4" alt="Admissions" />
                        <area shape="rect" coords="933,125,1008,144" href="http://www.holyghostprep.org/page.cfm?p=7" alt="Campus Life" />
                        <area shape="rect" coords="1028,125,1135,144" href="http://www.holyghostprep.org/page.cfm?p=5" alt="Alunmi & Parents" />
                    </map> -->
            </td>
            
            <td class='headerRight'></td>
        </tr>
		<!--<tr>
            <td></td>
            <td class="centered">
                <?php
                //echo"<h1 align='center'>$title</h1>"
                ?>
            </td>
            <td></td>
        </tr>-->
    </table>
        
          <?php echo" <h1 class='centered'>$title</h1>"
                  ?>
    <?php
    
}

function dohtml_footer($shouldi) {
    if ($shouldi) {
        ?>  
        <h6 class="centerWhite">EHGP Redesign by Robert Conway '13, Computer Science Advanced Topics Honors (CSATH) Class<br />
                With artistic advice from Mrs. Karen O'Brien Smallen, HGP Art Teacher,  and coding work by other CSATH Class members<br/>
				Vincent Pillinger '13, Frederick Kummer '13, and Christian Kardish '14, with advice and direction from <br />
                Mr. Michael Jacobs '01, Director of Technology, and Mr. Michael M. Meistering, Computer Science Teacher</h6>
        <?php
        // } else {
        ?>
        <!--</tr>//-->
        <!--</table> //-->
        </body>
        </html>
        <?php
    }
}

function homeLogout(){
	echo '<tr class="centeredButton"><td width="50%"></td>
			
			<td class="centered" colspan=2><a class="glossy-button blue" href="index_2.php">Home</a></td>
			<td width="50%"></td>
			
		</tr>
		<tr class="centeredButton"><td width="50%"></td>
			
			<td class="centered" colspan=2><a class="glossy-button blue" href="logout_2.php">Logout</a></td>
			<td width="50%"></td>
			
		</tr>';
		
}

function homeLogoutService(){
	echo '<tr class="centeredButton"><td width="50%"></td>
			
			<td class="centered" colspan=2><a class="glossy-button blue" href="indexService_2.php">Service Home</a></td>
			<td width="50%"></td>
			
		</tr><tr class="centeredButton"><td width="50%"></td>
			
			<td class="centered" colspan=2><a class="glossy-button blue" href="index_2.php">Main Index Home</a></td>
			<td width="50%"></td>
			
		</tr>
		<tr class="centeredButton"><td width="50%"></td>
			
			<td class="centered" colspan=2><a class="glossy-button blue" href="logout_2.php">Logout</a></td>
			<td width="50%"></td>
			
		</tr>';
		
}

function homeLogoutAdminTools(){
	echo '<tr class="centeredButton"><td width="50%"></td>
			
			<td class="centered" colspan=2><a class="glossy-button blue" href="indexAdmin_2.php">Administrator Tools Home</a></td>
			<td width="50%"></td>
			
		</tr><tr class="centeredButton"><td width="50%"></td>
			
			<td class="centered" colspan=2><a class="glossy-button blue" href="index_2.php">Main Index Home</a></td>
			<td width="50%"></td>
			
		</tr>
		<tr class="centeredButton"><td width="50%"></td>
			
			<td class="centered" colspan=2><a class="glossy-button blue" href="logout_2.php">Logout</a></td>
			<td width="50%"></td>
			
		</tr>';
		
}

function centerText($message){
		echo '<tr class="centeredButton"><td width="50%"></td>
			<td class="centered" width="1%">'.$message.'</td>
			<td width="50%"></td>
		</tr>';
}

//<tr class="centeredButton">
//                <td colspan="2"><a class="glossy-button blue" href=chgpass_2.php>Change Password</a></td>
// </tr>
/*
		echo '<tr class="centeredButton"><td width="50%"></td>
			
			<td class="centered"><a class="glossy-button blue" href="' . $link . '">'.$message.'</a></td>
			<td width="50%"></td>
			
		</tr>';
*/

function makeButton($message, $link){
		echo '<tr class="centeredButton">
					<td colspan="2"><a class="glossy-button blue" href="' . $link . '">'.$message.'</a></td>
				</tr>';
}

//<tr class="twoCenteredButtons">
//                <td ><a class="glossy-button blue" href="login_2.php?dress=1"><span>Add Dress Violation</span></a></td>
//               <td ><a class="glossy-button blue" href="viewdress_2.php"><span>View Dress Violations</span></a></td>
//</tr>

/*echo '<tr class="twoCenteredButtons"><td width="50%"></td>
			
			<td class="centered" >
				<table class="centered">
					<tr>
						<td><a class="glossy-button blue" href="' . $link . '">'.$message.'</a></td>
						<td><a class="glossy-button blue" href="' . $link2 . '">'.$mess2.'</a></td>
					</tr>
				</table>
			</td>			
			<td width="50%"></td>
			
		</tr>';
*/
function makeTwoButtons($message, $link, $mess2, $link2){
		echo '<tr class="twoCenteredButtons">
			
						<td><a class="glossy-button blue" href="' . $link . '">'.$message.'</a></td>
						<td><a class="glossy-button blue" href="' . $link2 . '">'.$mess2.'</a></td>
			
		</tr>';
}

function tableRowSpace(){
	echo '<tr><td height="20px"></td></tr>';
}

function endAndBeginTable(){
	echo '</table><table class="centered">';
}

function insertInRow($row){
	echo "<tr><td>" . $row . "</td></tr>";
}

?>