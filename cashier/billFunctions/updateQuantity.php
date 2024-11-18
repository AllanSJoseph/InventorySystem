<?php

require 'bill.php';

if (isset($_POST['invoiceno']) && isset($_POST['prodid']) && isset($_POST['price']) && isset($_POST['quantity'])) {
    $invoiceno = intval($_POST['invoiceno']);
    $prodid = intval($_POST['prodid']);
    $price = intval($_POST['price']);
    $quantity = intval($_POST['quantity']);

    if ($bill->editQuantity($invoiceno,$prodid,$price,$quantity)) {
        echo "success";
    } else {
        echo "error";
    }

}

?>
