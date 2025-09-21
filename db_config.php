<?php
// db_config.php
$servername = 'elvisdb.rowan.edu';
$username = 'usaidk28';
$password = '117LoveDatabases!!';
$databasename = 'usaidk28';

$conn = mysqli_connect($host, $user, $pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully to the database!";
?>
