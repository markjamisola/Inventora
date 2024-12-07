<?php 
session_start();
include('../db.php'); 
include('header.php'); 

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../staff/staff_dashboard.php');
    exit;
}


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
            background-color: white;
            font-family: 'Unbounded', sans-serif;
        }

        .card-body, .card-header {
            background-color: #000000;
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1), 0px 10px 50px rgba(0, 0, 0, 0.15);
            border-color: #803d3b;
        }

        .card, .card-body, .card-header {
            background-color: #000000; /* Card background */
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.7), 0px 4px 10px rgba(50, 50, 50, 0.5); /* Black/gray shadow */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Add smooth hover effect */
            border-color: #000000;
        }

        .card:hover {
            transform: translateY(-5px); /* Elevate on hover */
            box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.9), 0px 6px 15px rgba(50, 50, 50, 0.7); /* More prominent shadow on hover */
        }

        .form label {
            color: white;
            font-family: 'Unbounded', sans-serif;
            font-size: 20px;
        }

        .form{
            margin: 20px;
        }

        .form input {
            background-color: #803d3b;
            color: white;
            border: 1px solid #000;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
        }

        table{
            text-align: center;
        }

        .btn{
            background-color: #000000;
            border-color: #000000;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.7), 0px 4px 10px rgba(50, 50, 50, 0.5); /* Black/gray shadow */
            transition: transform 0.3s ease, background-color 0.3s ease;
            color: white;
        }

        .btn:hover{
            background-color: #803d3b;
            color: white;
            transform: scale(1.1);
            border-color: white;
            box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.9), 0px 6px 15px rgba(50, 50, 50, 0.7); /* More prominent shadow on hover */
        }

        .btn-back {
            margin-top: 20px;
            display: inline-block;
            background-color: #803d3b;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .btn-back:hover {
            background-color: white;
            color: black;
            border-color: white;
        }

        .update-btn {
            display: block;
            width: 200px;
            margin: auto;
            padding: 10px 20px;
            text-align: center;
            background-color: #803d3b;
            margin-top: 20px
        }

        .update-btn:hover {
            background-color: #803d3b;
        }

        .success, .error {
            color: #803d3b;
            font-family: 'Unbounded', sans-serif;
            text-align: center;
            margin-top: 20px;
        }

        .success {
            background-color: transparent;
            padding-top: 10px;
        }

        .error {
            background-color: transparent;
            padding: 10px;
        }
    </style>
</head>
<body class="body">
    <div class="container mt-5">
        <div class="my-4">
            <div class="d-flex justify-content-between mb-3">
                <a class="btn btn-primary" href="admin_dashboard.php">Back to Home</a>
                <a class="btn btn-success" href="list.php">Back to List</a>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-black text-white text-center">
                    <h5 class="card-title mb-0">Edit Product</h5>
                </div>
                <div class="card-body">
    <form method="POST" class="form">
        <div class="row mb-3">
            <label for="product_name" class="col-sm-3 col-form-label text-white">Product Name:</label>
            <div class="col-sm-9">
                <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($product['product_name']) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="category" class="col-sm-3 col-form-label text-white">Category:</label>
            <div class="col-sm-9">
                <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($product['category']) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="stock_quantity" class="col-sm-3 col-form-label text-white">Stock Quantity:</label>
            <div class="col-sm-9">
                <input type="number" name="stock_quantity" class="form-control" value="<?= htmlspecialchars($product['stock_quantity']) ?>" min="0" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="price_per_unit" class="col-sm-3 col-form-label text-white">Price Per Unit:</label>
            <div class="col-sm-9">
                <input type="number" step="0.01" name="price_per_unit" class="form-control" value="<?= htmlspecialchars($product['price_per_unit']) ?>" min="0" required>
            </div>
        </div>
        <div class="text-center">
        <button type="submit" name="submit" class="btn btn-primary update-btn">Update Product</button>
    </div>
    </form>
</div>
            </div>
            
        </div>
    </div>
</body>
</html>

