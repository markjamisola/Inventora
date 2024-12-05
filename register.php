<?php
include('db.php');

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Password hashing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
        $stmt->execute([$username, $hashed_password, $role]);
        echo "<p class='success'>Registration successful! You can now <a href='login.php'>log in</a>.</p>";
    } catch (PDOException $e) {
        echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Register</title>
</head>
<body class="login-bg">
    <div class="login-container">
        <h1>Register</h1>
        <form method="post" class="login-form">
        <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
            </select>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit" name="register" class="btn-login">Register</button>
        </form>
        <a class="btn-register" href="login.php">Back to Login</a>
    </div>
</body>
</html>

