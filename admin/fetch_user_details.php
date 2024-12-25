<?php

session_start();
require "admin.php";

if(!isset($_SESSION['userid'])){
    header("Location: ../index.php");
    exit();
}

if(isset($_GET['userid'])){
    $userid = $_GET['userid'];
}else{
    echo json_encode(['status' => '0', 'message' => 'unable to obtain user details']);
    die;
}

$details = $admin->fetchUserData($userid);

if($details['status'] != 0){
    echo json_encode(['status' => '1', 'message' => 'Details Obtained Successfully', 'details' => $details]);  
}else{
    echo json_encode(['status' => '0', 'message' => 'unable to obtain user details']); 
}
