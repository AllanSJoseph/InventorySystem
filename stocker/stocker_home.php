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
    <title>Stocker Home</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .hover\:scale-105:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full fade-in">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
        <nav class="flex flex-col space-y-4">
            <a href="display_inventory.php" class="bg-blue-500 text-white py-2 rounded-lg text-center transition duration-300 transform hover:scale-105 hover:bg-blue-600">Display Inventory</a>
            <a href="add_item.php" class="bg-green-500 text-white py-2 rounded-lg text-center transition duration-300 transform hover:scale-105 hover:bg-green-600">Add Item to Inventory</a>
            <!-- <a href="stocker_profile.php" class="bg-yellow-500 text-white py-2 rounded-lg text-center transition duration-300 transform hover:scale-105 hover:bg-yellow-600">Your Profile</a> -->
            <a href="../logout.php" class="bg-red-500 text-white py-2 rounded-lg text-center transition duration-300 transform hover:scale-105 hover:bg-red-600">Logout</a>
        </nav>
    </div>
</body>
</html>