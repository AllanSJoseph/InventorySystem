<?php
//Including the config.php which contains the database parent class.
require __DIR__.'/../config.php';

//Class which contains the features of the admin
class Admin extends Database{

    function addUser($username, $password, $email, $phone, $address, $type){
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, email, phone, address, type)
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param('ssssss', $username, $hashedPassword, $email, $phone, $address, $type);

        if($stmt->execute()){
            return 1;
        }else{
            return 0;
        }

    }

    function displayUsers($type = 'all'){
        if ($type === "all") {
            $sql = "SELECT userid, username, email, phone, address, type FROM users";
        } else {
            $sql = "SELECT userid, username, email, phone, address, type FROM users WHERE type = :type";
        }

        $stmt = $this->conn->prepare($sql);

        if ($type !== "all") {
            $stmt->bind_param(':type', $type);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];

        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $users[] = $row;
            }
        }

        $stmt->close();
        return $users;
    }

    function deleteUser($userId){
        $sql = "DELETE FROM users WHERE userid = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$userId);
        
        if($stmt->execute()){
            return 1;
        }else{
            return 0;
        }
    }

    function displayBillHistory(){
        $sql = "SELECT b.invoiceno, b.date, b.total_price, b.paymethod, u.username FROM 
        bills b JOIN users u ON b.cashier = u.userid;";

        $stmt = $this->conn->prepare($sql);
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

    function displayInventory(){
        $sql = "SELECT * FROM products";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $inventory = [];

        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $inventory[] = $row;
            }
        }

        $stmt->close();
        return $inventory;
    }
}

$admin = New Admin();