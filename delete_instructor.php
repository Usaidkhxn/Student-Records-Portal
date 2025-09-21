<!-- delete_instructor.php -->
<?php
include('db_config.php');

if (isset($_GET['id'])) {
    $instructorID = $_GET['id'];
    $deleteQuery = "DELETE FROM Instructor WHERE InstructorID = $instructorID";
    
    if (mysqli_query($conn, $deleteQuery)) {
        echo "Instructor deleted successfully!";
        header("Location: instructors.php");
    } else {
        echo "Error deleting instructor: " . mysqli_error($conn);
    }
}
?>
