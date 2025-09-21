<?php 
include('header.php'); 
include('db_config.php');

// Handle form submission to add a new student
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $admissionYear = mysqli_real_escape_string($conn, $_POST['admissionYear']);
    $courseEnrolled = mysqli_real_escape_string($conn, $_POST['courseEnrolled']);

    // Prepare the query with sanitized input
    $query = "INSERT INTO Student (Name, DOB, ContactInfo, Address, AdmissionYear, CourseEnrolled)
              VALUES ('$name', '$dob', '$contact', '$address', '$admissionYear', '$courseEnrolled')";
    
    // Execute the query
    if (mysqli_query($conn, $query)) {
        echo "New student added successfully!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Fetch students
$sql = "SELECT * FROM Student";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Error fetching data: " . mysqli_error($conn));
}
?>

<h2>Manage Students</h2>

<form method="post" action="students.php">
    <label for="name">Name:</label>
    <input type="text" name="name" required><br><br>

    <label for="dob">Date of Birth:</label>
    <input type="date" name="dob" required><br><br>

    <label for="contact">Contact Info:</label>
    <input type="text" name="contact" required><br><br>

    <label for="address">Address:</label>
    <textarea name="address" required></textarea><br><br>

    <label for="admissionYear">Admission Year:</label>
    <input type="number" name="admissionYear" required><br><br>

    <label for="courseEnrolled">Course Enrolled:</label>
    <input type="text" name="courseEnrolled" required><br><br>

    <button type="submit" name="submit">Add Student</button>
</form>

<h3>Student List</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>DOB</th>
        <th>Contact</th>
        <th>Address</th>
        <th>Admission Year</th>
        <th>Course Enrolled</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['StudentID']; ?></td>
        <td><?php echo $row['Name']; ?></td>
        <td><?php echo $row['DOB']; ?></td>
        <td><?php echo $row['ContactInfo']; ?></td>
        <td><?php echo $row['Address']; ?></td>
        <td><?php echo $row['AdmissionYear']; ?></td>
        <td><?php echo $row['CourseEnrolled']; ?></td>
        <td>
            <a href="edit_student.php?id=<?php echo $row['StudentID']; ?>">Edit</a> | 
            <a href="delete_student.php?id=<?php echo $row['StudentID']; ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include('footer.php'); ?>
