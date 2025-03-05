<?php
session_start();
if(!isset($_SESSION['name'])){
    header('Location: login.php');
    exit();
}

require 'database.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome <?php echo $_SESSION['name']; ?></h1>
    <h1><?php echo "Welkom ". $_SESSION['firstname']; ?></h1>
    <h2><?php echo $_SESSION['role']; ?></h2>

    <div class="nav-buttons">
        <a href="login_homepage.php" class="button">Home</a>
        <a href="logout.php">Logout</a>
        <a href="about_us.php">About us</a>
    </div>
</body>
</html>