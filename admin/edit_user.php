<?php
session_start();
require "admin.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userid = $_POST['uid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    

    if ($admin->updateUser($userid, $username, $email, $phone, $address)) {
        echo json_encode(["status" => "1", "message" => "User details updated successfully."]);
    } else {
        echo json_encode(["status" => "0", "message" => "Failed to update user details."]);
    }

}
?>
