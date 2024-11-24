<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Home</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Custom CSS */
        body {
            background-color: #f5f5f5; /* Light background color */
        }

        nav a {
            transition: all 0.3s ease;
        }

        nav a:hover {
            color: #ffffff;
            background-color: #4CAF50; /* Green color on hover */
            padding: 10px 15px;
            border-radius: 5px;
        }

        h1 {
            color: #4CAF50; /* Green color for the welcome text */
            text-align: center;
            font-size: 2.5em;
            margin-top: 50px;
        }

        nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        nav a {
            font-size: 1.2em;
            color: #4CAF50; /* Green color for the links */
            text-decoration: none;
            padding: 12px 20px;
            background-color: #fff;
            border: 2px solid #4CAF50;
            border-radius: 5px;
        }

        .logout-btn {
            background-color: #FF6F61; /* Red color for logout button */
            color: white;
            border-color: #FF6F61;
        }

        .logout-btn:hover {
            background-color: #FF3E3E; /* Darker red for hover */
        }
    </style>
</head>
<body>

    <h1>Welcome <?php echo $_SESSION['name']; ?></h1>

    <nav>
        <a href="generateBill.php" class="hover:bg-green-500 text-green-500 hover:text-white transition duration-300 ease-in-out p-3 rounded-md border-2 border-green-500">Generate Draft Bill</a>
        <a href="display_bills.php" class="hover:bg-green-500 text-green-500 hover:text-white transition duration-300 ease-in-out p-3 rounded-md border-2 border-green-500">Display Bill Records</a>
        <a href="../logout.php" class="btn logout-btn">Logout</a>
    </nav>

</body>
</html>
