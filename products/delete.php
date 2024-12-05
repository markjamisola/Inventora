
<?php 
session_start();
include('../db.php'); 
include('../header.php'); 

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

<h1>Delete Product</h1>
<p><a class="btn-back" href="list.php">Back to Product List</a></p>

<?php include('../footer.php'); ?>
