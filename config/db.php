<?php
$host = 'localhost';
$db = 'student_db'; // make sure this DB exists
$user = 'root';
$pass = ''; // default for XAMPP

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
