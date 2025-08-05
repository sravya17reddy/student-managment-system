<?php
if (!isset($_SESSION)) session_start();
?>

<div style="background: #004080; padding: 10px; color: white;">
    <h2>Student Management System</h2>
    <div style="float: right;">
        Welcome, <?= $_SESSION['username'] ?? 'Guest' ?> |
        <a href="dashboard.php" style="color:white; margin-right:10px;">Dashboard</a>
        <a href="students.php" style="color:white; margin-right:10px;">Students</a>
        <a href="attendance.php" style="color:white; margin-right:10px;">Attendance</a>
        <a href="grades.php" style="color:white; margin-right:10px;">Grades</a>
        <a href="report.php" style="color:white; margin-right:10px;">Report</a>
        <a href="profile.php" style="color:white; margin-right:10px;">Profile</a>
        <a href="logout.php" style="color:white;">Logout</a>
    </div>
</div>
