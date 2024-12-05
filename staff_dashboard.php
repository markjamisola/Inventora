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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Staff Dashboard</title>
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

        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }

        .table th, .table td {
            color: white;
            font-family: 'Steppe Trial', sans-serif;
            background-color: #803d3b;
        }

        .table td:hover {
            color: white;
            font-family: 'Steppe Trial', sans-serif;
            background-color: #803d3b;
        }

        .table{
            border-color: #000000;
            background-color: #803d3b;
        }
        .card{
            background-color: #000000;
        }

        .table th {
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
            transform: scale(1.1);
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
    </style>
</head>
<body class="body">

    <div class="container mt-5">
        <div class="my-4">
            <div class="card shadow-sm">
                <div class="card-header bg-black text-white text-center">
                    <h5 class="card-title mb-0">Product List</h5>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form method="GET" action="" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>

                    <div class="table-container">
                        <table class="table table-bordered table-hover">
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
                                 // Handle search query
                                 $search_query = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
                                 // Fetch products based on the search term
                                 $stmt = $pdo->prepare('SELECT * FROM products WHERE product_name LIKE ? OR category LIKE ? LIMIT 10');
                                 $stmt->execute([$search_query, $search_query]);

                                 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                     echo "<tr>
                                             <td>{$row['product_name']}</td>
                                             <td>{$row['category']}</td>
                                             <td>{$row['stock_quantity']}</td>
                                             <td>{$row['price_per_unit']}</td>
                                             <td>
                                                 <a class='btn btn-sm' href='update_stock.php?id={$row['product_id']}'>Update</a>
                                             </td>
                                           </tr>";
                                 }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html>
