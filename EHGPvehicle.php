<!DOCTYPE html>
    <html>
               <!-- Metadata -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">
        <meta name="description" content="Holy Ghost Prep Announcement Page">
        <link rel="shortcut icon" href="favicon.ico">


        <title>EHGP Home</title>
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
    </head>           <body>
                            
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
            
           <center><h1 class='centered'>Register a Vehicle or Request a Permit</h1>

    <script type='text/javascript'>

    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
        formObject.action = "parkingpermit_2.php";
    }

    //Confirms that all fields on form are filled out before submitting; alerts user if false
    function validateForm()
    {
        //var studentid=document.forms["theForm"]["studentid"].value;
        var make = document.forms["theForm"]["make"].value;
        var model = document.forms["theForm"]["model"].value;
        var year = document.forms["theForm"]["year"].value;
        var color = document.forms["theForm"]["color"].value;
        var licenseplate = document.forms["theForm"]["licenseplate"].value;
        //var email=document.forms["theForm"]["email"].value;

        var s = "";

        //Where there is a value missing, s adds onto itself that box's error message

        if (make == null || make == "")
        {
            s = s + "Car make must be filled out.\n";
        }
        if (model == null || model == "")
        {
            s = s + "Car model must be filled out.\n";
        }
        if (year == null || year == "")
        {
            s = s + "Year must be filled out.\n";
        }
        if (color == null || color == "")
        {
            s = s + "Car color must be filled out.\n";
        }
        if (licenseplate == null || licenseplate == "")
        {
            s = s + "License plate must be filled out.\n";
        }

        //If s is still blank, all boxes have been filled, and the form is submitted
        //If not, the value of s is printed in the alert box, and the form is not submitted
        if (s == "")
        {
            return true;
        } else
        {
            alert(s);
            return false;
        }
        return false;
    }

    function send()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>

<table class='centered'>

    <form id='theForm' name='theForm' onsubmit='return validateForm()' method='post' action='submitpp_2.php'>
        <!--If at least one field is blank, the form wont submit-->
        <center><tr><td>Your Student ID is 20127<br /><br /><input type=hidden name=student value=20127></td></tr><tr><td><table class='centered'><tr><td>Vehicle Make:<input type='text' name='make' value=''/></td><td>Vehicle Year:<input type='text' name='year' value=''/></td></tr><tr><td>Vehicle Model:<input type='text' name='model' value=''/></td><td>Vehicle Color:<input type='text' name='color' value=''/></td></tr><tr><td>License Plate: <input type='text' name='licenseplate' value=''></td></tr></table><br/>Current Permit Number: <input type='text' name='existingnumber' value=''><br/>Note: Leave this field blank if you do not have a current parking permit.<br /><br />Remember you must also see the Dean of Discipline with your $5 to finish this process.<br /><br />
        <input type='submit' name='submit' value='Submit' onclick='send()'/>
        <input type='button' name='cancel' value='Cancel' onclick='self.location = "viewmypermit_2.php"'/><br/><br/><br/><br/>
        </td></tr>;
    </form>
<tr class="centeredButton"><td width="50%"></td>
			
<form action='http://cs.holyghostprep.org/students/nmadaio/EHGPNEW/EHGPhome.php' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Home'></form>

<form action='http://cs.holyghostprep.org/students/nmadaio/EHGPNEW/logout_2.php' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Logout'></form>

		
		</tr>                
	<!--</tr>//-->
        <!--</table> //-->
</center>
        </body>
        </html>