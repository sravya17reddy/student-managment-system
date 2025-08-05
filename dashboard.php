<?php
session_start();
include('header.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?> 👋</h1>
        <nav>
            <a href="add_student.php">Add Student</a>
            <a href="attendance.php">Attendance</a>
            <a href="grades.php">Grades</a>
            <a href="notifications.php">Notifications</a>
            <a href="logout.php" class="logout">Logout</a>
        </nav>
    </div>
</body>
</html>
