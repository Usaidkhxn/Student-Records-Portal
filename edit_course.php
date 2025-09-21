<!-- edit_course.php -->
<?php 
include('header.php');
include('db_config.php');

if (isset($_GET['id'])) {
    $courseID = $_GET['id'];
    $sql = "SELECT * FROM Course WHERE CourseID = $courseID";
    $result = mysqli_query($conn, $sql);
    $course = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $courseName = $_POST['courseName'];
    $credits = $_POST['credits'];
    $department = $_POST['department'];
    $instructorID = $_POST['instructorID'];

    $updateQuery = "UPDATE Course 
                    SET CourseName = '$courseName', Credits = $credits, Department = '$department', 
                        InstructorID = $instructorID 
                    WHERE CourseID = $courseID";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Course updated successfully!";
        header("Location: courses.php");
    } else {
        echo "Error updating course: " . mysqli_error($conn);
    }
}
?>

<h2>Edit Course</h2>
<form method="post" action="edit_course.php?id=<?php echo $course['CourseID']; ?>">
    <label for="courseName">Course Name:</label>
    <input type="text" name="courseName" value="<?php echo $course['CourseName']; ?>" required><br><br>

    <label for="credits">Credits:</label>
    <input type="number" name="credits" value="<?php echo $course['Credits']; ?>" required><br><br>

    <label for="department">Department:</label>
    <input type="text" name="department" value="<?php echo $course['Department']; ?>" required><br><br>

    <label for="instructorID">Instructor:</label>
    <select name="instructorID" required>
        <?php
        $instructors = mysqli_query($conn, "SELECT InstructorID, Name FROM Instructor");
        while ($row = mysqli_fetch_assoc($instructors)) {
            echo '<option value="' . $row['InstructorID'] . '"';
            if ($row['InstructorID'] == $course['InstructorID']) echo ' selected';
            echo '>' . $row['Name'] . '</option>';
        }
        ?>
    </select><br><br>

    <button type="submit" name="update">Update Course</button>
</form>

<?php include('footer.php'); ?>
