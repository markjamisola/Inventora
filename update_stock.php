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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Update Stock</title>
    <style>
        @import url('https://fonts.cdnfonts.com/css/unbounded');
        @import url('https://fonts.cdnfonts.com/css/steppe-trial');
        body {
            background-color: #803d3b;
            font-family: 'Unbounded', sans-serif;
        }
        .card-body, .card-header {
            background-color: #000000;
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1), 0px 10px 50px rgba(0, 0, 0, 0.15);
            border-color: #803d3b;
        }
        p {
            color: white;
        }
        .card {
            background-color: #000000;
        }
        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }
        .table td {
            color: white;
            font-family: 'Steppe Trial', sans-serif;
            background-color: #803d3b;
        }
        .table td:hover {
            color: white;
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
            transform: scale(1.05);
            border-color: white;
        }
        .btn-back {
            background-color: #000000;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn-back:hover {
            background-color: #FAEED1;
            color: black;
        }

        label {
            color:white;
            font-size: 20px;
        }

        .update-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px 20px;
            text-align: center;
            background-color: #803d3b;
        }
        
    </style>
</head>
<body class="body">
<div class="mt-5 p-5">
    <div class="my-4">
        <!-- Navigation Links -->
        <div class="d-flex justify-content-between mb-3">
            <a class="btn btn-primary" href="staff_dashboard.php">Back to Product List</a>
        </div>

        <!-- Update Stock Form -->
        <div class="card shadow-sm">
            <div class="card-header bg-black text-white text-center">
                <h5 class="card-title mb-0">Update Stock for <?php echo htmlspecialchars($product['product_name']); ?></h5>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label>Current Stock: <?php echo htmlspecialchars($product['stock_quantity']); ?></label><br>
                        <label for="new_stock_quantity">New Stock Quantity:</label>
                        <input type="number" name="new_stock_quantity" id="new_stock_quantity" min="0" required class="form-control">
                    </div>
                    <button type="submit" name="submit" class="btn update-btn">Update Stock</button>
                </form>

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
            </div>
        </div>
    </div>
</div>
</body>
</html>
