<!-- edit_enrollment.php -->
<?php 
include('header.php');
include('db_config.php');

if (isset($_GET['id'])) {
    $enrollmentID = $_GET['id'];
    $sql = "SELECT * FROM Enrollment WHERE EnrollmentID = $enrollmentID";
    $result = mysqli_query($conn, $sql);
    $enrollment = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $studentID = $_POST['studentID'];
    $courseID = $_POST['courseID'];
    $semester = $_POST['semester'];
    $year = $_POST['year'];
    $status = $_POST['status'];

    $updateQuery = "UPDATE Enrollment 
                    SET StudentID = $studentID, CourseID = $courseID, Semester = '$semester', 
                        Year = $year, Status = '$status' 
                    WHERE EnrollmentID = $enrollmentID";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Enrollment updated successfully!";
        header("Location: enrollments.php");
    } else {
        echo "Error updating enrollment: " . mysqli_error($conn);
    }
}
?>

<h2>Edit Enrollment</h2>
<form method="post" action="edit_enrollment.php?id=<?php echo $enrollment['EnrollmentID']; ?>">
    <label for="studentID">Student:</label>
    <select name="studentID" required>
        <?php 
        $students = mysqli_query($conn, "SELECT StudentID, Name FROM Student");
        while ($row = mysqli_fetch_assoc($students)) {
            echo '<option value="' . $row['StudentID'] . '"';
            if ($row['StudentID'] == $enrollment['StudentID']) echo ' selected';
            echo '>' . $row['Name'] . '</option>';
        }
        ?>
    </select><br><br>

    <label for="courseID">Course:</label>
    <select name="courseID" required>
        <?php 
        $courses = mysqli_query($conn, "SELECT CourseID, CourseName FROM Course");
        while ($row = mysqli_fetch_assoc($courses)) {
            echo '<option value="' . $row['CourseID'] . '"';
            if ($row['CourseID'] == $enrollment['CourseID']) echo ' selected';
            echo '>' . $row['CourseName'] . '</option>';
        }
        ?>
    </select><br><br>

    <label for="semester">Semester:</label>
    <input type="text" name="semester" value="<?php echo $enrollment['Semester']; ?>" required><br><br>

    <label for="year">Year:</label>
    <input type="number" name="year" value="<?php echo $enrollment['Year']; ?>" required><br><br>

    <label for="status">Status:</label>
    <input type="text" name="status" value="<?php echo $enrollment['Status']; ?>" required><br><br>

    <button type="submit" name="update">Update Enrollment</button>
</form>

<?php include('footer.php'); ?>
