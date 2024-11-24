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
    echo "alert('Invalid Invoice number, bill not found');";
    echo "window.location = 'cashier_home.php'";
    echo "</script>";
}

$billDetails = $cashier->displayBill($invno);
$billItems = $cashier->displayBillItems($invno);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bill</title>
    <link rel="stylesheet" href="./cashiercss/view_bill.css">

</head>
<body>
    <h1>Bill Details</h1>
    <br>
    <hr>

    <h2><b>Invoice No: </b><?php echo $billDetails['invoiceno']; ?></h2>
    <h2><b>Date: </b><?php echo $billDetails['date']; ?></h2>
    <h2><b>Payment Method: </b><?php echo $billDetails['total_price']; ?></h2>
    <h2><b>Total Price: </b><?php echo $billDetails['paymethod']; ?></h2>

    <?php
    if(empty($billItems)){
        echo "<centre><p class='text-centre'><b>No Items in Bill</b></p><centre>";
        $disabled = "disabled";
      }else{
        echo '<table border="1">';
            echo '<table class="table table-hover">
            <thead>
              <tr>
                <th>SNo</th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
              </tr>
            </thead><tbody>';
  
            $disabled = "";
            $count = 1;
  
            foreach($billItems as $row){
                echo '<tr>';
                  echo '<td>' . $count . '</td>';
                  echo '<td>'.$row["prodid"].'</td>';
                  echo '<td>' . $row["name"] . '</td>';
                  echo '<td>' . $row["price"] . '</td>';
                  echo '<td>' . $row["qty"] . '</td>';
                  echo '<td>' . $row["tprice"] . '</td>';
                  echo '</tr>';
    
                  $count++;
              }
        } 
    ?>
</body>
</html>