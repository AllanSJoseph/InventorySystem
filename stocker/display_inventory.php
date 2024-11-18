<?php
require "stocker.php";
session_start();

if(!isset($_SESSION['userid'])){
    header("Location: ../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Items</title>
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
    <h1>Showing All Items in the Inventory...</h1>
    <a href="add_item.php">Add Item to Inventory</a>
    <a href="add_item.php">Refresh Table</a>

    <?php 
      $items = $stocker->displayProductInventory();

      if(empty($items)){
        echo "<centre><p class='text-centre'><b>No Users</b></p><centre>";
        $disabled = "disabled";
      }else{
        echo '<table border="1">';
            echo '<table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Product Id</th>
                <th scope="col">Product Name</th>
                <th scope="col">Price</th>
                <th scope="col">Stock</th>
                <th scope="col">Description</th>
                <th scope="col">Modified On</th>
                <th colspan=3>Actions</th>
              </tr>
            </thead><tbody>';
  
            $disabled = "";
            $count = 1;
  
            foreach($items as $row){
                echo '<tr>';
                  echo '<td>' . $count . '</td>';
                  echo '<td>'.$row["prodid"].'</td>';
                  echo '<td>' . $row["name"] . '</td>';
                  echo '<td> &#8377 ' . $row["price"] . '</td>';
                  echo '<td>' . $row["stock"] . '</td>';
                  echo '<td>' . $row["description"] . '</td>';
                  echo '<td>' . $row["modifiedon"] . '</td>';
                  echo '<td> <button onclick="editProduct('.$row["prodid"].')">Edit Details</button></td>';
                  echo '<td> <button onclick="editStock('.$row["prodid"].')">Edit Stock</button></td>';
                  echo '<td> <button onclick="deleteProduct('.$row["prodid"].')">Delete Product</button></td>';
                  echo '</tr>';
    
                  $count++;
              }
        }
    ?>

    <!-- Edit Popoup to edit all details of the product-->
    <div id="editModal" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div style="background-color: #fefefe; margin: auto; padding: 20px; border: 1px solid #888; width: 30%;">
            <h2>Edit Product</h2>

            <form id="editProductForm">
                <label for="prodid">Product Id:</label>
                <input type='number' id="prodid" name="prodid" disabled><br><br>

                <label for="editName">Product Name:</label>
                <input type="text" id="editName" name="name"><br><br>

                <label for="editPrice">Price:</label>
                <input type="number" id="editPrice" name="price"><br><br>

                <label for="editStock">Stock:</label>
                <input type="number" id="editStock" name="stock"><br><br>

                <label for="editDescription">Description:</label>
                <textarea id="editDescription" name="description"></textarea><br><br>

                <button type="button" onclick="saveProduct()">Save Changes</button>
                <button type="button" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>
    
    <!-- Edit Popoup to edit just the stock of the product-->
    <div id="editStockModal" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
    <div style="background-color: #fefefe; margin: auto; padding: 20px; border: 1px solid #888; width: 30%;">
        <h2>Edit Product Stock</h2>

        <form id="editStockForm">
            <h4>Edit Stock for: <span id="pname"></span></h4>
            <label for="spid">Product Id:</label>
            <input type='number' id="spid" name="spid" disabled><br><br>

            <label for="editStockk">Stock:</label>
            <input type="number" id="editStockk" name="editStockk"><br><br>

            <button type="button" onclick="saveProductStock()">Save Changes</button>
            <button type="button" onclick="closeEditStockModal()">Cancel</button>
        </form>
    </div>
</div>

    <script src="inventoryfns.js"></script>
    
</body>
</html>