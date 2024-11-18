<?php
require "admin.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Users</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid black;
            padding: 8px 12px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Showing Bills Created in this database...</h1>

    <?php 
      $bills = $admin->displayBillHistory();

      if(empty($bills)){
        echo "<centre><p class='text-centre'><b>No Bills Issued</b></p><centre>";
        $disabled = "disabled";
      }else{
        echo '<table border="1">';
            echo '<table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Invoice No</th>
                <th scope="col">Date Issued</th>
                <th scope="col">Total Price</th>
                <th scope="col">Payment Method</th>
                <th scope="col">Cashier</th>
                <th scope="col">Actions</th>
              </tr>
            </thead><tbody>';
  
            $disabled = "";
            $count = 1;
  
            foreach($bills as $row){
                echo '<tr>';
                  echo '<td>' . $count . '</td>';
                  echo '<td>'.$row["invoiceno"].'</td>';
                  echo '<td>' . $row["date"] . '</td>';
                  echo '<td>' . $row["total_price"] . '</td>';
                  echo '<td>' . $row["paymethod"] . '</td>';
                  echo '<td>' . $row["username"] . '</td>';
                  echo '<td><button class="btn btn-outline-primary" onclick="viewBill('.$row["invoiceno"].')">View Bill</button>';
                  echo '</tr>';
    
                  $count++;
              }
        }
    ?>

    
</body>
</html>