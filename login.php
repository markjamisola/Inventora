<?php
include('db.php');
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header('Location: admin_dashboard.php');
            } else if ($user['role'] === 'staff') {
                header('Location: staff_dashboard.php');
            }
            exit;
        } else {
            echo "<p class='error'>Invalid username or password!</p>";
        }
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
    <title>Login</title>
    <style>
        /* Header and footer styles to match list.php */
        @import url('https://fonts.cdnfonts.com/css/unbounded');
        @import url('https://fonts.cdnfonts.com/css/steppe-trial');
        
        body {
            background-color: white;
            font-family: 'Unbounded', sans-serif;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: transparent;
            color: black;
            text-align: center;
            padding: 10px;
        }

        .app-name {
            text-align: center;
            color: black;
            font-size: 50px;
            font-family: 'Unbounded', sans-serif;
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            color: white;
        }

        .catchphrase {
            text-align: center;
            color: black;
            font-size: 18px;
            font-style: italic;
            margin-bottom: 30px;
        }

        .login-container {
            max-width: 450px;
            margin: 0 auto;
            background-color: #000000;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.7), 0px 4px 10px rgba(50, 50, 50, 0.5); /* Black/gray shadow */
        }

        .login-container h1 {
            text-align: center;
            color: black;
        }

        .login-form {
            display: flex;
            flex-direction: column;
        }

        .login-form label {
            margin-bottom: 5px;
            color: white;
        }

        .login-form input {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #803d3b;
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

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="app-name">Inventora</div>
    <div class="catchphrase">Your gateway to smarter inventory management</div>

    <div class="login-container">
        <h2>Login</h2>
        <form method="post" class="login-form">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" name="login" class="btn-login">Login</button>
        </form>
        <a class="btn-register" href="register.php">Don't have an account? Register</a>
    </div>

    <footer>
        <p>&copy; 2024 Inventora. All rights reserved.</p>
    </footer>
</body>
</html>
