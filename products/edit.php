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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Edit Product</title>
    <style>
        @import url('https://fonts.cdnfonts.com/css/unbounded');
        @import url('https://fonts.cdnfonts.com/css/steppe-trial');
        .body {
            background-color: #803d3b;
            font-family: 'Unbounded', sans-serif;
        }

        .card-body, .card-header {
            background-color: #000000;
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1), 0px 10px 50px rgba(0, 0, 0, 0.15);
            border-color: #803d3b;
        }

        .card{
            background-color: #000000;
        }

        .form label {
            color: white;
            font-family: 'Steppe Trial', sans-serif;
        }

        .form input {
            background-color: #803d3b;
            color: white;
            border: 1px solid #000;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
        }

        .btn {
            background-color: #000000;
            border-color: #000000;
            transition: transform 0.3s ease, background-color 0.3s ease;
            color: white;
        }

        .btn:hover {
            background-color: white;
            color: black;
            transform: scale(1.1);
            border-color: white;
        }

        .btn-back {
            margin-top: 20px;
            display: inline-block;
            background-color: #000000;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .btn-back:hover {
            background-color: white;
            color: black;
            border-color: white;
        }
    </style>
</head>
<body class="body">
    <div class="container mt-5">
        <div class="my-4">
            <div class="d-flex justify-content-between mb-3">
                <a class="btn btn-primary" href="../admin_dashboard.php">Back to Home</a>
                <a class="btn btn-success" href="list.php">Back to Product List</a>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-black text-white text-center">
                    <h5 class="card-title mb-0">Edit Product</h5>
                </div>
                <div class="card-body">
                    <form method="POST" class="form">
                        <label for="product_name">Product Name:</label>
                        <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required><br>

                        <label for="category">Category:</label>
                        <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" required><br>

                        <label for="stock_quantity">Stock Quantity:</label>
                        <input type="number" name="stock_quantity" value="<?= htmlspecialchars($product['stock_quantity']) ?>" min="0" required><br>

                        <label for="price_per_unit">Price Per Unit:</label>
                        <input type="number" step="0.01" name="price_per_unit" value="<?= htmlspecialchars($product['price_per_unit']) ?>" min="0" required><br>

                        <button type="submit" name="submit" class="btn justify-content-center mt-3">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

