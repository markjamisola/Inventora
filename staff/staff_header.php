<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Inventora</title>
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #000000;
            color: white;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.7), 0px 4px 10px rgba(50, 50, 50, 0.5); 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            z-index: 1000; 
        }

        .header h1 {
            margin: 0;
            padding-left: 30px;
        }

        .header nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
            transition: color 0.3s ease;
            padding-right: 30px;
        }

        .header nav a:hover {
            color: #803d3b;
        }

        .header nav .logout {
            color: #803d3b;
        }

        /* Make the layout responsive */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            .header nav {
                margin-top: 10px;
            }
        }

        body {
            padding-top: 80px;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Inventora</h1>
        <nav>
            <a href="staff_dashboard.php">Home</a>
            <a href="staff_list.php">Products</a>
            <a class="logout" href="../logout.php">Logout</a>
        </nav>
    </header>
</body>
</html>
