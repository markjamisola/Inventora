<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="welcome">
    <header>
    <h1>Welcome to Inventora Admin <?= $_SESSION['username'] ?></h1>
    </header>

    <main class="main-container">
        <p class="description">Efficiently manage your products, track stock levels, and keep your store organized.</p>
        <nav class="nav-menu">
            <a href="products/list.php" class="btn">Manage Products</a>
        </nav>
    </main>
</div>
    <footer>
        <p>&copy; 2024 Inventora. All rights reserved.</p>
    </footer>
</body>
</html>
