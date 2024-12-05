<?php 
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
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
    <title>Inventora</title>
</head>
<body>
    <header>
        <h1>Inventora</h1>
    </header>

    <main class="main-container">
        <p class="description">Efficiently manage your products, track stock levels, and keep your store organized.</p>
        <nav class="nav-menu">
            <a href="products/list.php" class="btn">Manage Products</a>
        </nav>
        <a href="logout.php">Logout</a>
    </main>

    <footer>
        <p>&copy; 2024 JUM Store Inventory System. All rights reserved.</p>
    </footer>
</body>
</html>
