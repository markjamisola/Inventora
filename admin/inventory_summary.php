<?php 
session_start(); 
include('../db.php'); 
include('header.php'); 
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../staff/staff_dashboard.php');
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
    <title>Inventory Summary</title>
    <style>
        @import url('https://fonts.cdnfonts.com/css/unbounded');
        .body {
            background-color: white;
            font-family: 'Unbounded', sans-serif;
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

        .table {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            padding: 20px;
        }

        .table-container {
            max-height: 400px;
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .table th {
            color: white;
            background-color: #000000;
        }

        .table th, .table td {
            text-align: center;
        }

        .btn {
            background-color: #000000;
            border-color: #000000;
            transition: transform 0.3s ease, background-color 0.3s ease;
            color: white;
        }

        .btn:hover {
            background-color: #803d3b;
            color: white;
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
            background-color: #803d3b;
            color: black;
            border-color: #FAEED1;
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
                    <h5 class="card-title mb-0">Inventory Summary</h5>
                </div>
                <div class="card-body table-container">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Stock Quantity</th>
                                <th>Total Added</th>
                                <th>Total Removed</th>
                                <th>User Type</th>
                                <th>Username</th>
                                <th>Last Adjustment</th>
                                <th>Last Action Performed</th>
                                <th>Last Action Table</th>
                                <th>Last Action Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt = $pdo->query('SELECT * FROM inventory_summary ORDER BY last_action DESC');
                                while ($row = $stmt->fetch()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['stock_quantity']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['added']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['removed']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['user_type']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['last_adjustment']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['last_action_performed']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['last_action_table']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['last_action']) . "</td>";
                                    echo "</tr>";
                                }
                            } catch (PDOException $e) {
                                echo "<tr><td colspan='11' class='text-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
