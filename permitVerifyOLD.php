<?php
session_start();
include 'functions.php';
att_admin_only();
password_protect();
$db = get_database_connection();

    $verified = 0;  
    $pcheck = $db->prepare("SELECT * FROM parkingpermit WHERE verified = :verified ORDER by studentid"); //get all unverified
    $pcheck->bindvalue(":verified", $verified);
    $pcheck->execute();
    $result = $pcheck->fetchAll();


?>

    <html>
<head>
    <script type='text/javascript'>
        function refresh()
        {
            var formObject = document.forms['theForm'];
            formObject.action="permitVerify.php";
            formObject.submit();
        }

        function send()
        {
            var formObject = document.forms['theForm'];
            formObject.submit();
        }

        </script>
    <title>Permit Verification</title>
</head>
<body bgcolor=#CCCCCC>
    <br>

<?php       		//Set up heading: Date, links to HGP Home Page, EHGP, and Logout
    				$date = date('Y-m-d');
                    echo "<h2 align=center>" . date('l', strtotime($date)) . "<br>" . $date . "</h2>";
                    echo "<center><a href=http://www.holyghostprep.org>Holy Ghost Prep Home Page</a></center>";
                    echo "<center>&nbsp&nbsp<a href=index.php>EHGP Home</a></center>";
                    echo "<center>&nbsp&nbsp<a href=logout.php>Logout</a></center><br><br>";
                    echo "";
?>
    <br/>
    <table align=center><td>
        <form name='theForm' method='post' action='permitVerify.php'>

    <br/>
    <br/>
        <table id ="permits" align=center border=1><tr><th>First Name</th><th>Last Name</th><th>Make</th><th>Model</th><th>Year</th><th>Color</th><th>Licenseplate</th><th>Permit Number</th></tr>

        
<?php
    $i = 0;
    
    if (isset($_POST['submit']) && ($_POST['submit'])) { //check to see if anything was changed
        $_POST['submit'] = NULL;
        
        foreach ($result as $row){
            $id = $row['id'];

            //checks to see if the permitnumber was updated, if not use the old number
            if (($_POST["pnumber" . $i .""])!=NULL){
                $permitnumber = ($_POST["pnumber" . $i . ""]);  
            }else{
                $permitnumber = $row['permitnumber'];
            } 

            $sql = "UPDATE parkingpermit SET permitnumber=:permitnumber WHERE id=:id";
            $pupdate = $db->prepare($sql);
            $pupdate->bindValue(":permitnumber", $permitnumber);
            $pupdate->bindValue(":id", $id);
            $pupdate->execute();


            //checks to see if it was verified, if not make it unverified (keep it the same)
            if (($_POST["pverified" . $i . ""])!=NULL){
                $verified = ($_POST["pverified" . $i . ""]);  
            }else{
                $verified = 0;
            }

            $sql2 = "UPDATE parkingpermit SET verified=:verified WHERE id=:id";
            $pupdate = $db->prepare($sql2);
            $pupdate->bindValue(":verified", $verified);
            $pupdate->bindValue(":id", $id);
            $pupdate->execute();

            $i++;
        }?>
    
    <script> refresh(); </script>

<?php

    }

    $i = 0;

    foreach ($result as $row){

    $sid = $row['studentid'];
    $teacher = false;
    
    //checks to see if it is a teacher
    /*if (is_teacher_id($sid)){
        $statement0 = $db->prepare("SELECT * FROM teacher WHERE id=:id");
        $statement0->bindValue(":id", $sid);
        $statement0->execute();
        $teacher = true; */
        $statement0 = $db->prepare("SELECT * FROM student WHERE id=:id");
        $statement0->bindValue(":id", $sid);
        $statement0->execute();
    }
    
    $student = $statement0->fetch();

?>
        <tr>
        <td> <?php if (!$teacher){
            echo $student['firstname']; 
            }else{
                echo 'Teacher'; //displays the first name as teacher if not a student
            }?></td> 
        <td> <?php if (!$teacher){
            echo $student['lastname']; 
            }else{
            echo $student['name']; //displays teacher name if teacher  
            }?></td>
        <td> <?php echo $row['make']; ?></td>
        <td> <?php echo $row['model']; ?></td> 
        <td> <?php echo $row['year']; ?></td> 
        <td> <?php echo $row['color']; ?></td>
        <td> <?php echo $row['licenseplate']; ?></td>
        <td> <?php echo "<input type='text' name='pnumber" . $i . "' 
                        value='" . $row['permitnumber'] . "'/>"; ?> </td>

        <td> <?php echo "<input type='radio' value = '1' name='pverified" . $i . "' >
                        Verify<br>"; 
                   echo "<input type='radio' value = '2' name='pverified" . $i . "' > 
                        Deny<br>"; ?> </td>
        </tr>
<?php

    $i++;
    }

?>
    </table>
    
    <input type='submit' name='submit' value='Submit' onclick='send()'/>
        
    </form>

</body>

</html>