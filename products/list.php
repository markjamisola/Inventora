<?php include('../header.php'); ?>
<?php session_start(); include('../db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Admin Dashboard</title>
    <style>
        @import url('https://fonts.cdnfonts.com/css/unbounded');
        @import url('https://fonts.cdnfonts.com/css/steppe-trial');
        .body {
            background-color: #803d3b;
            font-family: 'Unbounded', sans-serif;
        }
        /* Override Bootstrap defaults */
        .card-body,.card-header {
            background-color: #000000; /* Apply the custom background color */
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1), 0px 10px 50px rgba(0, 0, 0, 0.15);
            border-color: #803d3b;
        }
        .table-responsive {
            overflow-x: auto; /* Make tables scrollable on smaller screens */
        }

        /* Add scrollable table body */
        .table-container {
            max-height: 400px; /* Adjust height as needed */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .table td{
            color: white;
            font-family: 'Steppe Trial', sans-serif;       
            background-color: #803d3b;                                 
        }

        .table{
            border-color: #000000;
            background-color: #803d3b;
        }

        .table th{
            color: white;
        }

        .card, .card-header{
            border-color: #803d3b;
            border-radius: 15px;
            background-color: #000000;
        }

        .btn{
            background-color: #000000;
            border-color: #000000;
            transition: transform 0.3s ease, background-color 0.3s ease;
            color: white;
        }

        .btn:hover{
            background-color: white;
            color: black;
            transform: scale(1.1);
            border-color: white;
        }
        
        
    </style>
</head>
<body class="body">
<div class="mt-1 p-5">
<div class="my-4">
    <!-- Navigation Links -->
    <div class="d-flex justify-content-between mb-3">
        <a class="btn btn-primary" href="../admin_dashboard.php">Back to Home</a>
        <a class="btn btn-success" href="add.php">Add New Product</a>
    </div>

    <!-- Main Content -->
    <div class="row g-3">
        <!-- Product List -->
        <div class="col-lg-8">
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
                                    <th>Stock</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Handle search query
                                $search_query = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
                                $stmt = $pdo->prepare('SELECT * FROM products WHERE product_name LIKE ? OR category LIKE ? LIMIT 10');
                                $stmt->execute([$search_query, $search_query]);

                                // Display results
                                while ($row = $stmt->fetch()) {
                                    echo "<tr>
                                            <td>{$row['product_name']}</td>
                                            <td>{$row['category']}</td>
                                            <td>{$row['stock_quantity']}</td>
                                            <td>{$row['price_per_unit']}</td>
                                            <td class='action-btn'>
                                                <a class='btn btn-sm' href='edit.php?id={$row['product_id']}'>Edit</a>
                                                <a class='btn btn-sm' href='delete.php?id={$row['product_id']}'>Delete</a>
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

        <!-- Product Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-black text-white text-center">
                    <h5 class="card-title mb-0">Product Summary</h5>
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Stock Quantity</th>
                                    <th>Total Added</th>
                                    <th>Total Removed</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $summary_stmt = $pdo->query('SELECT product_name, stock_quantity, total_added, total_removed FROM product_summary LIMIT 10');
                                while ($summary_row = $summary_stmt->fetch()) {
                                    echo "<tr>
                                            <td>{$summary_row['product_name']}</td>
                                            <td>{$summary_row['stock_quantity']}</td>
                                            <td>{$summary_row['total_added']}</td>
                                            <td>{$summary_row['total_removed']}</td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-black text-white text-center">
                    <h5 class="card-title mb-0">Activity Log Summary</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>User Type</th>
                                    <th>Total Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $log_stmt = $pdo->query('SELECT username, user_type, total_actions FROM activity_log_summary');
                                while ($log_row = $log_stmt->fetch()) {
                                    echo "<tr>
                                            <td>{$log_row['username']}</td>
                                            <td>{$log_row['user_type']}</td>
                                            <td>{$log_row['total_actions']}</td>
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
</div>
<!-- Modal for Adding Product -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form inside the modal -->
        <form id="addProductForm" method="POST">
            <label>
                Product Name: 
                <input type="text" name="product_name" required class="form-control">
            </label><br>
            <label>
                Category: 
                <input type="text" name="category" required class="form-control">
            </label><br>
            <label>
                Stock Quantity: 
                <input type="number" name="stock_quantity" min="0" required class="form-control">
            </label><br>
            <label>
                Price Per Unit: 
                <input type="number" step="0.01" name="price_per_unit" min="0" required class="form-control">
            </label><br>
            <button type="submit" name="submit" class="btn btn-primary">Add Product</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
</body>
</html>

