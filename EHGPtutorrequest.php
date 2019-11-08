<!DOCTYPE html>
    <html>
               <!-- Metadata -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">
        <meta name="description" content="Holy Ghost Prep Tutor Page">
        <link rel="shortcut icon" href="favicon.ico">


        <title>EHGP Tutoring</title>
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
    </head>        <body>
                    
		<center><p></p><img src="logo.png" class="headerMap" usemap="#headermap" alt="Holy Ghost Prep"/></center>
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
	<!--<tr>
            <td></td>
            <td></td>
        </tr>-->
    </table>
        s
           <center><h1 class='centered'>Request an NHS Tutor</h1>    <script type='text/javascript'>

    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
        formObject.action = "NHSTutorSubmit_2.php";
    }

    //Confirms that all fields on form are filled out before submitting; alerts user if false
    function validateForm()
    {
        var email = document.forms["theForm"]["email"].value;
		var class1 = document.forms["theForm"]["class1"].value;
		var desc = document.forms["theForm"]["desc"].value;
		var period = document.forms["theForm"]["period"].value;
        

        var s = "";

        //Where there is a value missing, s adds onto itself that box's error message

        if (class1 == null || class1 == "0")
        {
            s = s + "Class must be filled out.\n";
        }
		if (desc == null || desc == "")
        {
            s = s + "Description must be filled out.\n";
        }
		if (email == null || email == "")
        {
            s = s + "Email must be filled out.\n";
        }
		if (period == null || period == "")
        {
            s = s + "You must select a period.\n";
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

    <form id='theForm' name='theForm' onsubmit='return validateForm()' method='post' action='NHSTutorSubmit_2.php'>
        <!--If at least one field is blank, the form won't submit-->
        <tr><td>Your Student ID is 20127<br /><br /><input type=hidden name=student value=20127></td></tr><tr><td><table class='centered'><tr><td>What class do you need help with?<select name=class1><option value=0>Select a Class</option><option value='AP Calc AB Colapinto;jcolapinto@holyghostprep.org
'>AP Calc AB</option><option value='CmpSc AdvTop Petcaugh;
'>CmpSc AdvTop</option><option value='Engineering I Bushek;
'>Engineering I</option><option value='AP Comp Sci Principles Petcaugh;
'>AP Comp Sci Principles</option><option value='Jazz Band Vilsmeier;bvilsmeier@holyghostprep.org
'>Jazz Band</option><option value='Wld Lt I Hon Goulet;jgoulet@holyghostprep.org
'>Wld Lt I Hon</option><option value='Question of God Nunez;tnunez@holyghostprep.org
'>Question of God</option><option value='Col Guid Sr Iuliano;kiuliano@holyghostprep.org
'>Col Guid Sr</option><option value='Wld Lt II Hon Goulet;jgoulet@holyghostprep.org
'>Wld Lt II Hon</option><option value='Soc Just Nunez;tnunez@holyghostprep.org
'>Soc Just</option></select></td></tr><tr><td>Describe what you need help with:</td></tr><tr><td><textarea rows=4 cols=50 name=desc></textarea></td></tr><tr><td>Enter your email: <input type='email' name='email'></td></tr><tr><td><br>Please select which period and tutor you would like to meet with:<br></td></tr><tr><td><table class='centered' border=1><tr><td>Thursday (2019-11-07)<br>G Day<br><input type=radio name=period value='G3'>Period 3 NHS tutor not available.<br><input type=radio name=period value='G9'>Period 9 <select name=G9><option value='Dan Behr*'>Dan Behr*</option><option value='Mitchell Feyl***'>Mitchell Feyl***</option><option value='Sean Parsons*'>Sean Parsons*</option><option value='Zachary Posivak'>Zachary Posivak</option><option value='Joe Dryden'>Joe Dryden</option><option value='Jack Nycz'>Jack Nycz</option><option value='Brendan McManus'>Brendan McManus</option><option value='Nicholas Madaio***'>Nicholas Madaio***</option><option value='Krishna Mysore*'>Krishna Mysore*</option><option value='Aidan Bell'>Aidan Bell</option><option value='Jack Erickson***'>Jack Erickson***</option></select><br></td><td>Friday (2019-11-08)<br>H Day<br><input type=radio name=period value='H3'>Period 3 NHS tutor not available.<br></td><td>Monday (2019-11-11)<br>A Day<br><input type=radio name=period value='A3'>Period 3 NHS tutor not available.<br></td></tr></table><tr><td>* - Spanish Tutors<br>** - French Tutors<br>*** - Latin Tutors</td></tr></table>		<br>
        <input type='submit' name='submit' value='Submit' onclick='send()'/>
        <input type='button' name='cancel' value='Cancel' onclick='self.location = "login_2.php"'/><br/><br/><br/><br/>
        </td></tr>
    </form>
<tr class="centeredButton"><td width="50%"></td>
			
<form action='http://cs.holyghostprep.org/students/nmadaio/EHGPNEW/EHGPhome.php' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Home'></form>

			<td width="50%"></td>
			
		</tr>
		<tr class="centeredButton"><td width="50%"></td>

<form action='http://cs.holyghostprep.org/students/nmadaio/EHGPNEW/logout_2.php' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Logout'></form>

			<td width="50%"></td>
			
		</tr></table>  </center>
                        <!--</tr>//-->
        <!--</table> //-->
        </body>
        </html>