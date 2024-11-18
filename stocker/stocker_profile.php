<?php 
require __DIR__.'/../profile.php';

session_start();

if(!isset($_SESSION['userid'])){
    header("Location: ../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stocker Profile</title>
</head>
<body>
<?php 
$details = $user->viewProfile($_SESSION['userid']);
?>
    <h1>Your Profile</h1>

    <h2><b>UserId:</b> <?php echo $details['userid']; ?></h2>
    <h2><b>Name:</b> <?php echo $details['username']; ?></h2>
    <h3><b>Email:</b> <?php echo $details['email']; ?></h3>
    <h3><b>Phone:</b> <?php echo $details['phone']; ?></h3>
    <h3><b>Address:</b> <?php echo $details['address']; ?></h3>

    <nav>
        <a href="stocker_home.php">Home</a>
        <a href="change_pwd.php">Change Password</a>
        <a href="edit_profile.php">Edit Profile</a>
    </nav>
</body>
</html>