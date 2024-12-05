<?php include('header.php'); ?>
<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: login.php');
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
    <title>Admin Dashboard</title>
    <style>
        /* Header and footer styles to match the login/register pages */
        @import url('https://fonts.cdnfonts.com/css/unbounded');
        @import url('https://fonts.cdnfonts.com/css/steppe-trial');
        
        body {
            background-color: #803d3b;
            font-family: 'Unbounded', sans-serif;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: transparent;
            color: white;
            text-align: center;
            padding: 10px;
        }

        .app-name {
            text-align: center;
            color: white;
            font-size: 50px;
            font-family: 'Unbounded', sans-serif;
            margin-top: 50px;
        }

        .catchphrase {
            text-align: center;
            color: white;
            font-size: 18px;
            font-style: italic;
            margin-top: 30px;
        }

        .main-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #000000;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .main-container h1 {
            text-align: center;
            color: white;
        }

        .description {
            text-align: center;
            color: white;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .nav-menu {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .nav-menu a {
            text-decoration: none;
            color: white;
            background-color: #000000;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
        }

        .nav-menu a:hover {
            background-color: white;
            color: black;
            transform: scale(1.05);
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        h1 {
            text-align: center;
            color: white;
            margin-top: 160px;
        }
    </style>
</head>
<body>


    <div class="catchphrase"></div>

        <h1>Welcome to Inventora Admin, <?= $_SESSION['username'] ?></h1>
        <p class="description">Efficiently manage your products, track stock levels, and keep your store organized.</p>
        <nav class="nav-menu">
            <a href="products/list.php" class="btn">Manage Products</a>
        </nav>
    </div>

    <footer>
        <p>&copy; 2024 Inventora. All rights reserved.</p>
    </footer>

</body>
</html>
