<!--
session_start(); 
$servername = "localhost";
$username = "ehgp_user";
$password = "ehgp_password";

$conn = mysqli_connect($servername, $username, $password); 

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error()); 
}
echo "Connected successfully"; 

if (isset($_POST['password'])) {
	if (login($_POST['username'], ($_POST['password'])))
}

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<---- Include the above in your HEAD tag ---------->

<!--Mr. Petcaugh please note that this page is from what Chris Gannon posted before on discord -->
<!--However I did change quite a bit ie the video background, the firebird logo, and functional links in the navbar -->

<?php
//PHP section was edited by Christian Kardish (source file: login_2.php)

//session_start();
$_SESSION = array();
//session_regenerate_id();
//if (isset(session_id()) && session_id!="") { session_destroy();} //added these three lines in case somebody didnt logout
session_start();

include 'functions_2.php';

$db = get_database_connection();

if (isset($_POST['password'])) {
    if (login($_POST['username'], md5($_POST['password']))) {
        if ($_GET['announcement'] == 1) {
            redirect("addannouncement_2.php");
        } else if ($_GET['scheduleRoom'] == 1) {
            redirect("scheduleRoom_2.php");
        } else if ($_GET['scheduleMeeting'] == 1) {
            redirect("scheduleMeeting_2.php");
        } else if ($_GET['absentee'] == 1) {
            redirect("addabsentee_2.php");
        } else if ($_GET['absentee'] == 2) {
            redirect("viewabsentee_2.php");
        } else if ($_GET['lockdown'] == 1) {
            redirect("addlockdown_2.php");
        } else if ($_GET['lockdown'] == 2) {
            redirect("viewlockdown_2.php");
        } else if ($_GET['late'] == 1) {
            redirect("addlate_2.php");
        } else if ($_GET['late'] == 2) {
            redirect("viewlate_2.php");
        } else if ($_GET['dress'] == 1) {
            redirect("adddress_2.php");
        } else if ($_GET['dress'] == 2) {
            redirect("viewdress_2.php");
        } else if ($_GET['test']) {
            redirect("test_2.php");
        } else if ($_GET['home']) {
            redirect("index_2.php");
        } else if ($_GET['calendar']) {
            redirect("addcalendar_2.php");
        } else if ($_GET['rcalendar']) {
            redirect("removecalendar_2.php");
        } else {
            $ref=@$HTTP_REFERER;
            echo $ref;
            if ($ref=="http://www.holyghostprep.org/page.cfm?p=1488") {
                redirect("/trackandfield/index.php");
            } else redirect("index_2.php");
            //http://www.plus2net.com/php_tutorial/php_referrer.php
        }
    } else {
        redirect("login_2.php?fail=1&announcement=" . $_GET['announcement'] . "&scheduleRoom=" . $_GET['scheduleRoom'] . "&absentee=" . $_GET['absentee'] . "&lockdown=" . $_GET['lockdown'] . "&late=" . $_GET['late'] . "&dress=" . $_GET['dress'] . "&test=" . $_GET['test'] . "&home=" . $_GET['home']);
    }
    
} /**else if (check_logged_in()) {
    if ($_GET['announcement'] == 1) {
        redirect("addannouncement_2.php");
    } else if ($_GET['scheduleRoom'] == 1) {
        redirect("scheduleRoom_2.php");
    } else if ($_GET['scheduleMeeting'] == 1) {
        redirect("scheduleMeeting_2.php");
    } else if ($_GET['absentee'] == 1) {
        redirect("addabsentee_2.php");
    } else if ($_GET['absentee'] == 2) {
        redirect("viewabsentee_2.php");
    } else if ($_GET['lockdown'] == 1) {
        redirect("addlockdown_2.php");
    } else if ($_GET['lockdown'] == 2) {
        redirect("viewlockdown_2.php");
    } else if ($_GET['late'] == 1) {
        redirect("addlate_2.php");
    } else if ($_GET['late'] == 2) {
        redirect("viewlate_2.php");
    } else if ($_GET['dress'] == 1) {
        redirect("adddress_2.php");
    } else if ($_GET['dress'] == 2) {
        redirect("viewdress_2.php");
    } else if ($_GET['test']) {
        redirect("test_2.php");
    } else if ($_GET['home']) {
        redirect("index_2.php");
    } else if ($_GET['calendar']) {
        redirect("addcalendar_2.php");
    } else if ($_GET['rcalendar']) {
        redirect("removecalendar_2.php");
    } else {
        $ref=@$HTTP_REFERER;
        echo $ref;
        if ($ref=="http://www.holyghostprep.org/page.cfm?p=1488") {
            redirect("/trackandfield/index.php");
        } else redirect("index_2.php");
        //http://www.plus2net.com/php_tutorial/php_referrer.php
    }
}
*/
include 'includeInc_2.php';

?>
<!DOCTYPE html>
<html>
    <style>
        body,
		html {
			margin: 0;
			padding: 0;
			height: 100%;
		}
		.user_card {
			height: 400px;
			width: 350px;
			margin-top: auto;
			margin-bottom: auto;
			background: whitesmoke;
			position: relative;
			display: flex;
			justify-content: center;
			flex-direction: column;
			padding: 10px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			-webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			-moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			border-radius: 5px;

		}
		.brand_logo_container {
			position: absolute;
			height: 170px;
			width: 170px;
			top: -75px;
			border-radius: 50%;
			background: transparent;
			padding: 10px;
			text-align: center;
		}
		.brand_logo {
			height: 150px;
			width: 150px;
			border-radius: 50%;
			border: 2px solid white;
		}
		.form_container {
			margin-top: 100px;
		}
		.login_btn {
			width: 100%;
			background: darkblue !important;
			color: white !important;
		}
		.login_btn:focus {
			box-shadow: none !important;
			outline: 0px !important;
		}
		.login_container {
			padding: 0 2rem;
		}
		.input-group-text {
			background:darkblue !important;
			color: white !important;
			border: 0 !important;
			border-radius: 0.25rem 0 0 0.25rem !important;
		}
		.input_user,
		.input_pass:focus {
			box-shadow: none !important;
			outline: 0px !important;
		}
		.custom-checkbox .custom-control-input:checked~.custom-control-label::before {
			background-color: darkblue!important;
        }
		.topnav-centered{
  		
        }
        .fullscreen-bg {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            overflow: hidden;
            z-index: -100;
            }

        .fullscreen-bg__video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        @media (min-aspect-ratio: 16/9) {
        .fullscreen-bg__video {
            height: 300%;
            top: -100%;
        }
        }

        @media (max-aspect-ratio: 16/9) {
        .fullscreen-bg__video {
        width: 300%;
        left: -100%;
        }
        }

        @media (max-width: 767px) {
        .fullscreen-bg {
        background: url('tempbackground.PNG') center center / cover no-repeat;
        }

        .fullscreen-bg__video {
        display: none;
        }
    }
    </style>
    
<head>
	<title>EHGP Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
</head>
<!--Coded with love by Mutiullah Samim-->
<header>
  <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
  <div class="topnav-centered">
      <ul class="navbar-nav mr-auto">
        <a class="navbar-brand" href="#">
            <li class="nav-item">
            <img src="./firebird.png" width="30" height="30" class="d-inline-block align-top" alt="">
            EHGP
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://www.holyghostprep.org/calendar?cal_date=2020-04-01">Calendar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://ehgp.holyghostprep.org/announcements.php">Announcements</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./BellSchedules.pdf">Bell Schedules</a>
          </li>
      </ul>
    </div>
  </nav>
</header>
<body>
    <div class="fullscreen-bg">
    <video loop muted autoplay autplay poster="tempbackground.PNG" class="fullscreen-bg__video">
        <source src="HGPDrone.webm" type="video/webm">
        <source src="mp4HGPDrone.mp4" type="video/mp4">
            <source src="ogvHGPDrone.ogv" type="video/ogg">
    </video>
    </div>

    </video>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="./firebird.png" class="brand_logo" alt="Logo">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
                <form action=testind.php?announcement=' <?php //echo $_GET['announcement'] . "&scheduleRoom=" . $_GET['scheduleRoom'] . "&scheduleMeeting=" . $_GET['scheduleMeeting'] . "&absentee=" . $_GET['absentee'] . "&lockdown=" . $_GET['lockdown'] . "&late=" . $_GET['late'] . "&dress=" . $_GET['dress'] . "&test=" . $_GET['test'] . "&home=" . $_GET['home']; ?>' method='post' name='theForm'>
                    <?php if (isset($_GET['fail'])): ?>
                        <font color=red>Login Failed</font><br>
                    <?php endif; ?>
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type=text name=username class="form-control input_user" value="" placeholder="Username">
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type=password name=password class="form-control input_pass" value="" placeholder="Password">
						</div>
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="customControlInline">
								<label class="custom-control-label" for="customControlInline">Remember me</label>
							</div>
						</div>
					</form>
				</div>
				<div class="d-flex justify-content-center mt-3 login_container">
					<button type=submit name=submit class="btn login_btn" value = Login>Login</button>
				</div>
				<div class="mt-4">
					<div class="d-flex justify-content-center links">
						<a href="#">Forgot your password?</a>
					</div>
				</div>
			</div>
		</div>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
</body>
</html>
