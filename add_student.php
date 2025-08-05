<?php
session_start();
include('header.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include('config/db.php');

// Insert student
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $roll = $_POST['roll'];
    $class = $_POST['class'];

    $sql = "INSERT INTO students (name, roll_no, class) VALUES ('$name', '$roll', '$class')";
    if ($conn->query($sql) === TRUE) {
        $msg = "Student added successfully!";
    } else {
        $msg = "Error: " . $conn->error;
    }
}

// Fetch students
$students = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Add Student</h2>
    <?php if (isset($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Student Name" required><br><br>
        <input type="text" name="roll" placeholder="Roll Number" required><br><br>
        <input type="text" name="class" placeholder="Class" required><br><br>
        <input type="submit" value="Add Student">
    </form>

    <h3>Existing Students</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Roll No</th>
            <th>Class</th>
        </tr>
        <?php while ($row = $students->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['roll_no'] ?></td>
                <td><?= $row['class'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
