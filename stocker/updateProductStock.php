<?php
require 'stocker.php';

if (isset($_POST['pid']) && isset($_POST['stock'])) {
    $pid = $_POST['pid'];
    $stock = $_POST['stock'];


    if ($stocker->updateStock($pid,$stock)) {
        echo "success";
    } else {
        echo "failure";
    }

}

?>
