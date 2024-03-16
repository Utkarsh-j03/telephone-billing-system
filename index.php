<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Telephone Billing System</title>
    <link rel="stylesheet" href="./misc/styles_login.css"><!-- Link your CSS file here -->
</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <section class="login-container">
        <form action="index.php" method="post">
            <h1>Admin Login</h1>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </section>
    <footer>
        <p>&copy; 2024 Telephone Billing System. All rights reserved.</p>
    </footer>
</body>

</html>

<?php
session_start();

// Include database connection code here
include_once 'db_connect.php';

// Admin credentials
$admin_username = "admin_username"; //set your admin username
$admin_password = "admin_password"; //set your admin password

// Handle login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == $admin_username && $password == $admin_password) {
        // Admin login successful
        $_SESSION['admin'] = true;
        header("Location: home.html"); // Redirect to homepage or dashboard
        exit;
    } else {
        // Invalid credentials
        echo "<script>alert('Invalid username or password. Please try again.');</script>";
    }
}
?>