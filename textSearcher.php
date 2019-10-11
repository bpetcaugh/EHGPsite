<?php
session_start();
require 'functions_2.php';
//Get DB connection and get date to view announcements
$db = get_database_connection();
$query = $db->prepare("SELECT * FROM announcements ORDER BY date DESC");
$query->execute();

$supported_image = array(
    'gif',
    'jpg',
    'jpeg',
    'png'
);

            if (isset($_SESSION['data'])) {
                $date = $_SESSION['data'];
            }else{
                $date = date('Y-m-d');
            }

            $line = false;

while ($row = $query->fetch()) {
  if (substr_count(strtolower($row['announcement']), strtolower($_POST['searchTerm'])) > 0 || substr_count(strtolower($row['teacher']), strtolower($_POST['searchTerm'])) > 0) {
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
    echo "<h5 class='card-header'>From: " . $row['teacher'];
    echo "<br>";
    echo "Date: " . $row['date'];
    echo "</h5>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>To: " . $row['grade'] . "</h5>";
    echo nl2br("<p class='card-text'> " . $announcement) . "</p>";
    //If the user is a teacher, and this is their announcement, allow them to edit/ delete
    if ($row['teacher'] == $_SESSION["name"]){
        //Edit button
        echo "<button type='button' class='btn btn-primary but' data-toggle='modal' data-target='#editModal" . $modal . "'>Edit</button>";
        echo "<div class='modal fade' id='editModal" . $modal . "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
        echo '
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
                    ';?>
                    <?php
                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                    echo "<input type='date' class='form-control' name='date1' value='" . $row["date"] . "'>";
                    ?>
                    <?php
                    echo '
                    </div>
                  <div class="form-group">
                    <label class="col-form-label">Grades:</label>
                    <select name="grade" class="form-control">
                    ';
                    ?>
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
                    <?php
                    echo '
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Announcement:</label>
                    ';
                    ?>
                    <?php
                    echo "<textarea class='form-control' name='announcement' rows='10'>" . $row["announcement"] . "</textarea>";
                    ?>
                    <?php
                    echo '
                  </div>
                    <div class="modal-footer">
                        <input type="file" name="Upload" class="btn btn-secondary" style="width:70%; padding:0.8%;">
                        <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="top" data-content="To add a link button or image, paste the URL.">Help</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>';
        ?>
        <?php
        //Remove announcement button
        echo "<form method='POST' action='removeAnnouncement.php' class='remove'><input type='hidden' name='id' value='" . $row["id"] . "'><button type='submit' class='btn btn-primary but'>Remove</button></form>";
        $modal += 1;
    }
    echo "</div></div>";
  }
}
 ?>
