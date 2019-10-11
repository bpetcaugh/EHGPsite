<?PHP
//Edited by Christian Kardish

session_start();
include 'functions_2.php';
include 'includeInc_2.php';
dohtml_header("Add Announcement");
teacher_only();
password_protect("login_2.php?announcement=1");
$db = get_database_connection();
 
?>
<!--<head>
<link rel="stylesheet" type="text/css" href="css_2.css" />
</head>
<body bgcolor=#CCCCCC>//-->

    <form action='submit_2.php' method='post'><table class="centered"><tr><td>
                <?php 
                $default = "";
                $date = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));    //set to tomorrow
                $date = date('Y-m-d', $date);
                if (isset($_GET['date'])) {     //announcement is being edited
                     $date = $_GET['date'];
				}
				if(isset($_GET['?id'])){
				 
                     $id = $_GET['?id'];                     
                     $editAnnouncement = $db->prepare("SELECT * FROM announcements WHERE id=:id AND teacher=:teacher");
                     $editAnnouncement->bindValue(":id", $id);
                     $editAnnouncement->bindValue(":teacher", $_SESSION['name']);
                     $editAnnouncement->execute();         
                     
                     if ($editAnnouncement->rowCount() != 1){
                        die($editAnnouncement->rowCount()." Something went wrong. Please report this incident to the webmaster. If you were trying to hack the database ... please stop.");
                     }else{
                        $row = $editAnnouncement->fetch();
                        $announcement = $row['announcement'];
                     }
                     $default = $announcement; 
                     echo "<input type='hidden' name='id' value ='" . $_GET['?id'] . "'>";              
                }               

                echo "Date:<input type=text name=date value='" . $date . "'><br>"; 
                
				
            //             $default = $_GET['?announcement']; 
          //           }   
        //             if(isset($_GET['?id'])) {
      //                echo "<input type='hidden' name='id' value ='" . $_GET['?id'] . "'>";
    //                 }                 
  //              }               
 
                
                if(isset($_GET['?grade'])){ 
                    echo "<select name='grade'>"; 
                    if($_GET['?grade'] == 'Freshman'){ 
                          echo "<option value='Freshman'>Freshman</option>";
                    }else if($_GET['?grade'] == 'Sophomore'){ 
                           echo  "<option value='Sophomore'>Sophomore</option>";
                    }else if($_GET['?grade'] == "Freshman-Sophomore"){ 
                           echo "<option value='Freshman-Sophomore'>Freshman-Sophomore</option>";
                    }else if($_GET['?grade'] == "Junior"){ 
                            echo "<option value='Junior'>Junior</option>";
                    }else if($_GET['?grade'] == "Senior"){ 
                            echo "<option value='Senior'>Senior</option>";
                    }else if($_GET['?grade'] == "Junior-Senior"){ 
                             echo "<option value='Junior-Senior'>Junior-Senior</option>";
                    }else if($_GET['?grade'] == "All Grades"){ 
                             echo "<option value='All Grades'>All Grades</option>";
                    }else if($_GET['?grade'] == "Sophomore-Junior-Senior"){ 
                            echo "<option value='Sophomore-Junior-Senior'>Sophomore-Junior-Senior</option>";
                    }else if($_GET['?grade'] == "Fresman-Sophomore-Junior"){ 
                             echo "<option value='Freshman-Sophomore-Junior'>Freshman-Sophomore-Junior</option>";
                    }else if ($_GET['?grade'] == "Faculty") { 
                            echo "<option value='Faculty'>Faculty</option> ";
                    }else if ($_GET['?grade'] == "Parents/Guardians") { 
                            echo "<option value='Parents/Guardians'>Parents/Guardians</option> ";
                    }

                }
                if(!isset($_GET['?grade'])){
                
                    echo "<select name='grade'>  ";
                
                }
                ?>   
                    <option value="Freshman">Freshman</option>
                    <option value="Sophomore">Sophomore</option>
                    <option value="Freshman-Sophomore">Freshman-Sophomore</option>
                    <option value="Junior">Junior</option>
                    <option value="Senior">Senior</option>
                    <option value="Junior-Senior">Junior-Senior</option>
                    <option value="All Grades">All Grades</option>
                    <option value="Sophomore-Junior-Senior">Sophomore-Junior-Senior</option>
                    <option value="Freshman-Sophomore-Junior">Freshman-Sophomore-Junior</option>
                    <option value="Faculty">Faculty</option>
					<?php
					    $username = $_SESSION['username'];
					    $password = $_SESSION['password'];
					    if (is_super_admin($username, $password)){ 
					?>
                          <option value="Parents/Guardians">Parents/Guardians</option>
					<?php 
						} 
					?>
                    </select><br />
                <textarea rows=8 cols=50 name='announcement'><?php echo $default?></textarea>
                <br />                
                <input type='submit' name='submit' value='Submit'><br /><br />               
            </form></td></tr>
           <?php homelogout(); ?>
    </table>
<?php dohtml_footer(true) ?>
