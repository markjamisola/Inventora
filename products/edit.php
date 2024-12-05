
<?php 
session_start();
include('../db.php'); 
include('../header.php'); 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the product to edit
    $stmt = $pdo->prepare('SELECT * FROM products WHERE product_id = ?');
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "<p class='error'>Product not found!</p>";
        exit;
    }
}

if (isset($_POST['submit'])) {
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $stock = $_POST['stock_quantity'];
    $price = $_POST['price_per_unit'];

    try {
        $stmt = $pdo->prepare('UPDATE products SET product_name = ?, category = ?, stock_quantity = ?, price_per_unit = ? WHERE product_id = ?');
        $stmt->execute([$name, $category, $stock, $price, $id]);

        echo "<p class='success'>Product updated successfully!</p>";
    } catch (PDOException $e) {
        echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<h1 class="add">Edit Product</h1>

<form method="post" class="form">
    <label>
        Product Name: 
        <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>
    </label><br>
    <label>
        Category: 
        <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" required>
    </label><br>
    <label>
        Stock Quantity: 
        <input type="number" name="stock_quantity" value="<?= htmlspecialchars($product['stock_quantity']) ?>" min="0" required>
    </label><br>
    <label>
        Price Per Unit: 
        <input type="number" step="0.01" name="price_per_unit" value="<?= htmlspecialchars($product['price_per_unit']) ?>" min="0" required>
    </label><br>
    <button type="submit" name="submit" class="btn">Update Product</button>
</form>

<a class="btn-back" href="list.php">Back to Product List</a>

<?php include('../footer.php'); ?>
