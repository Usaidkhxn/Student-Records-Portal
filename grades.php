<!-- grades.php -->
<?php 
include('header.php'); 
include('db_config.php');

// Handle form submission to add a new grade
if (isset($_POST['submit'])) {
    $studentID = $_POST['studentID'];
    $courseID = $_POST['courseID'];
    $semester = $_POST['semester'];
    $year = $_POST['year'];
    $grade = $_POST['grade'];

    $query = "INSERT INTO Grade (StudentID, CourseID, Semester, Year, Grade)
              VALUES ($studentID, $courseID, '$semester', $year, '$grade')";
    
    if (mysqli_query($conn, $query)) {
        echo "New grade added successfully!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Fetch grades
$sql = "SELECT G.GradeID, S.Name AS StudentName, C.CourseName, G.Semester, G.Year, G.Grade 
        FROM Grade G
        JOIN Student S ON G.StudentID = S.StudentID
        JOIN Course C ON G.CourseID = C.CourseID";
$result = mysqli_query($conn, $sql);

$students = mysqli_query($conn, "SELECT StudentID, Name FROM Student");
$courses = mysqli_query($conn, "SELECT CourseID, CourseName FROM Course");
?>

<h2>Manage Grades</h2>

<form method="post" action="grades.php">
    <label for="studentID">Student:</label>
    <select name="studentID" required>
        <?php while ($row = mysqli_fetch_assoc($students)): ?>
            <option value="<?php echo $row['StudentID']; ?>"><?php echo $row['Name']; ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label for="courseID">Course:</label>
    <select name="courseID" required>
        <?php while ($row = mysqli_fetch_assoc($courses)): ?>
            <option value="<?php echo $row['CourseID']; ?>"><?php echo $row['CourseName']; ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label for="semester">Semester:</label>
    <input type="text" name="semester" required><br><br>

    <label for="year">Year:</label>
    <input type="number" name="year" required><br><br>

    <label for="grade">Grade:</label>
    <input type="text" name="grade" required><br><br>

    <button type="submit" name="submit">Add Grade</button>
</form>

<h3>Grade List</h3>
<table border="1">
    <tr>
        <th>Grade ID</th>
        <th>Student Name</th>
        <th>Course</th>
        <th>Semester</th>
        <th>Year</th>
        <th>Grade</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['GradeID']; ?></td>
        <td><?php echo $row['StudentName']; ?></td>
        <td><?php echo $row['CourseName']; ?></td>
        <td><?php echo $row['Semester']; ?></td>
        <td><?php echo $row['Year']; ?></td>
        <td><?php echo $row['Grade']; ?></td>
        <td>
            <a href="edit_grade.php?id=<?php echo $row['GradeID']; ?>">Edit</a> | 
            <a href="delete_grade.php?id=<?php echo $row['GradeID']; ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include('footer.php'); ?>
