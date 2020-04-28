<?PHP
//edited by Vincent Pillinger
session_start();
include 'functions_2.php';
teacher_only();
password_protect("login_2.php?dress=1");
$db = get_database_connection();
include 'includeInc_2.php';
dohtml_header("Add a Violation");
?>
<script type='text/javascript'>
    function refresh()
    {
        var formObject = document.forms['theForm'];
        formObject.action="adddress_2.php";
        formObject.submit();
    }
    function send()
    {
        var formObject = document.forms['theForm'];
        formObject.submit();
    }
</script>
    <form name='theForm' method='post' action='submit_2.php'>
	<table class='centered'>
                <?php
                homeLogout();
                $grade = 9;
                if (isset($_GET['grade']))
                    $grade = $_GET['grade'];

                $statement = $db->prepare("SELECT * FROM student WHERE grade=:grade ORDER BY lastname");
                $statement->bindValue(":grade", $grade);
                $statement->execute();

                $result = $statement->fetch();
                echo "</table><table class='centered'><tr><td>";
                if (isset($_POST['date'])) {
                    echo "Date:<input type=text name=date value='" . $_POST['date'] . "'><br><br>";
                } else {
                    echo "Date:<input type=text name=date value='" . date('Y-m-d') . "'><br><br>";
                }
                $i = 0;
                do {
                    $i = $i + 1;
                    $grade = "grade" . $i;
                    $name = "name" . $i;
                    $violation = "violation" . $i;
                    $notes = "notes" . $i;
                    echo "Grade:<select name='" . $grade . "' onchange='refresh()'>";
                    echo "<option value=0>Select Grade</option>";
                    echo "<option value=9 ";
                    if (isset($_POST[$grade]) && $_POST[$grade] == 9)
                        echo "selected";
                    echo ">Grade 9</option>";
                    echo "<option value=10 ";
                    if (isset($_POST[$grade]) && $_POST[$grade] == 10)
                        echo "selected";
                    echo ">Grade 10</option>";
                    echo "<option value=11 ";
                    if (isset($_POST[$grade]) && $_POST[$grade] == 11)
                        echo "selected";
                    echo ">Grade 11</option>";
                    echo "<option value=12 ";
                    if (isset($_POST[$grade]) && $_POST[$grade] == 12)
                        echo "selected";
                    echo ">Grade 12</option>";
                    echo "</select>";

                    if (isset($_POST[$grade])) {
                        $gradeQuery = $db->prepare("SELECT * FROM student WHERE grade=:grade ORDER BY lastname");
                        $gradeQuery->bindValue(":grade", $_POST[$grade]);
                        $gradeQuery->execute();

                        echo "Student:<select name='" . $name . "' onchange='refresh()'><option value=0>Select Student</option>";

                        while ($row = $gradeQuery->fetch()) {
                            //echo "<option value='" . $row['lastname'] . ", " . $row['firstname'] . "' ";
                            echo "<option value=\"{$row['lastname']}, {$row['firstname']}\" ";//Ricky Wang MMM {} concat 4-21-16
							if (isset($_POST[$name]) && $_POST[$name] == $row['lastname'] . ", " . $row['firstname'])
                                echo "selected";
                            //echo ">" . $row['lastname'] . ", " . $row['firstname'] . "</option>";
                       		echo ">{$row['lastname']}, {$row['firstname']}</option>";//Ricky Wang MMM {} concat 4-21-16
					    }
                        echo "</select>";
                    }

                    if (isset($_POST[$name])) {
                        echo "Violation:<select name='" . $violation . "' onchange='refresh()'>";
                        echo "<option value=0>Select Violation</option>";
                        echo "<option value='No Belt' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "No Belt")
                            echo "selected";
                        echo ">No Belt</option>";
                        echo "<option value='Shirt Untucked' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "Shirt Untucked")
                            echo "selected";
                        echo ">Shirt Untucked</option>";
                        echo "<option value='No Tie' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "No Tie")
                            echo "selected";
                        echo ">No Tie</option>";
                        echo "<option value='No Socks' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "No Socks")
                            echo "selected";
                        echo ">No Socks</option>";
                        echo "<option value='Visible T-Shirt' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "Visible T-Shirt")
                            echo "selected";
                        echo ">Visible T-Shirt</option>";
                        echo "<option value='No Jacket' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "No Jacket")
                            echo "selected";
                        echo ">No Jacket</option>";
                        echo "<option value='Extra Garment' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "Extra Garment")
                            echo "selected";
                        echo ">Extra Garment</option>";
                        echo "<option value='Illegal Shoes' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "Illegal Shoes")
                            echo "selected";
                        echo ">Illegal Shoes</option>";
                        echo "<option value='Illegal Hair' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "Illegal Hair")
                            echo "selected";
                        echo ">Illegal Hair</option>";
                        echo "<option value='Unshaven' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "Unshaven")
                            echo "selected";
                        echo ">Unshaven</option>";
                        echo "<option value='Long Sideburns' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "Long Sideburns")
                            echo "selected";
                        echo ">Long Sideburns</option>";
                        echo "<option value='Earing' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "Earing")
                            echo "selected";
                        echo ">Earing</option>";
                        echo "<option value='Bracelet' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "Bracelet")
                            echo "selected";
                        echo ">Bracelet</option>";
                        echo "<option value='Low Pants' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "Low Pants")
                            echo "selected";
                        echo ">Low Pants</option>";
                        echo "<option value='Ankle Socks' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "Ankle Socks")
                            echo "selected";
                        echo ">Ankle Socks</option>";
                        echo "<option value='Food or Drink' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "Food or Drink")
                            echo "selected";
                        echo ">Food or Drink</option>";
						echo "<option value='Library Infraction' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "Library Infraction")
                            echo "selected";
                        echo ">Library Infraction</option>";
                        echo "<option value='Library Infraction' ";
                        if (isset($_POST[$violation]) && $_POST[$violation] == "Frayed Pants")
                            echo "selected";
                        echo ">Frayed Pants</option>";
                        echo "</select>";
                        if (isset($_POST[$notes])){
                            $tempnotes = $_POST[$notes];
                        }else {
                            $tempnotes = "";
                        }
                        echo "Notes:<input type=text name=" . $notes . " value='" . $tempnotes . "'><br>";
                    }
                }while (isset($_POST[$violation]));
                ?>
                <br><br>
                <input type='button' value='Submit' onclick='send()'>
                </td></tr></table></form>
            <?php
            $db = null;
            dohtml_footer(true);
            ?>
            
   

