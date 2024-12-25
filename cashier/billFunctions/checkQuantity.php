<?php


require 'bill.php';

if(isset($_GET['pid']) && isset($_GET['qty'])){
    $pid = $_GET['pid'];
    $qty = $_GET['qty'];

    if($bill->checkQuantity($pid,$qty)){
        echo 'Error';
    }else{
        echo 'Success';
    }
    
}