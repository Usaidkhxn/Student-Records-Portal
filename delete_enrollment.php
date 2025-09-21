<!-- delete_enrollment.php -->
<?php
include('db_config.php');

if (isset($_GET['id'])) {
    $enrollmentID = $_GET['id'];
    $deleteQuery = "DELETE FROM Enrollment WHERE EnrollmentID = $enrollmentID";
    
    if (mysqli_query($conn, $deleteQuery)) {
        echo "Enrollment deleted successfully!";
        header("Location: enrollments.php");
    } else {
        echo "Error deleting enrollment: " . mysqli_error($conn);
    }
}
?>
