
<?php
session_start();
include('db.php');
include('staff_header.php');
// Check if user is logged in and has the 'staff' role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header('Location: login.php');
    exit;
}

$product_id = $_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM products WHERE product_id = ?');
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">  <!-- Add this line to inherit styles -->
    <title>Update Stock</title>
</head>
<body>

<h1 class="add">Update Stock for <?php echo htmlspecialchars($product['product_name']); ?></h1>

<form method="post" class="form">
    <label>Current Stock: <?php echo htmlspecialchars($product['stock_quantity']); ?></label><br>
    <label>New Stock Quantity:
        <input type="number" name="new_stock_quantity" min="0" required>
    </label><br>
    <button type="submit" name="submit" class="btn">Update Stock</button>
</form>

<a class="btn-back" href="staff_dashboard.php">Back to Product List</a>
<?php
if (isset($_POST['submit'])) {
    $new_stock = $_POST['new_stock_quantity'];

    try {
        $stmt = $pdo->prepare('UPDATE products SET stock_quantity = ? WHERE product_id = ?');
        $stmt->execute([$new_stock, $product_id]);

        echo "<p class='success'>Stock updated successfully!</p>";
    } catch (PDOException $e) {
        echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
    }
}

?>

<?php include('footer.php'); ?>

</body>
</html>
