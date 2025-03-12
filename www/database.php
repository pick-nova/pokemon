<?php
$dsn = 'mysql:host=mariadb;dbname=pokemon_db';
$username = 'root';
$password = 'password';

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>