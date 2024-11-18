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
        $sql = "SELECT * FROM bills WHERE invoiceno = :inv";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(':inv', $invoice_no);
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

    function issueBill($invoiceNo, $totalPrice, $payMethod){
        $sql = "UPDATE bills SET total_price = ?, pay_method = ? WHERE invoiceno = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("dsi", $totalPrice, $payMethod, $invoiceNo);

        if ($stmt->execute()) {
            echo "Bill issued successfully.";
        } else {
            echo "Failed to issue bill.";
        }
        $stmt->close();
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

            echo "Bill discarded successfully.";

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
        $sql = "SELECT * FROM bills WHERE cashier = :cashier";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(':cashier', $cashier_id);
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