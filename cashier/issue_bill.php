<?php
session_start();
include("cashier.php");

if(!isset($_SESSION['userid'])){
    header("Location: ../index.php");
    exit();
}

if(isset($_GET['invoiceno']) && isset($_GET['payment'])){
    $invno = $_GET['invoiceno'];
    $pay = $_GET['payment'];
}else{
    echo "<script>";
    echo "alert('Invalid Invoice number and payment bill cannot be generated');";
    echo "window.location = 'cashier_home.php'";
    echo "</script>";
}

$errrows = $cashier->validateQuantity($invno);

if(empty($errrows)){
    //All Quantities are valid
    $totalPrice = $cashier->calculateTotalPrice($invno);
    if($cashier->issueBill($invno,$totalPrice,$pay)){
        echo json_encode(["status" => "success", "message" => "Bill Issued Successfully"]);
    }else{
        echo json_encode(["status" => "error", "message" => "Something Went Wrong!"]);
    }
}else{
    echo json_encode(["status" => "error", "discrepancies" => $errrows]);
}