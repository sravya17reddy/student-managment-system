<?php
session_start();
include('header.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include('config/db.php');

$username = $_SESSION['username'];
$role = $_SESSION['role'];

// Handle sending notification
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_notification'])) {
    $title = $_POST['title'];
    $message = $_POST['message'];
    $sender = $_SESSION['username'];
    $conn->query("INSERT INTO notifications (title, message, sender) VALUES ('$title', '$message', '$sender')");
    $msg = "Notification sent!";
}

// Fetch all notifications
$notifications = $conn->query("SELECT * FROM notifications ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Notifications</h2>
    
    <?php if ($role == 'admin' || $role == 'teacher') { ?>
        <form method="POST">
            <label>Title:</label>
            <input type="text" name="title" required><br><br>

            <label>Message:</label>
            <textarea name="message" required></textarea><br><br>

            <input type="submit" name="send_notification" value="Send Notification">
        </form>
        <br>
    <?php } ?>

    <?php if (isset($msg)) echo "<p style='color:green;'>$msg</p>"; ?>

    <h3>All Notifications</h3>
    <table border="1" cellpadding="8">
        <tr>
            <th>Title</th>
            <th>Message</th>
            <th>Sender</th>
            <th>Timestamp</th>
        </tr>
        <?php while ($row = $notifications->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['title'] ?></td>
                <td><?= $row['message'] ?></td>
                <td><?= $row['sender'] ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
