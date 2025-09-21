<!-- edit_student.php -->
<?php 
include('header.php');
include('db_config.php');

if (isset($_GET['id'])) {
    $studentID = $_GET['id'];
    $sql = "SELECT * FROM Student WHERE StudentID = $studentID";
    $result = mysqli_query($conn, $sql);
    $student = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $admissionYear = $_POST['admissionYear'];
    $courseEnrolled = $_POST['courseEnrolled'];

    $updateQuery = "UPDATE Student 
                    SET Name = '$name', DOB = '$dob', ContactInfo = '$contact', 
                        Address = '$address', AdmissionYear = $admissionYear, 
                        CourseEnrolled = '$courseEnrolled' 
                    WHERE StudentID = $studentID";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Student updated successfully!";
        header("Location: students.php");
    } else {
        echo "Error updating student: " . mysqli_error($conn);
    }
}
?>

<h2>Edit Student</h2>
<form method="post" action="edit_student.php?id=<?php echo $student['StudentID']; ?>">
    <label for="name">Name:</label>
    <input type="text" name="name" value="<?php echo $student['Name']; ?>" required><br><br>

    <label for="dob">Date of Birth:</label>
    <input type="date" name="dob" value="<?php echo $student['DOB']; ?>" required><br><br>

    <label for="contact">Contact Info:</label>
    <input type="text" name="contact" value="<?php echo $student['ContactInfo']; ?>" required><br><br>

    <label for="address">Address:</label>
    <textarea name="address" required><?php echo $student['Address']; ?></textarea><br><br>

    <label for="admissionYear">Admission Year:</label>
    <input type="number" name="admissionYear" value="<?php echo $student['AdmissionYear']; ?>" required><br><br>

    <label for="courseEnrolled">Course Enrolled:</label>
    <input type="text" name="courseEnrolled" value="<?php echo $student['CourseEnrolled']; ?>" required><br><br>

    <button type="submit" name="update">Update Student</button>
</form>

<?php include('footer.php'); ?>
