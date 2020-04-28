//undone by mmm 5-10-12
<head>
    <script>
        function refresh(){
            var formObject = document.forms['theForm'];
            formObject.submit();
        }
    </script>
</head>
<?php

function gradeSelector($page) {
    $grade = '';
    if (isset($_GET['grade'])) {
        $grade = $_GET['grade'];
    }
    echo"<form name='theForm' action='$page' method='get'>
	<select name='teacher' onchange='refresh()'>
	<option value = ' '>Choose a teacher</option>";

    $rows = get_teachers();
    foreach ($rows as $row) {
        $name = $row['name'];
        $id = $row['id'];
        echo "<option value=" . $id;
        if ($id == $teacher) {
            echo " selected=selected";
        }
        echo ">" . $name . "</option>";
    }
    echo "</select></form>";
    // foreach ($rows as $row) {
    // 	echo $row['name'];
    // }
}

function get_grades() {
    $db = get_database_connection();
    $statement = $db->prepare("SELECT grade FROM student GROUP BY grade ORDER BY grade ASC");
    $statement->execute();
    $db = null;
    return $statement->fetchAll();
}
?>