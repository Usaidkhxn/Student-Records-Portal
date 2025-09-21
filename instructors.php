<!-- instructors.php -->
<?php 
include('header.php'); 
include('db_config.php');

// Handle form submission to add a new instructor
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    $query = "INSERT INTO Instructor (Name, Department, Email, ContactNo)
              VALUES ('$name', '$department', '$email', '$contact')";
    
    if (mysqli_query($conn, $query)) {
        echo "New instructor added successfully!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Fetch instructors
$sql = "SELECT * FROM Instructor";
$result = mysqli_query($conn, $sql);
?>

<h2>Manage Instructors</h2>

<form method="post" action="instructors.php">
    <label for="name">Name:</label>
    <input type="text" name="name" required><br><br>

    <label for="department">Department:</label>
    <input type="text" name="department" required><br><br>

    <label for="email">Email:</label>
    <input type="email" name="email" required><br><br>

    <label for="contact">Contact:</label>
    <input type="text" name="contact" required><br><br>

    <button type="submit" name="submit">Add Instructor</button>
</form>

<h3>Instructor List</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Department</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['InstructorID']; ?></td>
        <td><?php echo $row['Name']; ?></td>
        <td><?php echo $row['Department']; ?></td>
        <td><?php echo $row['Email']; ?></td>
        <td><?php echo $row['ContactNo']; ?></td>
        <td>
            <a href="edit_instructor.php?id=<?php echo $row['InstructorID']; ?>">Edit</a> | 
            <a href="delete_instructor.php?id=<?php echo $row['InstructorID']; ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include('footer.php'); ?>
