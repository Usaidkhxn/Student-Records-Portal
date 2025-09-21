<!-- edit_instructor.php -->
<?php 
include('header.php');
include('db_config.php');

if (isset($_GET['id'])) {
    $instructorID = $_GET['id'];
    $sql = "SELECT * FROM Instructor WHERE InstructorID = $instructorID";
    $result = mysqli_query($conn, $sql);
    $instructor = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    $updateQuery = "UPDATE Instructor 
                    SET Name = '$name', Department = '$department', Email = '$email', 
                        ContactNo = '$contact' 
                    WHERE InstructorID = $instructorID";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Instructor updated successfully!";
        header("Location: instructors.php");
    } else {
        echo "Error updating instructor: " . mysqli_error($conn);
    }
}
?>

<h2>Edit Instructor</h2>
<form method="post" action="edit_instructor.php?id=<?php echo $instructor['InstructorID']; ?>">
    <label for="name">Name:</label>
    <input type="text" name="name" value="<?php echo $instructor['Name']; ?>" required><br><br>

    <label for="department">Department:</label>
    <input type="text" name="department" value="<?php echo $instructor['Department']; ?>" required><br><br>

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo $instructor['Email']; ?>" required><br><br>

    <label for="contact">Contact:</label>
    <input type="text" name="contact" value="<?php echo $instructor['ContactNo']; ?>" required><br><br>

    <button type="submit" name="update">Update Instructor</button>
</form>

<?php include('footer.php'); ?>
