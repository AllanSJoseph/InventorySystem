<?php

require __DIR__.'/../config.php';


class Stocker extends Database{

    function addItem($name, $price, $stock, $description){
        $sql = "INSERT INTO products (name, price, stock, description) VALUES (?,?,?,?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param('siis', $name, $price, $stock, $description);

        if($stmt->execute()){
            return 1;
        }else{
            return 0;
        }

        $stmt->close();
    }

    function displayItem($prodid){
        $sql = "SELECT * FROM products WHERE id = :prodid";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(':prodid', $prodid);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            echo "<h2>Product Details</h2>";
            echo "Product ID: " . htmlspecialchars($product['id']) . "<br>";
            echo "Name: " . htmlspecialchars($product['Name']) . "<br>";
            echo "Price: $" . htmlspecialchars($product['Price']) . "<br>";
            echo "Stock: " . htmlspecialchars($product['Stock']) . "<br>";
        } else {
            echo "No product found with ID: " . htmlspecialchars($prodid);
        }

        $stmt->close();
    }

    function returnProdDetails($prodid){
        $sql = "SELECT prodid, name, price, stock, description FROM products WHERE prodid = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i',$prodid);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    function updateItem($prodid, $name, $price, $stock, $description){
        $sql = "UPDATE products 
                SET name = ?, price = ?, stock = ?, description = ? 
                WHERE prodid = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param('siisi', $name, $price, $stock, $description, $prodid);

        if($stmt->execute()){
            return 1;
        }else{
            return 0;
        }

        $stmt->close();
    }

    function updateStock($pid, $newStock){
        $sql = "UPDATE products SET stock = ? WHERE prodid = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $newStock, $pid);

        if($stmt->execute()){
            return 1;
        }else{
            return 0;
        }

        $stmt->close();
    }

    function deleteItem($prodid){
        $sql = "DELETE FROM products WHERE prodid = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $prodid);

        if($stmt->execute()){
            $stmt->close();
            return 1;
        }else{
            $stmt->close();
            return 0;
        }
    }

    function displayProductInventory(){
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

$stocker = New Stocker();