
<?php
session_start();

if(!isset($_SESSION['userid'])){
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-cover bg-center" style="background-image: url('../images/pexels-karolina-grabowska-5650040.jpg');">
    <div class="flex flex-col items-center justify-center min-h-screen p-4">
        <h1 class="text-white text-4xl font-bold mb-8 animate-fadeIn"><b>Welcome</b> <?php echo $_SESSION['name'];?></h1>
        <div class="bg-black bg-opacity-70 p-8 rounded-lg shadow-lg">
            <nav class="flex flex-col space-y-4">
                <a href="add_user.php" class="btn text-lg text-white py-2 px-4 rounded hover:bg-blue-500 hover:text-white transition">Add a New User (Stocker/Cashier)</a>
                <a href="display_user.php" class="btn text-lg text-white py-2 px-4 rounded hover:bg-blue-500 hover:text-white transition">Display All Users</a>
                <a href="display_bills.php" class="btn text-lg text-white py-2 px-4 rounded hover:bg-blue-500 hover:text-white transition">Display Bill Records</a>
                <a href="display_inventory.php" class="btn text-lg text-white py-2 px-4 rounded hover:bg-blue-500 hover:text-white transition">Display Inventory</a>
                <a href="../logout.php" class="btn text-lg text-white py-2 px-4 rounded hover:bg-blue-500 hover:text-white transition">Logout</a>
            </nav>
        </div>
    </div>
</html>