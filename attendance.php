<?php
session_start();
include('header.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include('config/db.php');

// Fetch students
$students = $conn->query("SELECT * FROM students");

// Insert attendance
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mark_attendance'])) {
    $date = $_POST['date'];
    foreach ($_POST['attendance'] as $student_id => $status) {
        $conn->query("INSERT INTO attendance (student_id, status, date) VALUES ('$student_id', '$status', '$date')");
    }
    $msg = "Attendance marked successfully!";
}

// Fetch past attendance
$attendance_records = $conn->query("
    SELECT a.id, s.name, s.roll_no, s.class, a.status, a.date
    FROM attendance a
    JOIN students s ON a.student_id = s.id
    ORDER BY a.date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Mark Attendance</h2>
    <?php if (isset($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
    <form method="POST">
        <label>Date:</label>
        <input type="date" name="date" required><br><br>
        <table border="1" cellpadding="8">
            <tr>
                <th>Student</th>
                <th>Roll No</th>
                <th>Class</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $students->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['roll_no'] ?></td>
                    <td><?= $row['class'] ?></td>
                    <td>
                        <select name="attendance[<?= $row['id'] ?>]">
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                        </select>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <input type="submit" name="mark_attendance" value="Submit Attendance">
    </form>

    <h3>Attendance Records</h3>
    <table border="1" cellpadding="8">
        <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Roll No</th>
            <th>Class</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $attendance_records->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['date'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['roll_no'] ?></td>
                <td><?= $row['class'] ?></td>
                <td><?= $row['status'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
