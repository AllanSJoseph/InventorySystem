<?php

require 'stocker.php';

if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];


    $result = $stocker->returnProdDetails($pid);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode(['prodid' => $product['prodid'], 'name' => $product['name'], 'price' => $product['price'], 'stock' => $product['stock'], 'description' => $product['description']]);
    } else {
        echo json_encode(["error" => "Product not found"]);
    }
}


?>