<?php 

session_start();

echo "Logging Out";

if (isset($_SESSION['userid']) && isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['usertyp'])){
    unset($_SESSION['userid']);
    unset($_SESSION['email']);
    unset($_SESSION['name']);
    unset($_SESSION['usertyp']);
}
              
header("Location: index.php");