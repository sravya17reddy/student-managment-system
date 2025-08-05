<?php
session_start();
include('header.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include('config/db.php');

// Get all students
$students = $conn->query("SELECT * FROM students");

// Insert Grades
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_grades'])) {
    foreach ($_POST['grades'] as $student_id => $details) {
        $subject = $details['subject'];
        $grade = $details['grade'];
        $conn->query("INSERT INTO grades (student_id, subject, grade) VALUES ('$student_id', '$subject', '$grade')");
    }
    $msg = "Grades submitted successfully!";
}

// Fetch Grades
$grades = $conn->query("
    SELECT g.id, s.name, s.roll_no, g.subject, g.grade
    FROM grades g
    JOIN students s ON g.student_id = s.id
    ORDER BY g.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Grades</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Enter Grades</h2>
    <?php if (isset($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
    <form method="POST">
        <table border="1" cellpadding="8">
            <tr>
                <th>Student</th>
                <th>Subject</th>
                <th>Grade</th>
            </tr>
            <?php while ($row = $students->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['name'] ?> (<?= $row['roll_no'] ?>)</td>
                    <td><input type="text" name="grades[<?= $row['id'] ?>][subject]" required></td>
                    <td><input type="text" name="grades[<?= $row['id'] ?>][grade]" required></td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <input type="submit" name="submit_grades" value="Submit Grades">
    </form>

    <h3>Grade Records</h3>
    <table border="1" cellpadding="8">
        <tr>
            <th>Student</th>
            <th>Roll No</th>
            <th>Subject</th>
            <th>Grade</th>
        </tr>
        <?php while ($row = $grades->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['roll_no'] ?></td>
                <td><?= $row['subject'] ?></td>
                <td><?= $row['grade'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
