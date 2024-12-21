<?php
session_start();

?>
<?php
include('../db.php'); // Include database connection

// Check if the refresh button was clicked
if (isset($_POST['refresh'])) {
    try {
        // Refresh the materialized view
        $stmt = $pdo->prepare("REFRESH MATERIALIZED VIEW mview_stock_critical");
        $stmt->execute();
        $message = "Materialized view refreshed successfully!";
    } catch (PDOException $e) {
        $message = "Error refreshing the materialized view: " . $e->getMessage();
    }
    // Redirect back to the list page with the message
    header("Location: staff_list.php?message=" . urlencode($message));
    exit();
}
?>
