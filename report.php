<?php
session_start();
include('header.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include('config/db.php');

// Fetch students for dropdown
$studentList = $conn->query("SELECT * FROM students");

// Handle form submit
$reportData = null;
if (isset($_GET['student_id'])) {
    $id = $_GET['student_id'];

    // Student Info
    $student = $conn->query("SELECT * FROM students WHERE id=$id")->fetch_assoc();

    // Attendance Summary
    $attendance = $conn->query("SELECT 
        SUM(CASE WHEN status='Present' THEN 1 ELSE 0 END) AS present_days,
        COUNT(*) AS total_days 
        FROM attendance 
        WHERE student_id=$id")->fetch_assoc();

    // Grades
    $grades = $conn->query("SELECT subject, grade FROM grades WHERE student_id=$id");

    $reportData = [
        'student' => $student,
        'attendance' => $attendance,
        'grades' => $grades
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Report</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .report-box {
            text-align: left;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            max-width: 600px;
            margin: auto;
        }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Student Report Card</h2>
    
    <form method="GET" class="no-print">
        <label>Select Student:</label>
        <select name="student_id" required>
            <option value="">--Choose--</option>
            <?php while ($row = $studentList->fetch_assoc()) { ?>
                <option value="<?= $row['id'] ?>" <?= isset($reportData) && $reportData['student']['id'] == $row['id'] ? 'selected' : '' ?>>
                    <?= $row['name'] ?> (<?= $row['roll_no'] ?>)
                </option>
            <?php } ?>
        </select>
        <input type="submit" value="View Report">
    </form>

    <?php if ($reportData): ?>
    <div class="report-box">
        <h3><?= $reportData['student']['name'] ?> - Report</h3>
        <p><strong>Roll No:</strong> <?= $reportData['student']['roll_no'] ?></p>
        <p><strong>Class:</strong> <?= $reportData['student']['class'] ?></p>

        <h4>Attendance Summary</h4>
        <p>
            Present: <?= $reportData['attendance']['present_days'] ?? 0 ?> / 
            Total: <?= $reportData['attendance']['total_days'] ?? 0 ?>
        </p>

        <h4>Grades</h4>
        <table border="1" cellpadding="8">
            <tr><th>Subject</th><th>Grade</th></tr>
            <?php while ($grade = $reportData['grades']->fetch_assoc()) { ?>
                <tr>
                    <td><?= $grade['subject'] ?></td>
                    <td><?= $grade['grade'] ?></td>
                </tr>
            <?php } ?>
        </table>

        <br class="no-print">
        <button onclick="window.print()" class="no-print">🖨️ Print Report</button>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
