<?php 
session_start();
require 'stocker.php';

if(!isset($_SESSION['userid'])){
    header("Location: ../index.php");
    exit();
}


if(isset($_POST["pname"]) && isset($_POST["price"]) && isset($_POST["stock"]) && isset($_POST["description"])){
    $pname = $_POST["pname"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $description = $_POST["description"];

    if($stocker->AddItem($pname,$price,$stock,$description)){
        echo '<script>alert("Product Added Successfully")</script>';
    }else{
        echo '<script>alert("Failed to Add Product")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link rel="stylesheet" href="./stockercss/add_item.css"> <!-- Link to the CSS file -->
</head>
<body>
    <h1 class="moving-heading">ADD PRODUCT</h1>
    <form onsubmit="return validate()" method="POST">
        <label for="pname">Product Name: </label>
        <input type="text" name="pname" id="pname"><br><br>

        <label for="price">Price: </label>
        <input type="number" onkeyup="checkPrice(this.value)" onchange="checkPrice(this.value)" name="price" id="price">
        <p id="errPrice" class="errTxt">Value can't be negative or 0...</p><br><br>

        <label for="stock">Stock: </label>
        <input type="number" onkeyup="checkQty(this.value)" onchange="checkQty(this.value)" name="stock" id="stock">
        <p id="errStock" class="errTxt">Value can't be negative or 0...</p><br><br>

        <label for="description">Description: </label>
        <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>

        <input type="reset" value="Reset">
        <input type="submit" value="Submit">
    </form>
    <button onclick="window.location = 'display_inventory.php'" type="back" >Back</button>

    <div style="display: None;">
      <p id="errrStock" style="display: None;">Debugging Hidden Tag</p>
    </div>
    
    <script src="inventoryfns.js"></script>
</body>
</html>