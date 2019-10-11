Functions 
Add
//Takes a student id and returns the students full name
function getFullName($studentid, $db) {
    $query = $db->prepare("SELECT firstname,lastname FROM student WHERE id = :id");
    $query -> bindValue(":id", $studentid);
    $query -> execute();
    $row = $query ->fetch();
    $fullname = $row['lastname'] . ", " . $row['firstname'] ;
    return $fullname;
}
?>

To Make Work with teachers:
The pages need to check if the session id is that of a teacher
if it is, make String with value either "student" or "teacher"

make query like this:
$query = $db->prepare("SELECT * FROM {String} WHERE foo=foo");

Everywhere that the table student is called.