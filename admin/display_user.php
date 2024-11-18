<?php
require "admin.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styledisplayUser.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Users</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid black;
            padding: 8px 12px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<?php include 'nav.php'; ?>
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
                  echo '<td><button class="btn btn-outline-primary">Delete</button>';
                  echo '</tr>';
    
                  $count++;
              }
        }
    ?>

    
</body>
</html>