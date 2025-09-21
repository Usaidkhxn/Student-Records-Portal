<!-- enrollments.php -->
<?php 
include('header.php'); 
include('db_config.php');

// Handle form submission to add a new enrollment
if (isset($_POST['submit'])) {
    $studentID = $_POST['studentID'];
    $courseID = $_POST['courseID'];
    $semester = $_POST['semester'];
    $year = $_POST['year'];
    $status = $_POST['status'];

    $query = "INSERT INTO Enrollment (StudentID, CourseID, Semester, Year, Status)
              VALUES ($studentID, $courseID, '$semester', $year, '$status')";
    
    if (mysqli_query($conn, $query)) {
        echo "New enrollment added successfully!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Fetch enrollments
$sql = "SELECT E.EnrollmentID, S.Name AS StudentName, C.CourseName, E.Semester, E.Year, E.Status 
        FROM Enrollment E
        JOIN Student S ON E.StudentID = S.StudentID
        JOIN Course C ON E.CourseID = C.CourseID";
$result = mysqli_query($conn, $sql);

$students = mysqli_query($conn, "SELECT StudentID, Name FROM Student");
$courses = mysqli_query($conn, "SELECT CourseID, CourseName FROM Course");
?>

<h2>Manage Enrollments</h2>

<form method="post" action="enrollments.php">
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

    <label for="status">Status:</label>
    <input type="text" name="status" required><br><br>

    <button type="submit" name="submit">Add Enrollment</button>
</form>

<h3>Enrollment List</h3>
<table border="1">
    <tr>
        <th>Enrollment ID</th>
        <th>Student Name</th>
        <th>Course</th>
        <th>Semester</th>
        <th>Year</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['EnrollmentID']; ?></td>
        <td><?php echo $row['StudentName']; ?></td>
        <td><?php echo $row['CourseName']; ?></td>
        <td><?php echo $row['Semester']; ?></td>
        <td><?php echo $row['Year']; ?></td>
        <td><?php echo $row['Status']; ?></td>
        <td>
            <a href="edit_enrollment.php?id=<?php echo $row['EnrollmentID']; ?>">Edit</a> | 
            <a href="delete_enrollment.php?id=<?php echo $row['EnrollmentID']; ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include('footer.php'); ?>
