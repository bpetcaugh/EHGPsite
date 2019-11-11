
<!DOCTYPE html>
    <html>
               <!-- Metadata -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">
        <meta name="description" content="Holy Ghost Prep Vehicle Page">
        <link rel="shortcut icon" href="favicon.ico">


        <title>EHGP Vehicle</title>
	<head>
        <!-- JQuery and AJAX -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <!-- Our Custom JS -->
        <script src="textSearcher.js" charset="utf-8"></script>
        <script src="main_functions.js" charset="utf-8"></script>
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!-- JS to set body HEX color as a cookie -->
        <script>
            function rgb2hex(rgb){
             rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
             return (rgb && rgb.length === 4) ? "#" +
              ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
              ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
              ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
            }

            $(document).ready(function(){
                let color = $("body").css("background-color");
                document.getElementById("settings-bg-color").value = rgb2hex(color);
                var domain = window.location.host.split(/\.(.+)/)[1];
                document.cookie = "css=" + rgb2hex(color) + "; path=/; domain=" + domain;
            });
        </script>
        <link rel="stylesheet" href="themes/main.css">
		<link rel="stylesheet" href="themes/style.css" type="text/css">
    </head>                
        <body>
                
             <center><p></p><img src="logo.png" class="headerMap" usemap="#headermap" alt="Holy Ghost Prep"/><center>
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
                            </td>
            <td></td>
        </tr>-->
    </table>
        
           <h1 class='centered'>EHGP SERVICE</h1>   

	<table class = 'centered'><tr class='centered'><td></td><td><h3 class='centered'>Welcome</h3></td><td></td></tr></table><table class='centered'><tr><td height="20px"></td></tr>            </table><table class = 'centered'>
            <tr>
	    <h5 class = 'centerWhite'>ALL service should be reported below, even service done through a school sponsored function.
                For school sponsored functions, such as the Cares Walk, the sponsoring teacher will verify your service, so
                no Service Verification Form is needed to be turned in to Mr. Whartenby. ALL other service reported online
                must also have a Service Verification Form turned in to Mr. Whartenby to verify the service performed.</h5></tr>
<p></p>
            <tr class="twoCenteredButtons">
			
			<form action='http://cs.holyghostprep.org/students/nmadaio/EHGPNEW/serviceReportPageS_2.php' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Report Service'></form>
			<form action='http://cs.holyghostprep.org/students/nmadaio/EHGPNEW/servindstuaS_2.php' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='View All Reported Service'></form>
<p></p>
		
		</tr><tr class="twoCenteredButtons">
			
			<form action='http://cs.holyghostprep.org/students/nmadaio/EHGPNEW/servindstuvS_2.php' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='View All Verified Service'></form>
			<form action='http://cs.holyghostprep.org/students/nmadaio/EHGPNEW/servindsturS_2.php' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='View Rejected Service'></form>
<p></p>

		</tr><tr class="twoCenteredButtons">
			<form action='http://www.holyghostprep.org/uploaded/documents/Service_Documents/CSPVerify.pdf' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Service Verification Form'></form>
			<form action='http://www.holyghostprep.org/uploaded/documents/Service_Documents/ServiceWebsites.pdf' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Service Site Links'></form>
<p></p>
		</tr><tr class="twoCenteredButtons">
			<form action='http://www.holyghostprep.org/page.cfm?p=2492' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Service Oppertunities'></form>
			<form action='href="http://www.holyghostprep.org/uploaded/documents/Service_Documents/CSPbro0809.pdf' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Service Handbook'></form>
<p></p>
		</tr><tr class="centeredButton">
			<form action='http://www.holyghostprep.org/page.cfm?p=298' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Service Home Page'></form>
			<form action='http://www.holyghostprep.org/page.cfm?p=2492' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Service Oppertunities'></form>
<p></p>
				</tr><tr><td height="20px"></td></tr></table><table class="centered"><tr class="centeredButton">
					
			<form action='http://cs.holyghostprep.org/students/nmadaio/EHGPNEW/EHGPhome.php' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Home'></form>
			<form action='http://cs.holyghostprep.org/students/nmadaio/EHGPNEW/logout_2.php' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Logout'></form>
</table>  
                <!--</tr>//-->
        <!--</table> //-->
        </body>
        </html>