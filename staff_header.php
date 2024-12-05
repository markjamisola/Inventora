<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Inventora</title>
    <style>
        /* Make the header stick to the top */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #000000;
            color: white;
            position: fixed; /* Make header fixed */
            top: 0; /* Align at the top */
            left: 0; /* Align at the left */
            width: 100%; /* Full width */
            z-index: 1000; /* Ensure header stays on top */
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

        /* Add padding to the body to prevent content from hiding under the fixed header */
        body {
            padding-top: 80px; /* Adjust the padding based on header height */
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Inventora</h1>
        <nav>
            <a href="staff_dashboard.php">Home</a>
            <a class="logout" href="logout.php">Logout</a>
        </nav>
    </header>
</body>
</html>
