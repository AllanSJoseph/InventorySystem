<?php
session_start();
include("cashier.php");

if(!isset($_SESSION['userid'])){
    header("Location: ../index.php");
    exit();
}

if(isset($_GET['invoiceno'])){
    $invno = $_GET['invoiceno'];
}else{
    echo "<script>";
    echo "alert('Invalid Invoice number, bill cannot be discarded...');";
    echo "window.location = 'cashier_home.php';";
    echo "</script>";
}

echo $invno;
if($cashier->discardBill($invno)){
    echo "<script>";
    echo "alert('Bill Discarded Successfully...');";
    echo "window.location = 'cashier_home.php';";
    echo "</script>";
}else{
    echo "<script>";
    echo "alert('Something went wrong! Please Try again later');";
    echo "url = 'draft_bill.php?invoiceno='+$invno";
    echo "window.location = url;";
    echo "</script>";
}

?>