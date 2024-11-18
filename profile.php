<?php

require 'config.php';

class Profile extends Database {

    function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $checkDetails = $stmt->get_result();
        $row = $checkDetails->fetch_assoc();

        if ($checkDetails->num_rows === 0) {
            return 0;
        } else {
            if (password_verify($password, $row['password'])) {
                $_SESSION['userid'] = $row['userid'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['username'];
                $_SESSION['usertype'] = $row['type'];
                
                if ($row['type'] === "Admin") {
                    return 1;
                } else if ($row['type'] === "Stocker") {
                    return 2;
                } else {
                    return 3;
                }
            } else {
                return 0;
            }
        }
    }

    function viewProfile($userid) {
        $sql = "SELECT * FROM users WHERE userid = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return [];
        }
    }

    function editProfile($uid, $name, $email, $phone, $address) {
        $sql = "UPDATE users SET name = ?, email = ?, mob_no = ?, address = ? WHERE userid = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssisi", $name, $email, $phone, $address, $uid);

        if ($stmt->execute()) {
            $stmt->close();
            return 0;
        } else {
            echo "Error: " . $stmt->error;
            $stmt->close();
            return 1;
        }
    }
}

$user = new Profile();
