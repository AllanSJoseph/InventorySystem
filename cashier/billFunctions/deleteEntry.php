<?php

require 'bill.php';

if (isset($_POST['invoiceno']) && isset($_POST['prodid'])) {
    $invoiceno = $_POST['invoiceno'];
    $prodid = $_POST['prodid'];


    if($bill->deleteEntry($invoiceno,$prodid)){
        echo "success";
    }else{
        echo "Deleting Entry Failed";
    }
}