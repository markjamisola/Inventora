<?php 
session_start();
include('db.php');
include('staff_header.php');

// Check if user is logged in and has the 'staff' role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['new_stock_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_stock_quantity = $_POST['new_stock_quantity'];

    try {
        $stmt = $pdo->prepare('UPDATE products SET stock_quantity = ? WHERE product_id = ?');
        $stmt->execute([$new_stock_quantity, $product_id]);
        echo "Stock updated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
