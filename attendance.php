<!-- attendance.php -->
<?php 
include('header.php'); 
include('db_config.php');

// Handle form submission to add a new attendance record
if (isset($_POST['submit'])) {
    $studentID = $_POST['studentID'];
    $courseID = $_POST['courseID'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    $query = "INSERT INTO Attendance (StudentID, CourseID, Date, Status)
              VALUES ($studentID, $courseID, '$date', '$status')";
    
    if (mysqli_query($conn, $query)) {
        echo "New attendance record added successfully!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Fetch attendance records
$sql = "SELECT A.AttendanceID, S.Name AS StudentName, C.CourseName, A.Date, A.Status 
        FROM Attendance A
        JOIN Student S ON A.StudentID = S.StudentID
        JOIN Course C ON A.CourseID = C.CourseID";
$result = mysqli_query($conn, $sql);

$students = mysqli_query($conn, "SELECT StudentID, Name FROM Student");
$courses = mysqli_query($conn, "SELECT CourseID, CourseName FROM Course");
?>

<h2>Manage Attendance</h2>

<form method="post" action="attendance.php">
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

    <label for="date">Date:</label>
    <input type="date" name="date" required><br><br>

    <label for="status">Status:</label>
    <input type="text" name="status" required><br><br>

    <button type="submit" name="submit">Add Attendance</button>
</form>

<h3>Attendance List</h3>
<table border="1">
    <tr>
        <th>Attendance ID</th>
        <th>Student Name</th>
        <th>Course</th>
        <th>Date</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['AttendanceID']; ?></td>
        <td><?php echo $row['StudentName']; ?></td>
        <td><?php echo $row['CourseName']; ?></td>
        <td><?php echo $row['Date']; ?></td>
        <td><?php echo $row['Status']; ?></td>
        <td>
            <a href="edit_attendance.php?id=<?php echo $row['AttendanceID']; ?>">Edit</a> | 
            <a href="delete_attendance.php?id=<?php echo $row['AttendanceID']; ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include('footer.php'); ?>
