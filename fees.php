<!-- fees.php -->
<?php 
include('header.php'); 
include('db_config.php');

// Handle form submission to add a new fee record
if (isset($_POST['submit'])) {
    $studentID = $_POST['studentID'];
    $amount = $_POST['amount'];
    $dueDate = $_POST['dueDate'];
    $paymentStatus = $_POST['paymentStatus'];
    $scholarshipID = $_POST['scholarshipID'];

    $query = "INSERT INTO Fee (StudentID, Amount, DueDate, PaymentStatus, ScholarshipID)
              VALUES ($studentID, $amount, '$dueDate', '$paymentStatus', $scholarshipID)";
    
    if (mysqli_query($conn, $query)) {
        echo "New fee transaction added successfully!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Fetch fees
$sql = "SELECT F.FeeID, S.Name AS StudentName, F.Amount, F.DueDate, F.PaymentStatus, Sc.Name AS Scholarship
        FROM Fee F
        JOIN Student S ON F.StudentID = S.StudentID
        LEFT JOIN Scholarship Sc ON F.ScholarshipID = Sc.ScholarshipID";
$result = mysqli_query($conn, $sql);

$students = mysqli_query($conn, "SELECT StudentID, Name FROM Student");
$scholarships = mysqli_query($conn, "SELECT ScholarshipID, Name FROM Scholarship");
?>

<h2>Manage Fees</h2>

<form method="post" action="fees.php">
    <label for="studentID">Student:</label>
    <select name="studentID" required>
        <?php while ($row = mysqli_fetch_assoc($students)): ?>
            <option value="<?php echo $row['StudentID']; ?>"><?php echo $row['Name']; ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label for="amount">Amount:</label>
    <input type="number" name="amount" required><br><br>

    <label for="dueDate">Due Date:</label>
    <input type="date" name="dueDate" required><br><br>

    <label for="paymentStatus">Payment Status:</label>
    <input type="text" name="paymentStatus" required><br><br>

    <label for="scholarshipID">Scholarship:</label>
    <select name="scholarshipID">
        <option value="">None</option>
        <?php while ($row = mysqli_fetch_assoc($scholarships)): ?>
            <option value="<?php echo $row['ScholarshipID']; ?>"><?php echo $row['Name']; ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <button type="submit" name="submit">Add Fee</button>
</form>

<h3>Fee List</h3>
<table border="1">
    <tr>
        <th>Fee ID</th>
        <th>Student Name</th>
        <th>Amount</th>
        <th>Due Date</th>
        <th>Payment Status</th>
        <th>Scholarship</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['FeeID']; ?></td>
        <td><?php echo $row['StudentName']; ?></td>
        <td><?php echo $row['Amount']; ?></td>
        <td><?php echo $row['DueDate']; ?></td>
        <td><?php echo $row['PaymentStatus']; ?></td>
        <td><?php echo $row['Scholarship']; ?></td>
        <td>
           
