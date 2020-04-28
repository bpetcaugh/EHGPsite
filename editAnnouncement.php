<?php

    session_start();

//    require 'connect.php';
    require 'functions_2.php';

    $db = get_database_connection();

    $myId=$_POST['id'];
    $myDate=$_POST['date1'];
    $myGrade=$_POST['grade'];
    $myAnnouncement=$_POST['announcement'];
    $myFile=$_FILES["Upload"]["name"];

//    $myId = stripslashes($myId);
//    $myId = mysqli_real_escape_string($conn, $myId);
//    $myDate = stripslashes($myDate);
//    $myDate = mysqli_real_escape_string($conn, $myDate);
//    $myGrade = stripslashes($myGrade);
//    $myGrade = mysqli_real_escape_string($conn, $myGrade);
//    $myAnnouncement = stripslashes($myAnnouncement);
//    $myAnnouncement = mysqli_real_escape_string($conn, $myAnnouncement);

    $target_dir = "pictures/";

    if(isset($_SESSION["isTeacher"]) && $_SESSION["isTeacher"] == true){


    try{
        
        $sql = "SELECT * FROM announcements WHERE id=:myId";
        $query = $db->prepare($sql);
        $query->bindValue(":myId", $myId);
        $query->execute();
        //$result = $conn->query($sql);


        while ($row = $query->fetch()) {

            if($row["date"] != $myDate){
                
                $sql = "SELECT * FROM announcements WHERE date=:myDate AND announcement=:myAnnouncement AND grade=:myGrade";
                $query = $db->prepare($sql);
                $query->bindValue(":myDate", $myDate);
                $query->bindValue(":myAnnouncement", $myAnnouncement);
                $query->bindValue(":myGrade", $myGrade);
                $query->execute();
                //$result5 = $conn->query($sql5);

                if ($result->num_rows > 0){
                        //Show alert
                    $_SESSION['alert'] = "exsists";
                }else{
                    $sql = "UPDATE announcements SET date=:myDate WHERE id=:myId";
                    $query = $db->prepare($sql);
                    $query->bindValue(":myDate", $myDate);
                    $query->bindValue(":myId", $myId);
                    $query->execute();
                    //$conn->query($sql2);
                                        
                    //Show alert
                    if ($query->execute()){
                        $_SESSION['alert'] = "edit";
                    }else{
                        $_SESSION['alert'] = "editFail";
                    }
                    
                    header('Location: ' . $_SERVER['HTTP_REFERER']);

                }
                
            } 
            if ($row["grade"] != $myGrade){
                
                if ($myGrade == "All Grades"){
                    $code = 1;
                }else if ($myGrade == "Freshman-Sophomore"){
                    $code = 4;
                }else if ($myGrade == "Junior-Senior"){
                    $code = 5;
                }else if ($myGrade == "Freshman"){
                    $code = 6;
                }else if ($myGrade == "Sophomore"){
                    $code = 7;
                }else if ($myGrade == "Junior"){
                    $code = 8;
                }else if ($myGrade == "Senior"){
                    $code = 9;
                }else{
                    $code = 1;
                }
                
                $sql = "UPDATE announcements SET grade=:myGrade WHERE id=:myId";
                $query = $db->prepare($sql);
                $query->bindValue(":myGrade", $myGrade);
                $query->bindValue(":myId", $myId);
                $query->execute();
                
                $sql = "UPDATE announcements SET code=:myCode WHERE id=:myId";
                $query = $db->prepare($sql);
                $query->bindValue(":myCode", $code);
                $query->bindValue(":myId", $myId);
                //$query->execute();
                //$conn->query($sql3);
                                
                //Show alert
                if ($query->execute()){
                    $_SESSION['alert'] = "edit";
                }else{
                    $_SESSION['alert'] = "editFail";
                }
                
                header('Location: ' . $_SERVER['HTTP_REFERER']);

            } 
            if ($row["announcement"] != $myAnnouncement){
                
                    $sql = "UPDATE announcements SET announcement=:myAnnouncement WHERE id=:myId";
                    $query = $db->prepare($sql);
                    $query->bindValue(":myAnnouncement", $myAnnouncement);
                    $query->bindValue(":myId", $myId);
                    //$query->execute();
                    //$conn->query($sql4);

                    //Show alert
                    if ($query->execute()){
                        $_SESSION['alert'] = "edit";
                    }else{
                        $_SESSION['alert'] = "editFail";
                    }
                
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                
            }
            
            if($myFile != ''){
                if(strstr($myAnnouncement, 'http')){
                    preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $myAnnouncement, $match);
                    if(isset($match[0])){
                        for($x = 0; $x < count($match[0]); $x++){
                            $v1 = $match[0][$x];
                            $myAnnouncement = str_replace($v1, "", $myAnnouncement);
                        }
                    }
                            $imageFileType = strtolower(pathinfo($_FILES["Upload"]["name"],PATHINFO_EXTENSION));
                            $target_file = $target_dir . random_string() . $imageFileType;
                            $uploadOk = 1;
                            // Check if image file is a actual image or fake image
                            if(isset($_POST["submit"])) {
                                $check = getimagesize($_FILES["Upload"]["tmp_name"]);
                                if($check !== false) {
                                    $uploadOk = 1;
                                } else {
                                    $uploadOk = 0;
                                }
                            }
                            // Check if file already exists
                            if (file_exists($target_file)) {
                                $uploadOk = 0;
                            }
                            // Check file size
                            if ($_FILES["Upload"]["size"] > 2000000) {
                                $uploadOk = 0;
                            }
                            // Allow certain file formats
                            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                            && $imageFileType != "gif" ) {
                                $uploadOk = 0;
                            }
                            // Check if $uploadOk is set to 0 by an error
                            if ($uploadOk == 0) {
                                $_SESSION['alert'] = "failImage";
                            // if everything is ok, try to upload file
                            } else {
                                if (move_uploaded_file($_FILES["Upload"]["tmp_name"], $target_file)) {
                                    $myAnnouncement .= " " . base_url() . $target_file;
                            
                                    $sql = "UPDATE announcements SET announcement=:myAnnouncement WHERE id=:myId";
                                    $query = $db->prepare($sql);
                                    $query->bindValue(":myAnnouncement", $myAnnouncement);
                                    $query->bindValue(":myId", $myId);
                                    //$query->execute();
                                    //$conn->query($sql4);
                                    
                                    //Show alert
                                    if ($query->execute()){
                                        $_SESSION['alert'] = "edit";
                                    }else{
                                        $_SESSION['alert'] = "editFail";
                                    }
                                    
                                    //echo "The file ". $target_file . " has been uploaded.";
                                } else {
                                    $_SESSION['alert'] = "failImage";
                                }
                            }
                }else{
                    $imageFileType = strtolower(pathinfo($_FILES["Upload"]["name"],PATHINFO_EXTENSION));
                    $target_file = $target_dir . random_string() . $imageFileType;
                    $uploadOk = 1;
                    // Check if image file is a actual image or fake image
                    if(isset($_POST["submit"])) {
                        $check = getimagesize($_FILES["Upload"]["tmp_name"]);
                        if($check !== false) {
                            $uploadOk = 1;
                        } else {
                            $uploadOk = 0;
                        }
                    }
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        $uploadOk = 0;
                    }
                    // Check file size
                    if ($_FILES["Upload"]["size"] > 2000000) {
                        $uploadOk = 0;
                     }
                    // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                        $uploadOk = 0;
                    }
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        $_SESSION['alert'] = "failImage";
                    // if everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($_FILES["Upload"]["tmp_name"], $target_file)) {
                            $myAnnouncement .= " " . base_url() . $target_file;
                            
                            $sql = "UPDATE announcements SET announcement=:myAnnouncement WHERE id=:myId";
                            $query = $db->prepare($sql);
                            $query->bindValue(":myAnnouncement", $myAnnouncement);
                            $query->bindValue(":myId", $myId);
                            //$query->execute();
                            //$conn->query($sql4);
                            
                            //Show alert
                            if ($query->execute()){
                                $_SESSION['alert'] = "edit";
                            }else{
                                $_SESSION['alert'] = "editFail";
                            }
                                    
                            //echo "The file ". $target_file . " has been uploaded.";
                        } else {
                            $_SESSION['alert'] = "failImage";
                        }
                    }
                }
                            
            }
        }
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        
    }catch(PDOException $e){
        //Show alert
        $_SESSION['alert'] = "editFail";
    }

    }else{
        //Show alert
        $_SESSION['alert'] = "hack";
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    $conn->close();

    function random_string() {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < 50; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key .= ".";
    }  

 ?>
