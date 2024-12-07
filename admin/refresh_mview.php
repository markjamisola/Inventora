<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../staff/staff_dashboard.php');
    exit;
}

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
    header("Location: list.php?message=" . urlencode($message));
    exit();
}
?>
