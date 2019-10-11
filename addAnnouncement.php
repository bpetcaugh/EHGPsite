<?PHP
session_start();
include 'functions.php';
teacher_only();
password_protect("login.php?announcement=1");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css.css" />
</head>
<body bgcolor=#CCCCCC>
       
    <center><h1>Add Announcement</h1></center>
    <table align=center><td><form action='submit.php' method='post'>
                <?php $tomorrow = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
                echo "Date:<input type=text name=date value='" . date('Y-m-d', $tomorrow) . "'><br>"; ?>
                <select name="grade">
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
                </select><br>
                <textarea rows=4 cols=50 name='announcement'></textarea>
                <br>
                <input type='submit' name='submit' value='Submit'><br><br>
                <a href=index.php>Home</a>
            </form>
            <a href=logout.php>Logout</a>
    </td></table>
</body>
</html>
