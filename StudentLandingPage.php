<?php 
require 'sidebar.php';
?>
<!DOCTYPE html>
<html>
    <head>

        <!-- Metadata -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">
        <meta name="description" content="Holy Ghost Prep Announcement Page">
        <link rel="shortcut icon" href="favicon.ico">


        <title>EHGP Announcements</title>

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
		<?PHP
		require 'alerts.php';

            //Get DB connection and get date to view announcements
            $db = get_database_connection();

            //Set date
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $_SESSION['data'] = $date;
            }else{
                $date = date('Y-m-d');
                $_SESSION['date'] = $date;
            }

            //Supported image types for uploading to server
            $supported_image = array(
                'gif',
                'jpg',
                'jpeg',
                'png'
            );

            //Set color variable from cookie for background color picker
            if(isset($_COOKIE["color"])){
                $backColor = $_COOKIE["color"];
            }else{
                $backColor = $_COOKIE["css"];
            }

        ?>

    </head>
    <body>
        <!-- Navbar -->
        <div class="sticky-top">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <ul class="navbar-nav mx-auto">
                        <div class="navbar-nav">
                            <!-- Search box -->
                            <li class="nav-item search-box">
                                <form class="form-inline searchForm" action="textSearcher.php" method="POST">
                                    <input type="search" name="searchTerm" id="searchbar" class="search center form-control" placeholder="Search by term..." autocomplete="off" required>
                                </form>
                            </li>
                            <!-- Select date to view announcements -->
                            <li class="nav-item">
                                <div class="form-group">
                                    <?php
                                    echo"<form class='form-inline' method='GET' action='announcements.php'><select class='form-control' name='date' onchange='this.form.submit()'>";

                                    //Create each option from dates in the database
                                    $rows = $db->query("SELECT * FROM announcements ORDER BY date DESC");
                                    $temp = 0;
                                    echo "<option value=''>Select Date</option>";
                                    foreach ($rows as $row) {
                                        if ($temp != $row['date']) {
                                            $temp = $row['date'];
                                            echo "<option value=" . $temp;
                                            if ($temp == $date) {
                                                echo " selected=selected";
                                            }
                                            echo ">" . $temp . "</option>";
                                            }
                                        }
                                    echo "</select>";
                                    ?>
                                </div>
                            </li>
                            <!-- Select grade to filter by -->
                            <li class="nav-item">
                                <div class="form-group">
                                    <?php

                                    echo "<select class='form-control' name='view' onchange='this.form.submit()'>";

                                    //List of all grades
		                            $headings[0] = "All Grades";
		                            $headings[1] = "Freshman";
                                    $headings[2] = "Sophomore";
                                    $headings[3] = "Junior";
                                    $headings[4] = "Senior";
                                    $headings[5] = "Freshman-Sophomore";
                                    $headings[6] = "Junior-Senior";;

                                    //If refreshed, save current grade
                                    $isView = false;
                                    if(isset($_GET['view'])){
                                        $isView = true;
                                    }

                                    //Loop through the grades to create options
                                    for ($i = 0; $i < count($headings); $i++) {
                                      echo "<option value='$i'";
                                      if (($isView) && $_GET['view'] == $i) {
                                          echo " selected=selected";
                                          $view = $i;
                                      }
                                      echo ">" . $headings[$i] . "</option>";
                                    }
                                    echo "</select></form>";

                                    //Set the grade variable
                                    $grade="null";
                                     if(isset($_GET['view'])){
                                      $view = $_GET['view'];
                                      if($view == 0){
                                        $grade="All Grades";
                                      }else if($view == 1){
                                        $grade="Freshman";
                                      }else if($view == 2){
                                        $grade="Sophomore";
                                      }else if($view == 3){
                                        $grade="Junior";
                                      }else if($view == 4){
                                        $grade="Senior";
                                      }else if($view == 5){
                                        $grade="Freshman-Sophomore";
                                      }else if($view == 6){
                                        $grade="Junior-Senior";
                                      }
                                      } else {
                                      $grade="All Grades";
                                    }
                                    ?>
                                </div>
                            </li>
                        </div>
                    </ul>
                </div>
            </nav>
            <div class="scroll-line"></div>
        </div>
        <!-- HGP Logo Header -->
        <div class="mx-auto" style="width: 100%; ">
            <div class="header-top">
                <img src="logo.png" alt="HGP Logo" class="img-logo">
            </div>
            <br>
        </div>
        <!-- This is where the announcements page starts -->
            <div class="mx-auto" id="canv-container" style="width: 90%;">
            <div class="alert-header"></div>
            <?php
                getAlert();
                $modal = 0;
                //Show date to view annoncements
                echo "<h3 class='center'>" . date('l', strtotime($date)) . ", " . $date . "</h3><br>";
                echo "<div class='text-center'><form action='http://ehgp.holyghostprep.org' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Home'></form>";
                //echo "<form action='" . base_url() . "feedback.php' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Submit Feedback'></form>";
                echo "<button style='display:inline-block' type='button' class='btn btn-primary announcements-btns' data-toggle='modal' data-target='#settingsModal'>Settings</button>";

                //If user is a teacher, show button to add a new announcement
                if(isset($_SESSION["isTeacher"]) && $_SESSION["isTeacher"] == true){
                    echo "<button style='display:inline-block' type='button' class='btn btn-primary announcements-btns' data-toggle='modal' data-target='#addModal'>Add Announcement</button>";
                }
                ?>

                <?php
                echo "</div>";
                ?>
                <div class='card-container'>
                  <?php
                //Select announcements from database that are from the chosen date
                $query = $db->prepare("SELECT * FROM announcements WHERE date=:date ORDER BY code");
                $query->bindValue(":date", $date);
                $query->execute();
                while ($row = $query->fetch()) {

                    if($row['grade']=="All Grades"||$grade=="All Grades"||$grade==$row['grade']){

                    //Check if there is a URL link in the announcement
                    if(strstr($row['announcement'], 'http')){
                        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $row['announcement'], $match);
                        //Take out the link and set it to $match
                        $announcement = $row['announcement'];
                        if(isset($match[0])){
                        for($x = 0; $x < count($match[0]); $x++){
                            $v1 = $match[0][$x];
                            if(in_array(strtolower(pathinfo($v1, PATHINFO_EXTENSION)), $supported_image)){
                                $announcement = str_replace($v1, "<br><img class='picture' src='" . $v1 . "' alt='Image'><br>", $announcement);
                            }else{
                                $parse = parse_url($v1);
                                $announcement = str_replace($v1, "<br><a href='$v1' class='btn btn-primary but' target='_blank'>" . $parse['host'] . "</a>", $announcement);
                            }
                        }
                    }
                    }else{
                        $announcement = $row['announcement'];
                    }
                    //Show each announcement in a card
                    echo "<div class='card'>";
                    echo "<h5 class='card-header'>From: " . $row['teacher'] . "<img src='drag.png' alt='drag' class='drag float-right'></h5>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>To: " . $row['grade'] . "</h5>";
                    echo nl2br("<p class='card-text'> " . $announcement) . "</p>";
                    //If there is a link, make a button to the URL


                    //If the user is a teacher, and this is their announcement, allow them to edit/ delete
                    if ($row['teacher'] == $_SESSION["name"]){
                        //Edit button
                        echo "<button type='button' class='btn btn-primary but' data-toggle='modal' data-target='#editModal" . $modal . "'>Edit</button>";
                        echo "<div class='modal fade' id='editModal" . $modal . "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                        ?>
                        <!-- Popout modal for editing annnouncement -->
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5>Edit Announcement</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form method="POST" action="editAnnouncement.php"  enctype="multipart/form-data">
                                <!-- Hidden id and date, and autofill the date from the announcement -->
                                  <div class="form-group">
                                    <label class="col-form-label">Date:</label>
                                    <?php
                                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                                    echo "<input type='date' class='form-control' name='date1' value='" . $row["date"] . "'>";
                                    ?>
                                    </div>
                                <!-- Autofill the grade from the announcement -->
                                  <div class="form-group">
                                    <label class="col-form-label">Grades:</label>
                                    <select name="grade" class="form-control">
                                    <?php
                                    $headings[0] = "All Grades";
		                                $headings[1] = "Freshman";
                                    $headings[2] = "Sophomore";
                                    $headings[3] = "Junior";
                                    $headings[4] = "Senior";
                                    $headings[5] = "Freshman-Sophomore";
                                    $headings[6] = "Junior-Senior";;

                                    for ($i = 0; $i < count($headings); $i++) {
                                      echo "<option value='" . $headings[$i] . "'";
                                      if ($row['grade'] == $headings[$i]) {
                                          echo " selected=selected";
                                      }
                                      echo ">" . $headings[$i] . "</option>";
                                    }
                                    ?>
                                    </select>
                                  </div>
                                <!-- Autofill the announcement text from the announcement -->
                                  <div class="form-group">
                                    <label class="col-form-label">Announcement:</label>
                                    <?php
                                    echo "<textarea class='form-control' name='announcement' rows='10'>" . $row["announcement"] . "</textarea>";
                                    ?>
                                  </div>
                                    <!-- Footer and submit button -->
                                    <div class="modal-footer">
                                        <input type="file" name="Upload" class="btn btn-secondary file-upload" style="width:70%; padding:0.8%;">
                                        <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="top" data-content="To add a link button or image, paste the URL. Also, you can upload an image up to 2MB.">Help</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php
                        //Remove announcement button
                        echo "<form method='POST' action='removeAnnouncement.php' class='remove'><input type='hidden' name='id' value='" . $row["id"] . "'><button type='submit' class='btn btn-primary but'>Remove</button></form>";
                        $modal += 1;
                    }
                    //Unset variables for new announcements
                    unset($announcement);
                    unset($match);
                    echo "</div>";
                    ?>
                  </div>
                  <?php
                    }
                }
                echo "</div>";
                //If there are no announcements
                if ($query->rowCount() == 0){
                    echo "<hr><br><h3 class='center'>No Announcements Today</h3>";
                }

                $db = null;
                //Footer
                echo "<p class='footer-bottom center'>EHGP Announcements redesign by Jack Pinkstone '19 and Ben Scuron '19 with advice and direction from Mr. Michael Jacobs '01, Director of Technology, and Mr. Brandon Petcaugh, Computer Science Chairman</p>";

                if(isset($_SESSION["isTeacher"]) && $_SESSION["isTeacher"] == true){
                    echo '
                    <!-- Popout modal to add an announcement -->
                    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5>Add Announcement</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="POST" action="addAnnouncement.php"  enctype="multipart/form-data">
                            <!-- Autofill date -->
                              <div class="form-group">
                                <div class="row">
                                <div class="col">
                                <label class="col-form-label">Date:</label>
                                    <input type="hidden" name="teacher" value="' . $_SESSION["name"] . '">
                                    <input type="date" class="form-control add_announcement_date" name="date2" value="' . $date . '" required>
                                </div>
                                <div class="col">
                                    <div style="white-space:nowrap">
                                        <label class="col-form-label">End Date (Optional):</label>
                                    </div>
                                    <input type="date" class="form-control" name="date3">
                                </div>
                                </div>
                              </div>
                            <!-- Select grades -->
                              <div class="form-group">
                                <label class="col-form-label">Grades:</label>
                                <select name="grade" class="form-control" required>
                                    <option value="All Grades">All Grades</option>
                                    <option value="Freshman">Freshman</option>
                                    <option value="Sophomore">Sophomore</option>
                                    <option value="Junior">Junior</option>
                                    <option value="Senior">Senior</option>
                                    <option value="Freshman-Sophomore">Freshman-Sophomore</option>
                                    <option value="Junior-Senior">Junior-Senior</option>
                                </select>
                              </div>
                            <!-- Create announcement -->
                              <div class="form-group">
                                <label for="message-text" class="col-form-label">Announcement:</label>
                                <textarea class="form-control" name="announcement" rows="10" required></textarea>
                              </div>
                            <!-- Footer and submit button -->
                              <div class="modal-footer">
                                <input type="file" name="Upload" class="btn btn-secondary" style="width:70%; padding:0.8%;">
                                <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="top" data-content="To add a link button or image, paste the URL. Also, you can upload an image up to 2MB.">Help</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    ';
                }
                ?>

                <!-- Popout modal for settings -->
                <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5>Settings</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action='settings.php' method="POST">
                        <table id="settings-table">
                          <tr>
                            <td><p class="setting-label" id="drag-label">Drag Mode: </p></td>
                            <td align="right">
                                <label class="switch" id="drag-switch">
                                  <input type="checkbox" name="drag" id="drag-toggle">
                                  <span class="slider round"></span>
                                </label>
                            </td>
                          </tr>
                          <tr>
                            <td><p class="setting-label">Background: </p></td>
                            <td align="right"><?php echo "<input id='settings-bg-color' type='color' name='color'/>"; ?></td>
                          </tr>
                          <tr>
                            <td><p class="setting-label">Themes: </p></td>
                            <td align="right">
                              <label class="switch">
                                  <input type="checkbox" name="themes" id="theme-toggle">
                                  <span class="slider round"></span>
                              </label>
                            </td>
                          </tr>
                          <tr>
                            <td><p class="setting-label">Dark Theme: </p></td>
                            <td align="right">
                              <label class="switch">
                                  <input type="checkbox" name="dark" id="dark-toggle">
                                  <span class="slider round"></span>
                              </label>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2"><hr></td>
                          </tr>
                          <tr>
                            <td><p class="setting-label">Restore to Default: </p></td>
                            <td align="right">
                                <label class="switch">
                                  <input type="checkbox" id="restore-checkbox" name="restore">
                                  <span class="slider round"></span>
                                </label>
                            </td>
                          </tr>
                        </table>
                        <!-- Footer and submit button -->
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="top" data-content="Toggle a slider to change your settings. All user settings are stored as cookies.">Help</button>
                            <input type="submit" value="Save" class="btn btn-primary"/>
                          </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
    </body>
</html>

  </main>
    
</div>
<!-- page-wrapper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    
</body>

</html>