<!-- courses.php -->
<?php 
include('header.php'); 
include('db_config.php');

// Handle form submission to add a new course
if (isset($_POST['submit'])) {
    $courseName = $_POST['courseName'];
    $credits = $_POST['credits'];
    $department = $_POST['department'];
    $instructorID = $_POST['instructorID'];

    $query = "INSERT INTO Course (CourseName, Credits, Department, InstructorID)
              VALUES ('$courseName', $credits, '$department', $instructorID)";
    
    if (mysqli_query($conn, $query)) {
        echo "New course added successfully!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Fetch courses and instructors
$sql = "SELECT * FROM Course";
$result = mysqli_query($conn, $sql);

$instructors = mysqli_query($conn, "SELECT InstructorID, Name FROM Instructor");
?>

<h2>Manage Courses</h2>

<form method="post" action="courses.php">
    <label for="courseName">Course Name:</label>
    <input type="text" name="courseName" required><br><br>

    <label for="credits">Credits:</label>
    <input type="number" name="credits" required><br><br>

    <label for="department">Department:</label>
    <input type="text" name="department" required><br><br>

    <label for="instructorID">Instructor:</label>
    <select name="instructorID" required>
        <?php while ($row = mysqli_fetch_assoc($instructors)): ?>
            <option value="<?php echo $row['InstructorID']; ?>"><?php echo $row['Name']; ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <button type="submit" name="submit">Add Course</button>
</form>

<h3>Course List</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Credits</th>
        <th>Department</th>
        <th>Instructor</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['CourseID']; ?></td>
        <td><?php echo $row['CourseName']; ?></td>
        <td><?php echo $row['Credits']; ?></td>
        <td><?php echo $row['Department']; ?></td>
        <td><?php echo $row['InstructorID']; ?></td>
        <td>
            <a href="edit_course.php?id=<?php echo $row['CourseID']; ?>">Edit</a> | 
            <a href="delete_course.php?id=<?php echo $row['CourseID']; ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include('footer.php'); ?>
