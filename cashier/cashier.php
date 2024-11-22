<?php
//Including the config file which contains the Database parent class.
require __DIR__."/../config.php";
// include("../config.php'");

//Class which contains the features of the cashier
class Cashier extends Database{

    function generateDraftBill($cashierId){
        $sql = "INSERT INTO bills (cashier) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$cashierId);

        if ($stmt->execute()) {
            $invoiceno = $stmt->insert_id;
            $stmt->close();
            return $invoiceno;
        } else {
            $stmt->close();
            return false;
        }
    }

    function displayBill($invoice_no){
        $sql = "SELECT * FROM bills WHERE invoiceno = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $invoice_no);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                return $row;
            }
        }

    }

    function displayBillItems($invoice_no){
        $sql = "SELECT ba.invoiceno, ba.prodid, ba.qty, ba.tprice, p.name, p.price 
        FROM bill_archive AS ba
        JOIN products AS p ON ba.prodid = p.prodid
        WHERE ba.invoiceno = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $invoice_no);
        $stmt->execute();
        $result = $stmt->get_result();

        $rows = array();
        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $stmt->close();
        return $rows;
        }
    } 

    function validateQuantity($invoiceNo){
        $sql = "SELECT
        ba.prodid,
        ba.qty AS bill_quantity,
        p.name AS product_name,
        p.stock AS product_stock
        FROM bill_archive AS ba JOIN products AS p ON ba.prodid = p.prodid
        WHERE ba.invoiceno = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$invoiceNo);
        $stmt->execute();
        $result = $stmt->get_result();

        $errorList = [];

        while($row = $result->fetch_assoc()){
            if($row['bill_quantity'] >= $row['product_stock']){
                $errorList[] = [
                    'prodid' => $row['prodid'],
                    'product_name' => $row['product_name'],
                    'bill_quantity' => $row['bill_quantity'],
                    'product_stock' => $row['product_stock']
                ];
            }
        }

        $stmt->close();
        return $errorList;
    }

    function calculateTotalPrice($invoiceNo){
        $sql = "SELECT SUM(tprice) AS totalPrice FROM bill_archive WHERE invoiceno = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$invoiceNo);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalPrice = 0;

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $totalPrice = $row['totalPrice'];
        }

        $stmt->close();
        return $totalPrice;
    }

    function updateQty($invoiceNo){
        $this->conn->begin_transaction();

        try{
           $sql = "SELECT
            ba.prodid,
            ba.qty AS bill_quantity,
            p.stock AS product_stock
            FROM bill_archive AS ba JOIN products AS p ON ba.prodid = p.prodid
            WHERE ba.invoiceno = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i",$invoiceNo);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows === 0){
                throw new Exception("No rows to update quantity");
            }

            while($row = $result->fetch_assoc()){
                $prodid = $row["prodid"];
                $bill_quantity = $row["bill_quantity"];
                $pstock = $row["product_stock"];

                if($pstock < $bill_quantity){
                    throw new Exception("Product Stock is less than bill stock...");
                }

                $newStock = $pstock - $bill_quantity;

                $updateSql = "UPDATE products SET stock = ? WHERE prodid = ?";
                $updateStmt = $this->conn->prepare($updateSql);
                $updateStmt->bind_param("ii",$newStock,$prodid);
                $updateStmt->execute();

                if($updateStmt->affected_rows === 0){
                    throw new Exception("failed to update Stock for product Id");
                }
            }

            $this->conn->commit();
            $stmt->close();

            return 1;
        }catch(Exception $e){
            $this->conn->rollback();
            return 0;
        }
        
    }

    function issueBill($invoiceNo, $totalPrice, $payMethod){
        if($this->updateQty($invoiceNo)){
            $sql = "UPDATE bills SET total_price = ?, paymethod = ? WHERE invoiceno = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("dsi", $totalPrice, $payMethod, $invoiceNo);

            if ($stmt->execute()) {
                return 1;
            } else {
                return 0;
            }
        }else{
            return 0;
        }
        
    }

    function discardBill($invoiceNo){
        $this->conn->begin_transaction();

        try {
            $sqlArchive = "DELETE FROM bill_archive WHERE invoiceno = ?";
            $stmtArchive = $this->conn->prepare($sqlArchive);
            $stmtArchive->bind_param("i", $invoiceNo);
            $stmtArchive->execute();
            
            $sqlBills = "DELETE FROM bills WHERE invoiceno = ?";
            $stmtBills = $this->conn->prepare($sqlBills);
            $stmtBills->bind_param("i", $invoiceNo);
            $stmtBills->execute();
            $this->conn->commit();

            $stmtArchive->close();
            $stmtBills->close();
            return 1;
        } catch (Exception $e) {
            $this->conn->rollback();
            echo "Failed to discard bill: " . $e->getMessage();
            return 0;
        }
    }

    function displayBillHistory($cashier_id){
        $sql = "SELECT * FROM bills WHERE cashier = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $cashier_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $bills = [];

        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $bills[] = $row;
            }
        }

        $stmt->close();
        return $bills;
    }
}

$cashier = new Cashier();