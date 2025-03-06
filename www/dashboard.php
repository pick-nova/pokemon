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
    <p>Your email is: <?php echo $_SESSION['email']; ?></p>

    <div class="nav-buttons">
        <a href="index.php" class="button">Home</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>