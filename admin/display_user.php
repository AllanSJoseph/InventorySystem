<?php
require "admin.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Admincss/displaytable.css">
    <link rel="stylesheet" href="Admincss/nav.css">
</head>
<body>
    <nav>
            <a href="add_user.php">Add a New User (Stocker/Cashier)</a>
            <a href="display_user.php">Display All Users</a>
            <a href="display_bills.php">Display Bill Records</a>
            <a href="display_inventory.php">Display Inventory</a>
            <a href="../logout.php">Logout</a>
    </nav>
    <h1>Showing Stockers and Cashiers Registered to this database...</h1>

    <?php 
      $users = $admin->displayUsers();

      if(empty($users)){
        echo "<centre><p class='text-centre'><b>No Users</b></p><centre>";
        $disabled = "disabled";
      }else{
        echo '<table border="1">';
            echo '<table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">UserId</th>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Address</th>
                <th scope="col">Type</th>
                <th scope="col">Actions</th>
              </tr>
            </thead><tbody>';
  
            $disabled = "";
            $count = 1;
  
            foreach($users as $row){
                echo '<tr>';
                  echo '<td>' . $count . '</td>';
                  echo '<td>'.$row["userid"].'</td>';
                  echo '<td>' . $row["username"] . '</td>';
                  echo '<td>' . $row["email"] . '</td>';
                  echo '<td>' . $row["phone"] . '</td>';
                  echo '<td>' . $row["address"] . '</td>';
                  echo '<td>' . $row["type"] . '</td>';
                  echo '<td><button class="btn btn-outline-primary" onclick="deleteUser('.$row["userid"].')">Delete</button>';
                  echo '</tr>';
    
                  $count++;
              }
        }
    ?>

<script src="adminscripts.js"></script>
    
</body>
</html>