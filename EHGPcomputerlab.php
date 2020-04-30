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
            <title>Computer Lab Usage</title>
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
     

            <script type="text/javascript">
                function refresh(form)
                {
                    form.submit();
                }</script>
            <link rel="stylesheet" type="text/css" href="css_2.css" />
            <link rel="stylesheet" href="css_2-print.css" type="text/css" media="print">
        </head>
        <body>               
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

	<center><p></p><img src="logo.png" class="headerMap" usemap="#headermap" alt="Holy Ghost Prep">
          <h1 class='centered'>Computer Lab Usage</h1>    
	<form name='theForm' action=scheduleViewS_2.php method='post'><table class='centered'><tr class="centeredButton"><td width="50%"></td>
			
<form action='loader.php' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Home'></form>
<form action='logout_2.php' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Logout'></form>
						
</tr></table><table class='centered'><tr><td><h2>2019-10-22, "C" Day</h2></td></tr></table><table class='centered'><tr><td><select name='mydate' onchange='refresh()'><option value=2019-11-08>2019-11-08 H Day</option><option value=2019-11-07>2019-11-07 G Day</option><option value=2019-11-06>2019-11-06 F Day</option><option value=2019-11-05>2019-11-05 E Day</option><option value=2019-11-04>2019-11-04 D Day</option><option value=2019-11-01>2019-11-01 C Day</option><option value=2019-10-31>2019-10-31 B Day</option><option value=2019-10-30>2019-10-30 A Day</option><option value=2019-10-29>2019-10-29 H Day</option><option value=2019-10-28>2019-10-28 G Day</option><option value=2019-10-25>2019-10-25 F Day</option><option value=2019-10-24>2019-10-24 E Day</option><option value=2019-10-23>2019-10-23 D Day</option><option value=2019-10-22 selected=selected>2019-10-22 C Day</option><option value=2019-10-17>2019-10-17 B Day</option><option value=2019-10-15>2019-10-15 A Day</option><option value=2019-10-11>2019-10-11 H Day</option><option value=2019-10-10>2019-10-10 G Day</option><option value=2019-10-09>2019-10-09 F Day</option><option value=2019-10-08>2019-10-08 E Day</option><option value=2019-10-07>2019-10-07 D Day</option><option value=2019-10-04>2019-10-04 C Day</option><option value=2019-10-03>2019-10-03 B Day</option><option value=2019-10-02>2019-10-02 A Day</option><option value=2019-10-01>2019-10-01 H Day</option><option value=2019-09-30>2019-09-30 G Day</option><option value=2019-09-27>2019-09-27 F Day</option><option value=2019-09-26>2019-09-26 E Day</option><option value=2019-09-25>2019-09-25 D Day</option><option value=2019-09-24>2019-09-24 C Day</option><option value=2019-09-23>2019-09-23 B Day</option><option value=2019-09-20>2019-09-20 A Day</option><option value=2019-09-19>2019-09-19 H Day</option><option value=2019-09-18>2019-09-18 G Day</option><option value=2019-09-17>2019-09-17 F Day</option><option value=2019-09-16>2019-09-16 E Day</option><option value=2019-09-12>2019-09-12 D Day</option><option value=2019-09-11>2019-09-11 C Day</option><option value=2019-09-10>2019-09-10 B Day</option><option value=2019-09-09>2019-09-09 A Day</option><option value=2019-09-06>2019-09-06 H Day</option><option value=2019-09-05>2019-09-05 G Day</option><option value=2019-09-04>2019-09-04 F Day</option><option value=2019-09-03>2019-09-03 E Day</option><option value=2019-08-29>2019-08-29 D Day</option><option value=2019-08-28>2019-08-28 C Day</option><option value=2019-08-27>2019-08-27 B Day</option><option value=2019-08-26>2019-08-26 A Day</option></td></tr></table></form>
<p></p>
<table class='centered' border=1>
    <tr>
		<th>Period</th>
        <th>Founders 301</th>
        <th>Founders 302</th>
    </tr>
    <tr><td>Period 1</td><td>---<td>Mr. Petcaugh 24<br>
</tr><tr><td>Period 2</td><td>---<td>Mr. Petcaugh 24<br>
</tr><tr><td>Period 4</td><td>---<td>---</tr><tr>
<td>Period 5</td><td>---<td>---</tr><tr>
<td>Period 6/7</td><td>---<td>---</tr><tr>
<td>Period 7/8</td><td>---<td>---</tr><tr>
<td>Period 9</td><td>---<td>---</tr>
<tr><td>Period 10</td><td>---<td>Mr. Petcaugh 24<br></tr></table>  
       
                <!--</tr>//-->
        <!--</table> //-->
        </body>
        </html>