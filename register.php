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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Register</title>
    <style>
        /* Header and footer styles to match login.php */
        @import url('https://fonts.cdnfonts.com/css/unbounded');
        @import url('https://fonts.cdnfonts.com/css/steppe-trial');
        
        body {
            background-color: #803d3b;
            font-family: 'Unbounded', sans-serif;
        }

        footer {
            position: fixed;
            bottom: 1;
            width: 100%;
            background-color: transparent;
            color: white;
            text-align: center;
        }

        .app-name {
            text-align: center;
            color: white;
            font-size: 50px;
            font-family: 'Unbounded', sans-serif;
            margin-top: 50px;
        }

        .catchphrase {
            text-align: center;
            color: white;
            font-size: 18px;
            font-style: italic;
            margin-bottom: 30px;
        }

        .login-container {
            max-width: 450px;
            margin: 0 auto;
            background-color: #000000;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px
        }

        .login-container h1 {
            text-align: center;
            color: white;
        }

        .login-form {
            display: flex;
            flex-direction: column;
        }

        .login-form label {
            margin-bottom: 5px;
            color: white;
        }

        .login-form input,
        .login-form select {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn-login {
            background-color: #803d3b;
            border-color: #803d3b;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .btn-login:hover {
    background-color: white;
    color: black;
    border-color: white;
    transform: scale(1.05); /* Reduced scaling */
    transition: transform 0.3s ease, background-color 0.3s ease;
}


        .btn-register {
            display: block;
            text-align: center;
            color: white;
            margin-top: 20px;
            text-decoration: none;
        }

        .btn-register:hover {
            color: #803d3b;
        }

        .error,
        .success {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        h2 {
            text-align: center;
            color: white;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="app-name">Inventora</div>
    <div class="catchphrase">Your gateway to smarter inventory management</div>

    <div class="login-container">
        <h2>Register</h2>
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

    <footer>
        <p>&copy; 2024 Inventora. All rights reserved.</p>
    </footer>
</body>
</html>
