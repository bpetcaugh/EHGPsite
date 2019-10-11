<?php

    session_start();

//  require 'connect.php';
    require 'functions_2.php';

    $db = get_database_connection();

    $myId=$_POST['id'];

//    $myId = stripslashes($myId);
//    $myId = mysqli_real_escape_string($conn, $myId);

    if(isset($_SESSION["isTeacher"]) && $_SESSION["isTeacher"] == true){

    try{
        if(isset($myId)){
            $sql = "DELETE FROM announcements WHERE id=:myId";
            $query = $db->prepare($sql);
            $query->bindValue(":myId", $myId);
            //$query->execute();
            //$conn->query($sql);
            
            //Show alert
            if ($query->execute()){
                $_SESSION['alert'] = "remove";
            }else{
                $_SESSION['alert'] = "removeFail";
            }
            
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }catch(PDOException $e){
            //Show alert
            $_SESSION['alert'] = "removeFail";
    }
        
    }else{
        //Show alert
        $_SESSION['alert'] = "hack";
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    $conn->close();

 ?>
