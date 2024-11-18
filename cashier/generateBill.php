<?php
session_start();
include("cashier.php");

if(!isset($_SESSION['userid'])){
    header("Location: ../index.php");
    exit();
}

echo $_SESSION['userid'];
$c_id = $_SESSION['userid'];
$invn = $cashier->generateDraftBill($c_id);
if($invn){ 
    echo "new bill generated with invoiceno: $invn";
    echo "<script>
     url = 'draft_bill.php?invoiceno='+$invn;
     window.location = url; 
    </script>";
}else{
    echo "Unable to generate a new bill, Please Try Again later...";
}