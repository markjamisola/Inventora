<?php
include('header.php');
session_start();
include('../db.php');

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../staff/staff_dashboard.php');
    exit;
}

// reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    try {
        // Reset total_added and total_removed for the specified product
        $pdo->prepare('UPDATE product_summary SET total_added = 0, total_removed = 0 WHERE product_id = ?')->execute([$product_id]);

        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } catch (PDOException $e) {
        $error_message = "Error resetting data: " . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <title>Admin Dashboard</title>
    <style>
        @import url('https://fonts.cdnfonts.com/css/unbounded');
        @import url('https://fonts.cdnfonts.com/css/steppe-trial');
        .body {
            background-color: #fff;
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
            color: black;
            font-family: 'Steppe Trial', sans-serif;       
                                        
        }

        .table{
            border-color: #000000;
            background-color: #fff;
            text-align: center;
        }

        .table th{
            color: white;
            background-color: #000000;
        }

        .table-hover tbody tr:hover {
            color: black !important; /* Force text color to black */
            background-color: #fff !important; /* Force background color to white */
        }

        .card, .card-header{
            border-color: #803d3b;
            border-radius: 15px;
            background-color: #000000;

        }
        .card-title{
            text-align: left;
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
        
        .crt-btn{
            background-color: #803d3b;
            border-color: #000000;
            transition: transform 0.3s ease, background-color 0.3s ease;
            color: white;
        }

        .crt-btn:hover{
            background-color: #803d3b;
            color: white;
            transform: scale(1.1);
            border-color: white;
        }
        
        .modal-body {
            max-height: 400px;
            overflow-y: auto;
        }
        .modal-header{
            background-color: #000000;
            color: white; 
            text-align: center;
        }

        .modal-content{
            background-color: #000000;
        }
        .btn-close{
            color: white !important; 
        }
        .modal-title{
            text-align: center;
        }

        .btn-close {
            background-color: #ff6f61; /* Set the background color */
            border: none;
            color: white; /* Remove any border */
        }

        .btn-close:hover {
            background-color: #ff6f61; /* Optional: Hover effect */
        }
    </style>
</head>
<body class="body">
<div class="mt-1 p-5">
<div class="my-4">
    <!-- Navigation Links -->
    <div class="d-flex justify-content-between mb-3">
        <a class="btn btn-primary" href="users.php">View Users</a>
        <a class="btn btn-success" href="add.php">Add New Product</a>
    </div>

    <div class="row g-3">

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
                            <th>Total Value</th>
                            <th>History</th> 
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Handle search query
                        $search_query = isset($_GET['search']) ? $_GET['search'] : '';

                        // ILIKE for trigram
                        $stmt = $pdo->prepare('
                            SELECT 
                                product_id, 
                                product_name, 
                                category, 
                                stock_quantity, 
                                price_per_unit, 
                                calculate_stock_value(product_id) AS total_stock_value 
                            FROM 
                                products 
                            WHERE 
                                product_name ILIKE ? OR category ILIKE ? 
                            LIMIT 10
                        ');

                        // gi wrap sa wildcards for pattern matching
                        $stmt->execute(['%' . $search_query . '%', '%' . $search_query . '%']);

                        // Display results
                        while ($row = $stmt->fetch()) {
                            echo "<tr>
                                    <td>{$row['product_name']}</td>
                                    <td>{$row['category']}</td>
                                    <td>{$row['stock_quantity']}</td>
                                    <td>{$row['price_per_unit']}</td>
                                    <td>{$row['total_stock_value']}</td>
                                    <td>
                                        <!-- Adjustment History Button -->
                                        <a class='btn btn-info btn-sm' href='#' data-bs-toggle='modal' data-bs-target='#adjustmentHistoryModal' data-product-id='{$row['product_id']}'>View</a>
                                    </td>
                                    <td class='action-btn'>
                                        <a class='btn btn-sm' href='edit.php?id={$row['product_id']}'>Edit</a>
                                        <a class='btn btn-sm' href='delete.php?id={$row['product_id']}'>X</a>
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

<div class="modal fade" id="adjustmentHistoryModal" tabindex="-1" aria-labelledby="adjustmentHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="adjustmentHistoryModalLabel">Adjustment History</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="adjustmentHistoryContent">
                    <!-- Adjustment history will be loaded here using AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-lg-4">
    <div class="card shadow-sm">
        <div class="card-header bg-black text-white text-center">
            <h5 class="card-title mb-0">Product Summary</h5>
        </div>
        <div class="card-body">
            <?php if (isset($error_message)) : ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <div class="table-container">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Total Added</th>
                            <th>Total Removed</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $summary_stmt = $pdo->query('SELECT product_id, product_name, total_added, total_removed FROM product_summary LIMIT 10');
                        while ($summary_row = $summary_stmt->fetch()) {
                            echo "<tr>
                                    <td>{$summary_row['product_name']}</td>
                                    <td>{$summary_row['total_added']}</td>
                                    <td>{$summary_row['total_removed']}</td>
                                    <td>
                                        <form method='POST' class='d-inline'>
                                            <input type='hidden' name='product_id' value='{$summary_row['product_id']}'>
                                            <button type='submit' class='btn btn-warning btn-sm'>Reset</button>
                                        </form>
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


    <div class="col-lg-8 mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-black text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Critical Stock Products</h5>
                     <!-- Refresh-->
                <form method="POST" action="refresh_mview.php" class="mb-0">
                <button button type="submit" name="refresh" class="crt-btn btn">Refresh</button>
                </form>
            </div>

            <div class="card-body">
 

                <div class="table-container">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Stock Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->query('SELECT product_name, stock_quantity FROM mview_stock_critical');
                            while ($row = $stmt->fetch()) {
                                echo "<tr>
                                        <td>{$row['product_name']}</td>
                                        <td>{$row['stock_quantity']}</td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-black text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Activity Log Summary</h5>
                <a href="activity_logs.php"  class="crt-btn btn">Full Log</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
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
<script>
    // Using Bootstrap's modal event to load adjustment history dynamically
    $('#adjustmentHistoryModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var productId = button.data('product-id'); // Extract product ID
    
    console.log("Product ID: " + productId); 
    
    $.ajax({
        url: 'get_adjustment_history.php',
        type: 'GET',
        data: { product_id: productId },
        success: function (response) {
            console.log(response); 
            $('#adjustmentHistoryContent').html(response);
        },
        error: function (xhr, status, error) {
            console.log("AJAX Error: " + error);
            $('#adjustmentHistoryContent').html('<p>Error fetching adjustment history.</p>');
        }
    });
});

</script>
</body>
</html>

