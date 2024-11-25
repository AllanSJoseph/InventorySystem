<?php 
require "admin.php";
session_start();

if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["address"]) && isset($_POST["type"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $type = $_POST["type"];

    $response = $admin->addUser($username,$password,$email,$phone,$address,$type);

    if ($response['status'] === 1) {
        echo '<script>alert("'.$response['message'].'")</script>';
    } else {
        echo '<script>alert("ERROR: '.$response['message'].'")</script>';
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User to Database</title>
    <link rel="stylesheet" href="Admincss/add_user.css">
    <link rel="stylesheet" href="Admincss/nav.css">
</head>
<body>
    <nav>
        <a href="#">Add a New User (Stocker/Cashier)</a>
        <a href="display_user.php">Display All Users</a>
        <a href="display_bills.php">Display Bill Records</a>
        <a href="display_inventory.php">Display Inventory</a>
        <a href="../logout.php">Logout</a>
    </nav>

    <form onsubmit="return validate()" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="password">Confirm Password:</label>
        <input type="password" id="confpassword" name="confpassword" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone"><br><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="4" cols="50"></textarea><br><br>

        <label for="type">Type:</label>
        <select id="type" name="type" required>
            <option value="Stocker">Stocker</option>
            <option value="Cashier">Cashier</option>
        </select><br><br>

        <input type="submit" id="submit" value="Add User">
    </form>

    <script src="addUserScript.js"></script>
</body>
</html>