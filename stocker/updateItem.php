<?php

require 'stocker.php';


if (isset($_POST['pid']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['stock']) && isset($_POST['description'])){
    $prodid = $_POST['pid'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    if ($stocker->updateItem($prodid,$name,$price,$stock,$description)){
        echo "success";
    }else{
        echo "error";
    }
}