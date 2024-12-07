<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Inventora</title>
    <style>
        /* Style for the header */
        .header {
            display: flex;
            justify-content: space-between; /* Space between logo and nav */
            align-items: center; /* Center items vertically */
            padding: 20px; /* Add padding to the header */
            background-color: #000000; /* Dark background for the header */
            color: white; /* White text */
            position: fixed; /* Fix the header to the top */
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.7), 0px 4px 10px rgba(50, 50, 50, 0.5); /* Black/gray shadow */
            top: 0; /* Position the header at the top */
            left: 0; /* Ensure it is aligned to the left */
            width: 100%; /* Make the header span the full width */
            z-index: 1000; /* Ensure the header stays on top of other content */
        }

        .header h1 {
            margin: 0; /* Remove default margin */
            margin-left: 20px;
        }

        /* Navigation links style */
        .header nav a {
            color: white;
            text-decoration: none;
            margin: 20px; /* Space between links */
            font-size: 16px; /* Font size */
            transition: color 0.3s ease; /* Smooth color transition */

        }

        .header nav a:hover {
            color: #803d3b; /* Change color on hover */
        }

        .header nav .logout {
            color:#803d3b; 
        }

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
            <a href="admin_dashboard.php">Home</a>
            <a href="list.php">Products</a>
            <a class="logout" href="../logout.php">Logout</a>
        </nav>
    </header>
</body>
</html>
