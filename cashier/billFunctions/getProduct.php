<?php

require 'bill.php';

if (isset($_GET['prodid'])) {
    $prodid = $_GET['prodid'];
    $result = $bill->returnProdDetails($prodid);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode(['name' => $product['name'], 'price' => $product['price']]);
    } else {
        echo json_encode(null);
    }
}


?>