<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Inventory Management System</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="indexstyle.css">
</head>
<body>

<?php

session_start();
require "profile.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["username"]) && isset($_POST["password"])){
        $username = $_POST['username'];
        $passwd = $_POST['password'];

        $loginStatus = $user->login($username,$passwd);

        if($loginStatus == 0){
            echo "Invalid Username or Password";
        }else if($loginStatus == 1){
            echo "Redirecting to Admin Page";
            header("Location: ./admin/admin_home.php");
        }else if($loginStatus == 2){
            echo "Redirecting to Stocker Page";
            header("Location: ./stocker/stocker_home.php");
        }else if($loginStatus == 3){
            echo "Redirecting to Cashier Page";
            header("Location: ./cashier/cashier_home.php");
        }
    }
}

?>


    <h1>Welcome to Inventory Management System</h1>
    <br><br><br><br><br>
    
    <form method="POST">
        <label for="username">Enter Username:</label>
        <input type="text" name="username" id="username">
        <label for="password">Enter Password:</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Submit">
    </form>

</body>
</html>