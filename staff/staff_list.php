<?php 
session_start();
include('../db.php'); 
include('staff_header.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header('Location: login.php');
    exit;
}

if ($_SESSION['role'] !== 'staff') {
    header('Location: ../admin/admin_dashboard.php');
    exit;
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
    <title>Staff Dashboard</title>
    <style>
        @import url('https://fonts.cdnfonts.com/css/unbounded');
        @import url('https://fonts.cdnfonts.com/css/steppe-trial');
        .body {
            background-color: white;
            font-family: 'Unbounded', sans-serif;
        }

        .card, .card-body, .card-header {
            background-color: #000000; 
            border-radius: 15px; 
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.7), 0px 4px 10px rgba(50, 50, 50, 0.5); 
            transition: transform 0.3s ease, box-shadow 0.3s ease; 
            border-color: #000000;

        }

        .container{
            padding-top: 100px;
        }

        .card:hover {
            transform: translateY(-5px); /* Elevate on hover */
            box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.9), 0px 6px 15px rgba(50, 50, 50, 0.7);
        }


        .table-container {
            max-height: 400px;
            overflow-y: auto;
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
            color: black !important;
            background-color: #fff !important; 
        }
        .card{
            background-color: #000000;
        }

        .table th {
            color: white;
        }

        .btn{
            background-color: #000000;
            border-color: #000000;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.7), 0px 4px 10px rgba(50, 50, 50, 0.5); 
            transition: transform 0.3s ease, background-color 0.3s ease;
            color: white;
        }

        .btn:hover{
            background-color: #803d3b;
            color: white;
            transform: scale(1.05);
            border-color: white;
            box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.9), 0px 6px 15px rgba(50, 50, 50, 0.7); 
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

        .modal-body{
            padding:20px
        }

        .modal-header{
            background-color: #000000;
            color: white; 
            text-align: center;
        }
        
        .modal-title{
            text-align: center;
        }
        .form label{
            text-align:center;
        }

        .btn-close {
            background-color: #ff6f61;
            border: none;
            color: white; 
        }

        .btn-close:hover {
            background-color: #ff6f61;
        }

        .form label {
            font-family: 'Unbounded', sans-serif;
            font-size: 20px;
        }

        .current{
            color: #ff6f61;
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
                                                 <button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#updateStockModal' data-product-id='{$row['product_id']}' data-product-name='{$row['product_name']}' data-stock-quantity='{$row['stock_quantity']}'>Update</button>
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

    <!-- Modal for updating stock -->
    <div class="modal fade" id="updateStockModal" tabindex="-1" aria-labelledby="updateStockModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title" id="updateStockModalLabel ">Update Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateStockForm">
                        <div class="mb-3">
                            <label for="productName" class="form-label d-flex justify-content-center">Product Name</label>
                            <p id="productName" class=" current text-center"></p> 
                        </div>
                        <div class="mb-3">
                            <label for="currentStock" class="form-label d-flex justify-content-center">Current Stock</label>
                            <p id="currentStock" class=" current text-center"></p> 
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" id="decrementStock">-</button>
                            <input type="number" id="newStock" class="form-control text-center" value="0" readonly>
                            <button type="button" class="btn btn-success" id="incrementStock">+</button>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Stock</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex justify-content-center" id="successModalLabel">Success</h5>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <p>Stock updated successfully!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn mx-auto  d-flex justify-content-center" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle the modal data population and stock updates
        document.addEventListener('DOMContentLoaded', function () {
        var updateStockModal = document.getElementById('updateStockModal');
        updateStockModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var productId = button.getAttribute('data-product-id');
            var productName = button.getAttribute('data-product-name');
            var stockQuantity = button.getAttribute('data-stock-quantity');

            var productNameElement = document.getElementById('productName');
            var currentStockElement = document.getElementById('currentStock');
            var newStockInput = document.getElementById('newStock');

            productNameElement.textContent = productName;  // Set product name
            currentStockElement.textContent = stockQuantity;  // Set current stock
            newStockInput.value = stockQuantity;  // Set new stock field to current stock value
        });

        // Increment stock
        document.getElementById('incrementStock').addEventListener('click', function () {
            var newStockInput = document.getElementById('newStock');
            newStockInput.value = parseInt(newStockInput.value) + 1;
        });

        // Decrement stock
        document.getElementById('decrementStock').addEventListener('click', function () {
            var newStockInput = document.getElementById('newStock');
            if (parseInt(newStockInput.value) > 0) {
                newStockInput.value = parseInt(newStockInput.value) - 1;
            }
        });

    // Handle the stock update form submission
    document.getElementById('updateStockForm').addEventListener('submit', function (e) {
        e.preventDefault();

        var newStock = document.getElementById('newStock').value;
        var productId = document.querySelector('[data-product-id]').getAttribute('data-product-id');

        // Use AJAX to send the stock update request to the server
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_stock.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Show success modal
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
                // Close the update modal after success
                var updateStockModal = bootstrap.Modal.getInstance(document.getElementById('updateStockModal'));
                updateStockModal.hide();
                // Refresh the page after a while
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            }
        };
        xhr.send('product_id=' + productId + '&new_stock_quantity=' + newStock);
    });
});

    </script>

</body>
</html>
