
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
<body>
    <h1>Welcome <?php echo $_SESSION['name'];?></h1>
    <br>
    <nav>
    <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
        <a href="add_user.php" class="btn btn-outline-light btn-lg">Add a New User (Stocker/Cashier)</a>
        <a href="display_user.php" class="btn btn-outline-light btn-lg">Display All Users</a>
        <a href="display_bills.php" class="btn btn-outline-light btn-lg">Display Bill Records</a>
        <a href="display_inventory.php" class="btn btn-outline-light btn-lg">Display Inventory</a>
        <a href="../logout.php" class="btn btn-outline-light btn-lg">Logout</a>
    </div>
    </nav>
</body>
</html>