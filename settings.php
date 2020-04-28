<?php

    session_start();

//    require 'connect.php';
    require 'functions_2.php';

    $db = get_database_connection();

    $myDrag=$_POST['drag'];
    $myColor=$_POST['color'];
    $myDark=$_POST['dark'];
    $myTheme=$_POST['themes'];
    $myRestore=$_POST['restore'];

    try{
        
        if(isset($myDrag) && $myDrag == "on"){

            setcookie("drag", "true", time() + (86400 * 30), "/");
        }else{
            setcookie("drag", "", time() - 3600, "/");
        }

        if(isset($myColor) && $myColor != $_COOKIE["css"]){

            setcookie("color", $myColor, time() + (86400 * 30), "/");
        }
        
        if(isset($myTheme) && $myTheme == "on"){

            setcookie("theme", "true", time() + (86400 * 30), "/");
        }else{
            setcookie("theme", "false", time() + (86400 * 30), "/");
        }
        
        if(isset($myDark) && $myDark == "on"){

            setcookie("dark", "true", time() + (86400 * 30), "/");
            
            if(isset($myTheme) && $myTheme == "on"){

                setcookie("theme", "false", time() + (86400 * 30), "/");
            }
        }else{
            setcookie("dark", "", time() - 3600, "/");
        }

        if(isset($myRestore) && $myRestore == "on"){
            setcookie("drag", "", time() - 3600, "/");
            setcookie("color", "", time() - 3600, "/");
            setcookie("css", "", time() - 3600, "/");
            setcookie("dark", "", time() - 3600, "/");
            setcookie("theme", "", time() - 3600, "/");
        }

        $_SESSION['alert'] = "settings";

        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }catch(PDOException $e){
        //Show alert
        $_SESSION['alert'] = "settingsFail";

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    $conn->close();

 ?>
