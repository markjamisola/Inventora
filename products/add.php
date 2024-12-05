<?php session_start(); include('../db.php'); ?>
<?php include('../header.php'); ?>

<h1 class="add">Add Product</h1>

<form method="post" class="form">
    <label>
        Product Name: 
        <input type="text" name="product_name" required>
    </label><br>
    <label>
        Category: 
        <input type="text" name="category" required>
    </label><br>
    <label>
        Stock Quantity: 
        <input type="number" name="stock_quantity" min="0" required>
    </label><br>
    <label>
        Price Per Unit: 
        <input type="number" step="0.01" name="price_per_unit" min="0" required>
    </label><br>
    <button type="submit" name="submit" class="btn">Add Product</button>
</form>

<a class="btn-back" href="list.php">Back to Product List</a>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $stock = $_POST['stock_quantity'];
    $price = $_POST['price_per_unit'];

    try {
        $stmt = $pdo->prepare('INSERT INTO products (product_name, category, stock_quantity, price_per_unit) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $category, $stock, $price]);
        echo "<p class='success'>Product added successfully!</p>";
    } catch (PDOException $e) {
        echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<?php include('../footer.php'); ?>
