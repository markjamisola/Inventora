<?php
session_start();
include('../db.php');

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'staff')) {
    echo "You do not have permission to update stock.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['new_stock_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_stock_quantity = $_POST['new_stock_quantity'];
    $user_id = $_SESSION['user_id'];  // Get the logged-in user's ID

    try {
        // Update the stock quantity
        $stmt = $pdo->prepare('UPDATE products SET stock_quantity = ? WHERE product_id = ?');
        $stmt->execute([$new_stock_quantity, $product_id]);

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            echo "Stock updated successfully!";
        } else {
            echo "No changes made to the stock.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
