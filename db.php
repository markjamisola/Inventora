<?php
$host = 'localhost';
$dbname = 'inventory_db';
$username = 'admin'; 
$password = '@admin123'; 
//$username = 'staff'; 
//$password = '@staff456';

try {
   
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

try {
    $stmt = $pdo->query('SELECT current_user;');
    $current_user = $stmt->fetchColumn();
    echo "Current Database User: " . htmlspecialchars($current_user);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if (isset($_SESSION['user_id'])) {
    $logged_in_user_id = $_SESSION['user_id'];
    $pdo->exec("SET myapp.user_id = {$logged_in_user_id}");
}
?>
