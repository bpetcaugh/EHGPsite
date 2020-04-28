<?php

session_start();

    //Change background color
    if(isset($_COOKIE["color"])){
        echo "<style>
        body{background: " . $_COOKIE["color"] . " !important;}
        </style>";
    }

    //Set themes
    if($_COOKIE["dark"] == "true"){
        echo '<link rel="stylesheet" href="themes/dark.css" type="text/css">';
    }else if(($_COOKIE["theme"] == "true" || $_COOKIE["theme"] == "") && date('m') == '2' && !isset($_COOKIE["color"])){
        echo '<link rel="stylesheet" href="themes/februaryStyle.css" type="text/css">';
        echo '<script src="themes/holiday.js" charset="utf-8"></script>';
    }else if(($_COOKIE["theme"] == "true" || $_COOKIE["theme"] == "") && date('m') == '4' && date('d') == '1' && !isset($_COOKIE["color"])){
        echo '<link rel="stylesheet" href="themes/aprilFirst.css" type="text/css">';
    }else if(($_COOKIE["theme"] == "true" || $_COOKIE["theme"] == "") && date('m') == '11' && !isset($_COOKIE["color"])){
        echo '<script src="http://cdn.rawgit.com/zachstronaut/rotate3Di/master/rotate3Di.js" type="text/javascript"></script>';
        echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.2/TweenMax.min.js' charset='utf-8'></script>";
        echo '<script src="themes/holiday.js" charset="utf-8"></script>';
        echo '<link rel="stylesheet" href="themes/novemberStyle.css" type="text/css">';
    }else if(($_COOKIE["theme"] == "true" || $_COOKIE["theme"] == "") && date('m') == '12' && !isset($_COOKIE["color"])){
        echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.2/TweenMax.min.js' charset='utf-8'></script>";
        echo '<link rel="stylesheet" href="themes/decemberStyle.css" type="text/css">';
        echo '<script src="themes/holiday.js" charset="utf-8"></script>';
    }else{
        echo '<link rel="stylesheet" href="themes/style.css" type="text/css">';
    }

//Alerts to show
function getAlert(){
    if($_SESSION['alert'] == "add"){
        $_SESSION['alert'] = "none";
        echo "<div class='alert alert-success alert-dismissible fade show' id='display' role='alert'>";
        echo "<strong>Success!</strong> Announcement added to the database.";
        echo "</div>";
    }else if($_SESSION['alert'] == "failAdd"){
        $_SESSION['alert'] = "none";
        echo "<div class='alert alert-warning alert-dismissible fade show' id='display' role='alert'>";
        echo "<strong>Warning!</strong> Announcement could not be added to the database. Please try again.";
        echo "</div>";
    }else if($_SESSION['alert'] == "exsists"){
        $_SESSION['alert'] = "none";
        echo "<div class='alert alert-warning alert-dismissible fade show' id='display' role='alert'>";
        echo "<strong>Warning!</strong> Announcement already exsists for the selected day. Please try again.";
        echo "</div>";
    }else if($_SESSION['alert'] == "remove"){
        $_SESSION['alert'] = "none";
        echo "<div class='alert alert-success alert-dismissible fade show' id='display' role='alert'>";
        echo "<strong>Success!</strong> Announcement removed from the database.";
        echo "</div>";
    }else if($_SESSION['alert'] == "removeFail"){
        $_SESSION['alert'] = "none";
        echo "<div class='alert alert-warning alert-dismissible fade show' id='display' role='alert'>";
        echo "<strong>Warning!</strong> Announcement could not be removed from the database. Please try again.";
        echo "</div>";
    }else if($_SESSION['alert'] == "edit"){
        $_SESSION['alert'] = "none";
        echo "<div class='alert alert-success alert-dismissible fade show' id='display' role='alert'>";
        echo "<strong>Success!</strong> Announcement edited in the database.";
        echo "</div>";
    }else if($_SESSION['alert'] == "hack"){
        $_SESSION['alert'] = "none";
        echo "<div class='alert alert-danger alert-dismissible fade show' id='display' role='alert'>";
        echo "<strong>Warning!</strong> Please stop trying to hack the Announcements. Just stop now, you can't.";
        echo "</div>";
    }else if($_SESSION['alert'] == "feedback"){
        $_SESSION['alert'] = "none";
        echo "<div class='alert alert-success alert-dismissible fade show' id='display' role='alert'>";
        echo "<strong>Success!</strong> Feedback submitted, thank you!";
        echo "</div>";
    }else if($_SESSION['alert'] == "submitFail"){
        $_SESSION['alert'] = "none";
        echo "<div class='alert alert-warning alert-dismissible fade show' id='display' role='alert'>";
        echo "<strong>Warning!</strong> Feedback could not be submitted. Please try again.";
        echo "</div>";
    }else if($_SESSION['alert'] == "settings"){
        $_SESSION['alert'] = "none";
        echo "<div class='alert alert-success alert-dismissible fade show' id='display' role='alert'>";
        echo "<strong>Success!</strong> Settings changed and updated.";
        echo "</div>";
    }else if($_SESSION['alert'] == "settingsFail"){
        $_SESSION['alert'] = "none";
        echo "<div class='alert alert-warning alert-dismissible fade show' id='display' role='alert'>";
        echo "<strong>Warning!</strong> Settings could not be changed. Please try again.";
        echo "</div>";
    }

}

?>
