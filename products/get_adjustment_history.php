<?php
// Include the database connection file
include('../db.php'); // Replace with the actual path to your DB connection script

// Check if product_id is provided via GET
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch the product name using the product ID
    try {
        $productStmt = $pdo->prepare("SELECT product_name FROM products WHERE product_id = ?");
        $productStmt->execute([$product_id]);

        if ($productStmt->rowCount() > 0) {
            $product = $productStmt->fetch();
            $product_name = htmlspecialchars($product['product_name']);
            echo "<div class='product-id-display'>Product: " . $product_name . "</div>";
        } else {
            echo "<div class='error-message'>Product not found.</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='error-message'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        exit; // Stop execution if there's a critical error
    }

    // Prepare the SQL query to call the get_adjustment_history function and join with the users table
    try {
        $stmt = $pdo->prepare("
            SELECT 
                a.adjustment_id, 
                a.quantity_added, 
                a.quantity_removed, 
                a.adjustment_type, 
                u.username AS adjusted_by, 
                TO_CHAR(a.adjustment_date, 'YYYY-MM-DD HH24:MI') AS formatted_adjustment_date
            FROM get_adjustment_history(?) a
            JOIN users u ON a.adjusted_by = u.user_id
        ");
        $stmt->execute([$product_id]);
    } catch (PDOException $e) {
        echo "<div class='error-message'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }

    // Fetch and display the results
    if ($stmt->rowCount() > 0) {
        echo "<table class='table table-bordered text-white'>
                <thead>
                    <tr>
                        <th>Adjustment ID</th>
                        <th>Quantity Added</th>
                        <th>Quantity Removed</th>
                        <th>Adjustment Type</th>
                        <th>Adjusted By</th>
                        <th>Adjustment Date</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['adjustment_id']) . "</td>
                    <td>" . htmlspecialchars($row['quantity_added']) . "</td>
                    <td>" . htmlspecialchars($row['quantity_removed']) . "</td>
                    <td>" . htmlspecialchars($row['adjustment_type']) . "</td>
                    <td>" . htmlspecialchars($row['adjusted_by']) . "</td>
                    <td>" . htmlspecialchars($row['formatted_adjustment_date']) . "</td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<div class='no-history-message'>No adjustment history found for this product.</div>";
    }
} else {
    echo "<div class='error-message'>No product ID provided.</div>";
}
?>


<style>
    .product-id-display, .no-history-message, .error-message {
    color: white;
    text-align: center;
    margin: 20px 0;
    font-family: 'Unbounded', sans-serif;
    font-size: 18px;
}

.no-history-message {
    background-color: rgba(0, 0, 0, 0.6);
    padding: 10px;
    border-radius: 5px;
}

.error-message {
    background-color: rgba(128, 61, 59, 0.7);
    padding: 10px;
    border-radius: 5px;
    font-weight: bold;
}

</style>