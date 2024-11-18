<?php

require '../cashier.php';

class Bill extends Cashier{
    function addEntry($invoiceno,$prodid,$quantity,$tprice){
        $sql = "SELECT ba.invoiceno, ba.prodid, ba.qty, ba.tprice, p.name, p.price 
        FROM bill_archive AS ba
        JOIN products AS p ON ba.prodid = p.prodid
        WHERE ba.invoiceno = ? AND ba.prodid = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $invoiceno, $prodid);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            // echo "Duplicate Entry!!";
            $row = $result->fetch_assoc();
            $newqty = intval($row["qty"]) + $quantity;
            $prprice = $row["price"];
            if($this->editQuantity($invoiceno,$prodid,$prprice,$newqty)){
                return 1;
            }else{
                return 0;
            }
        }else{
            $sql = "INSERT INTO bill_archive (invoiceno, prodid, qty, tprice) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiii", $invoiceno, $prodid, $quantity, $tprice);

            if ($stmt->execute()) {
                return 1;
            } else {
                return 0;
        }
        }


        
    }

    function fetchBillData($invoiceno){
        
        $sql = "
        SELECT ba.invoiceno, ba.prodid, ba.qty, ba.tprice, p.name, p.price 
        FROM bill_archive AS ba
        JOIN products AS p ON ba.prodid = p.prodid
        WHERE ba.invoiceno = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$invoiceno);
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

    function returnProdDetails($prodid){
        $sql = "SELECT prodid,name,price,stock FROM products WHERE prodid = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i',$prodid);
        $stmt->execute();
        $result = $stmt->get_result();
        // $stmt->close();

        return $result;
    }

    function editQuantity($invoiceno,$prodid,$price,$quantity){
        $newTPrice = $price * $quantity;
        $sql = "UPDATE bill_archive SET qty = ?, tprice = ? WHERE invoiceno = ? AND prodid = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiii",$quantity,$newTPrice,$invoiceno,$prodid);

        if($stmt->execute()){
            $stmt->close();
            return 1;
        }else{
            $stmt->close();
            return 0;
        }
    }

    function deleteEntry($invoiceno,$prodid){
        $sql = "DELETE FROM bill_archive WHERE invoiceno = ? AND prodid = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii",$invoiceno,$prodid);
        if($stmt->execute()){
            $stmt->close();
            return 1;
        }else{
            $stmt->close();
            return 0;
        }
    }
}

$bill = new Bill();