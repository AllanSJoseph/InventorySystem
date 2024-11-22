<?php 
session_start();
include("admin.php");

if(!isset($_SESSION['userid'])){
    header("Location: ../index.php");
    exit();
}

if(isset($_GET['userid'])){
    $userid = $_GET['userid'];
}else{
    echo "Invalid UserID";
}

if($admin->deleteUser($userid)){
    echo "success";
}else{
    echo "Something Went Wrong, Please Try again later...";
}


?>