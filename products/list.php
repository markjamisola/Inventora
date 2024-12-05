<?php include('../header.php'); ?>
<?php session_start(); include('../db.php'); ?>



<h2 class="add">Product List</h2>
<a class="btn" href="add.php">Add New Product</a>
<table class="table">
    <tr>
        <th>Product Name</th>
        <th>Category</th>
        <th>Stock</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>
    <?php
    $stmt = $pdo->query('SELECT * FROM products');
    while ($row = $stmt->fetch()) {
        echo "<tr>
                <td>{$row['product_name']}</td>
                <td>{$row['category']}</td>
                <td>{$row['stock_quantity']}</td>
                <td>{$row['price_per_unit']}</td>
                <td>
                    <a class='btn-edit' href='edit.php?id={$row['product_id']}'>Edit</a>
                    <a class='btn-danger' href='delete.php?id={$row['product_id']}'>Delete</a>
                </td>
              </tr>";
    }
    ?>
</table>

<a class="btn-back" href="../admin_dashboard.php">Back to Home</a>

<?php include('../footer.php'); ?>
