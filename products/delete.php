<?php 
session_start();
include('../db.php'); 
include('../header.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Delete Product</title>
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

        .btn-back {
            margin-top: 20px;
            display: inline-block;
            background-color: #000000;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .btn-back:hover {
            background-color: #FAEED1;
            color: black;
            border-color: #FAEED1;
        }

        .btn {
            background-color: #000000;
            border-color: #000000;
            transition: transform 0.3s ease, background-color 0.3s ease;
            color: white;
        }

        
        .card{
            background-color: #000000;
        }

        .btn:hover {
            background-color: white;
            color: black;
            transform: scale(1.1);
            border-color: white;
        }

        .success, .error {
            color: white;
            font-family: 'Steppe Trial', sans-serif;
            text-align: center;
            margin-top: 20px;
        }

        .success {
            background-color: #28a745;
            padding: 10px;
        }

        .error {
            background-color: #dc3545;
            padding: 10px;
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
                    <h5 class="card-title mb-0">Delete Product</h5>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];

                        try {
                            // Delete the product
                            $stmt = $pdo->prepare('DELETE FROM products WHERE product_id = ?');
                            $stmt->execute([$id]);

                            echo "<p class='success'>Product deleted successfully!</p>";
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


