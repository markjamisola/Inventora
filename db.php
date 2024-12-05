<?php
// db.php
$host = 'localhost';
$dbname = 'inventory_db';
$username = 'admin'; // Change to "admin" for admin tasks
$password = '@admin123'; // Password for the staff role

try {
    // PDO connection
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// To use the session user_id for logging activities, set it for each request
if (isset($_SESSION['user_id'])) {
    $logged_in_user_id = $_SESSION['user_id'];
    // Set the user_id in a session variable or in the database connection
    $pdo->exec("SET myapp.user_id = {$logged_in_user_id}");
}
?>
