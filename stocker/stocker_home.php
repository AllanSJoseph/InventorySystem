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
    <title>Stocker Home</title>
</head>
<body>
<h1>Welcome <?php echo $_SESSION['name'];?></h1>
    <nav>
        <a href="display_inventory.php" class="btn btn-primary">Display Inventory</a>
        <a href="add_item.php" class="btn btn-primary">Add Item to Inventory</a>
        <a href="stocker_profile.php" class="btn btn-primary">Your Profile</a>
        <a href="../logout.php">Logout</a>
    </nav>
</body>
</html>