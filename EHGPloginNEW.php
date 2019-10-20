
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
            <title>Login</title>
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
                }
            </script>
            <link rel="stylesheet" type="text/css" href="css_2.css" />
            <link rel="stylesheet" href="css_2-print.css" type="text/css" media="print">
        </head>

        <body>
                
               <center><p></p><img src="logo.png" class="headerMap" usemap="#headermap" alt="Holy Ghost Prep"/><p></p>
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
        
           <h1 class='centered'>Login</h1>    <html>
<head>
<link rel="stylesheet" type="text/css" href="css_2.css" />
</head>
<body bgcolor=#CCCCCC>
       	 <form action=login_2.php?announcement=' ' method='post' name='theForm'>
                        <!--Username: <input type='text' name='username' /><br>change made here 10-03-13//--> 
            Username: <input type='text' name='username' onChange="javascript:this.value=this.value.toLowerCase();"/><br><!--change made here 10-03-13//--> 
            Password: <input type='password' name='password' /><br>
            <input type=submit name=submit value=Login>
<p></p>

<form action='http://cs.holyghostprep.org/students/nmadaio/EHGPNEW/EHGPhome.php' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Home'></form>
	</body>
</html>