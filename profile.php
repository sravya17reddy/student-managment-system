<?php
session_start();
include('header.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include('config/db.php');

$user = $_SESSION['username'];

// Fetch user details
$query = $conn->query("SELECT * FROM users WHERE username='$user'");
$userData = $query->fetch_assoc();

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];

    if (!empty($new_username) && !empty($new_password)) {
        $conn->query("UPDATE users SET username='$new_username', password='$new_password' WHERE id=" . $userData['id']);
        $_SESSION['username'] = $new_username;
        $msg = "Profile updated successfully!";
        header("Refresh:0");
    } else {
        $error = "Please fill out all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Your Profile</h2>
    
    <?php if (isset($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" value="<?= $userData['username'] ?>" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" value="<?= $userData['password'] ?>" required><br><br>

        <label>Role:</label><br>
        <input type="text" value="<?= $userData['role'] ?>" disabled><br><br>

        <input type="submit" name="update_profile" value="Update Profile">
    </form>
</div>
</body>
</html>
