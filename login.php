<?php
session_start();
include('header.php');
include 'config/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - Student Management System</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      background: #f1f5f9;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: #fff;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      width: 320px;
    }

    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      width: 100%;
      padding: 10px;
      background: #2563eb;
      color: #fff;
      border: none;
      border-radius: 4px;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background: #1d4ed8;
    }

    .notification {
      margin-bottom: 1rem;
      padding: 10px;
      background: #fdecea;
      color: #b71c1c;
      border: 1px solid #f5c6cb;
      border-radius: 4px;
    }
  </style>
</head>
<body>
<div class="container">
  <h2>Login</h2>
  <?php if ($error): ?>
      <div class="notification"><?php echo $error; ?></div>
  <?php endif; ?>
  <form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Log In</button>
  </form>
</div>
</body>
</html>
