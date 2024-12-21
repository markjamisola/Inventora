<?php 
session_start(); 
include('../db.php'); 
include('header.php'); 

// Redirect non-admin users
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../staff/staff_dashboard.php');
    exit;
}


// Handle role updates and deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = (int)$_POST['user_id'];

    if (isset($_POST['delete'])) {
        // Delete user logic
        try {
            $stmt = $pdo->prepare('DELETE FROM users WHERE user_id = :user_id');
            $stmt->execute([':user_id' => $user_id]);

            // Log the activity
            $log_stmt = $pdo->prepare('INSERT INTO activity_logs (user_id, user_type, action_performed, table_name, column_name) VALUES (:user_id, :user_type, :action_performed, :table_name, :column_name)');
            $log_stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':user_type' => $_SESSION['role'],
                ':action_performed' => 'Delete User',
                ':table_name' => 'users',
                ':column_name' => 'ALL'
            ]);

            $success = 'User deleted successfully!';
        } catch (PDOException $e) {
            $error = 'Error deleting user: ' . htmlspecialchars($e->getMessage());
        }
    } elseif (isset($_POST['role'])) {
        $role = $_POST['role'];
        // Update user role logic
        try {
            $stmt = $pdo->prepare('UPDATE users SET role = :role WHERE user_id = :user_id');
            $stmt->execute([':role' => $role, ':user_id' => $user_id]);

            // Log the activity
            $log_stmt = $pdo->prepare('INSERT INTO activity_logs (user_id, user_type, action_performed, table_name, column_name) VALUES (:user_id, :user_type, :action_performed, :table_name, :column_name)');
            $log_stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':user_type' => $_SESSION['role'],
                ':action_performed' => 'Update Role',
                ':table_name' => 'users',
                ':column_name' => 'role'
            ]);

            $success = 'Role updated successfully!';
        } catch (PDOException $e) {
            $error = 'Error updating role: ' . htmlspecialchars($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Manage Users</title>
    <style>
        @import url('https://fonts.cdnfonts.com/css/unbounded');
        @import url('https://fonts.cdnfonts.com/css/steppe-trial');
        /* Add styles similar to activity_logs.php */
        .body { background-color: white; font-family: 'Unbounded', sans-serif; }
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

        .table-responsive {
            overflow-x: auto; /* Make tables scrollable on smaller screens */
        }
        .table-container {
            max-height: 400px;
            overflow-y: auto; /* Enable vertical scrolling */
        }
        .table { background-color: white; border-radius: 15px; padding: 20px; }
        .table th { color: white; background-color: #000000; }
        .table th, .table td { text-align: center; }
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
        
        .success, .error {
            color: #803d3b;
            font-family: 'Unbounded', sans-serif;
            text-align: center;
            margin-top: 10px;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .success {
            background-color: transparent;
            padding-top: 10px;
        }

        .error {
            background-color: transparent;
            padding: 10px;
        }
    </style>
</head>
<body class="body">
    <div class="container mt-5">
        <div class="my-4">
            <div class="d-flex justify-content-between mb-3">
                <a class="btn btn-primary" href="list.php">Back to List</a>
            </div>
            <?php if (isset($success)): ?>
                <div class="success text-center"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="error text-center"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-header bg-black text-white text-center">
                    <h5 class="card-title mb-0">Manage Users</h5>
                </div>

                <div class="card-body table-container">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                try {
                                    // Fetch users
                                    $stmt = $pdo->query('SELECT user_id, username, role, TO_CHAR(created_at, \'YYYY-MM-DD HH24:MI\') AS formatted_created_at FROM users ORDER BY user_id');
                                    while ($row = $stmt->fetch()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                        echo "<td>
                                            <form method='POST' class='d-inline'>
                                                <input type='hidden' name='user_id' value='" . htmlspecialchars($row['user_id']) . "'>
                                                <div class='d-flex justify-content-center align-items-center'>
                                                    <select name='role' class='form-select me-2' style='width: 120px;'> <!-- Fixed width for better alignment -->
                                                        <option value='admin'" . ($row['role'] === 'admin' ? ' selected' : '') . ">Admin</option>
                                                        <option value='staff'" . ($row['role'] === 'staff' ? ' selected' : '') . ">Staff</option>
                                                    </select>
                                                    <button type='submit' class='btn btn-primary btn-sm' style='font-size: 14px;'>Update</button> <!-- Slightly smaller button -->
                                                </div>
                                            </form>
                                        </td>";
                                        echo "<td>" . htmlspecialchars($row['formatted_created_at']) . "</td>";
                                        echo "<td>
                                            <form method='POST'>
                                                <input type='hidden' name='user_id' value='" . htmlspecialchars($row['user_id']) . "'>
                                                <button type='submit' name='delete' class='btn btn-danger btn-sm'>Delete</button>
                                            </form>
                                        </td>";
                                        echo "</tr>";
                                    }
                                } catch (PDOException $e) {
                                    echo "<tr><td colspan='5' class='text-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
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
