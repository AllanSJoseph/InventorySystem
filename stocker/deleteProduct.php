<?php
session_start();
require 'stocker.php';

if (isset($_POST['pid'])) {

    $pid = $_POST['pid'];

    if ($stocker->deleteItem($pid)) {
        echo "success"; 
    } else {
        echo "Failed to delete product.";
    }
}

?>
