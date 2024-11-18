<?php 
session_start();
include("cashier.php");



if(isset($_GET['invoiceno'])){
    $invno = $_GET['invoiceno'];
}else{
    echo "<script>";
    echo "alert('Invalid Invoice number, bill cannot be generated');";
    echo "window.location = 'cashier_home.php'";
    echo "</script>";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draft Bill</title>
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
    <h1 style="text-align: center;">DRAFT BILL</h1>

    <form id="productForm">  
        <label for="invNo">Invoice No:</label>
        <input type="number" name="invNo" id="invNo" value=<?php echo $invno; ?> disabled><br><br>
        
        <label for="prodid">Product Id</label>
        <input type="number" name="prodid" id="prodid">
        

        <label for="prodname">Product Name</label>
        <input type="text" name="prodname" id="prodname">

        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" oninput="updateTotalPrice()">

        <label for="price">Price</label>
        <input type="number" name="price" id="price" disabled>

        <label for="tprice">Total Price</label>
        <input type="number" name="tprice" id="tprice" disabled>

        <p id="status" style="color: red;"></p>

        <input type="button" value="Add" id="add" onclick="addEntry()">
        <input type="reset" value="Clear">
    </form>

    <h2 style="text-align: center;">Product Details</h2>
    <table id="bill">
        <thead>
            <tr>
                <th>SNo</th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th colspan=2>Actions</th>
            </tr>
        </thead>
        <tbody id="billBody">
        </tbody>
    </table>

    <button>Issue Bill</button>
    <button onclick="discardBill()">Discard Bill</button>
    <button onclick="updateTable()">Update Bill</button>

    <div id="editModal" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div style="background-color: #fefefe; margin: auto; padding: 20px; border: 1px solid #888; width: 30%;">
            <h2>Edit Quantity</h2>
            
            <input type="hidden" id="editInvoiceNo">
            <input type="hidden" id="editProdId">
            <input type="hidden" id="editPrice">
            
            <label for="editQuantity">New Quantity:</label>
            <input type="number" id="editQuantity">
            
            <br><br>
            <button onclick="saveQuantity()">Save</button>
            <button onclick="closeEditModal()">Cancel</button>
        </div>
    </div>

    <script src="bill.js"></script>
</body>
</html>