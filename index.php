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
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<?php
session_start();
require "profile.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["username"]) && isset($_POST["password"])){
        $username = $_POST['username'];
        $passwd = $_POST['password'];

        $loginStatus = $user->login($username, $passwd);

        if($loginStatus == 0){
            echo "<div class='text-red-500 text-center mt-4'>Invalid Username or Password</div>";
        } else if($loginStatus == 1){
            echo "<div class='text-green-500 text-center mt-4'>Redirecting to Admin Page</div>";
            header("Location: ./admin/admin_home.php");
            exit();
        } else if($loginStatus == 2){
            echo "<div class='text-green-500 text-center mt-4'>Redirecting to Stocker Page</div>";
            header("Location: ./stocker/stocker_home.php");
            exit();
        } else if($loginStatus == 3){
            echo "<div class='text-green-500 text-center mt-4'>Redirecting to Cashier Page</div>";
            header("Location: ./cashier/cashier_home.php");
            exit();
        }
    }
}
?>      

<div class="bg-white p-8 rounded-lg shadow-lg w-96">
    <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Welcome to Inventory Management System</h1>
    
    <form method="POST" class="space-y-4">
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700">Enter Username:</label>
            <input type="text" name="username" id="username" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Enter Password:</label>
            <input type="password" name="password" id="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2">
        </div>
        <input type="submit" value="Submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-700 transition duration-300">
    </form>
</div>

</body>
</html>