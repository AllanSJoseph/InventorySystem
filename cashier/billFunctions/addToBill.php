<?php

require 'bill.php';

if (isset($_POST['invoiceno']) && isset($_POST['prodid']) && isset($_POST['prodname']) && isset($_POST['price']) && isset($_POST['quantity']) && isset($_POST['totalPrice'])) {
    $invoiceno = $_POST['invoiceno'];
    $prodid = $_POST['prodid'];
    $prodname = $_POST['prodname'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $totalPrice = $_POST['totalPrice'];

    if ($bill->addEntry($invoiceno,$prodid,$quantity,$totalPrice)){
        echo "success";
    }else{
        echo "Failed to add Entry";
    }
    
}