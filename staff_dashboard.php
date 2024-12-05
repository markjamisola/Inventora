<?php 
session_start();
include('db.php');  // Adjusted path
include('staff_header.php');  // Adjusted path

// Check if user is logged in and has the 'staff' role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">  <!-- Add this line to inherit styles -->
    <title>Staff Dashboard</title>
</head>
<body>

<h1 class="add">Staff Product Dashboard</h1>

<h2 class="add">Product List</h2>
<table class="table">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Category</th>
            <th>Stock Quantity</th>
            <th>Price Per Unit</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch products
        $stmt = $pdo->query('SELECT * FROM products');
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['product_name']}</td>
                    <td>{$row['category']}</td>
                    <td>{$row['stock_quantity']}</td>
                    <td>{$row['price_per_unit']}</td>
                    <td>
                        <a class='btn-edit' href='update_stock.php?id={$row['product_id']}'>Update</a>
                    </td>
                  </tr>";
        }
        ?>
    </tbody>
</table>


<?php include('footer.php'); ?>

</body>
</html>
