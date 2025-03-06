<?php
session_start();

require 'database.php';

if (!isset($_POST['email'])) {
    echo "email key bestaat niet";
    exit;
}
if (!isset($_POST['password'])) {
    echo "password key bestaat niet";
    exit;
}

if (empty($_POST['email'])) {
    echo "email is leeg";
    exit;
}

if (empty($_POST['password'])) {
    echo "password is leeg";
    exit;
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM Customers WHERE email = '$email' ";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!is_array($user)) {
    echo 'No user is found';
    exit;
}

if ($password != $user['password']) {
    echo "ohoh wachtwoord is niet correct!";
    exit;
}

$_SESSION['email'] = $user['email'];
$_SESSION['name'] = $user['name'];
$_SESSION['password'] = $user['password'];
$_SESSION['address'] = $user['address'];
$_SESSION['created_at'] = $user['created_at'];

header("location: dashboard.php");
exit;