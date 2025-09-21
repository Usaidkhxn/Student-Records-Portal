<!-- delete_course.php -->
<?php
include('db_config.php');

if (isset($_GET['id'])) {
    $courseID = $_GET['id'];
    $deleteQuery = "DELETE FROM Course WHERE CourseID = $courseID";
    
    if (mysqli_query($conn, $deleteQuery)) {
        echo "Course deleted successfully!";
        header("Location: courses.php");
    } else {
        echo "Error deleting course: " . mysqli_error($conn);
    }
}
?>
