<?php

require 'bill.php';

if (isset($_GET['invoiceNo'])) {
    $invoiceno = $_GET['invoiceNo'];

    $rows = $bill->fetchBillData($invoiceno);
    
    echo json_encode($rows);
    
}


?>
