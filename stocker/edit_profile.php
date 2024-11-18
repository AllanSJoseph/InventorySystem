<?php
require __DIR__.'/../profile.php';

session_start();

$uid = intval($_SESSION['userid']);

$details = $user->viewProfile($uid);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["mob"]) && isset($_POST["address"])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mob = $_POST['mob'];
        $address = $_POST['address'];
        $duplicate_entry_err_no = 1062;

        $editStatus = $user->editProfile($uid,$name,$email,$mob,$address);

        if($editStatus){
            echo "<script>alert('OOps, Something Went Wrong, Please Try Again...');</script>";
        }else{
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            echo "<script>";
            echo "alert('Details Updated Successfully!');";
            echo 'window.location.href = "stocker_profile.php"';
            echo "</script>";
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<body>
    
<div class="container-sm loginbox" style="margin-top: 2%;">
       <h1 style="color:DarkSlateGrey;text-align: center;"><b>Change your Details Below...</b></h1>
       <form onsubmit="return validate()" method="POST">
        <label for="name" class="form-label">Name:</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $details['name']; ?>" ><br>

        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $details['email']; ?>" ><br>
        
        <label for="mob" class="form-label">Phone:</label>
        <input type="number" class="form-control" id="mob" name="mob" value="<?php echo $details['phone']; ?>" ><br>

        <label for="address" class="form-label">Address:</label>
        <input type="text" class="form-control" id="address" name="address" value="<?php echo $details['address']; ?>" ><br>
        
        <a class="btn btn-outline-secondary" href="seller_profile.php">Back</a>
        <input type="submit" class="btn btn-outline-success" value="Submit"><br><br>
        </form>
    </div>

    <script>
        function validate(){
            let name = document.getElementById('name').value;
            let email = document.getElementById('email').value;
            let mob = document.getElementById('mob').value;
            let address = document.getElementById('address').value;

            if (name === '' || email === '' || mob === '' || address === '') {
                alert('Please fill in all fields.');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>