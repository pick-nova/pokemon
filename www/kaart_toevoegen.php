<?php
require 'database.php';

session_start();

// if ($_SESSION['role'] != 'employee') {
//     echo "Je hebt geen toegang tot deze pagina.";
//     exit;
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    if (!isset($_POST['name']) || empty(trim($_POST['name']))) {
        $errors[] = "Naam is verplicht.";
    }
    if (!isset($_POST['type']) || empty(trim($_POST['type']))) {
        $errors[] = "Type is verplicht.";
    }
    if (!isset($_POST['rarity']) || empty(trim($_POST['rarity']))) {
        $errors[] = "Rarity is verplicht.";
    }
    if (!isset($_POST['price']) || empty(trim($_POST['price'])) || !is_numeric($_POST['price'])) {
        $errors[] = "Prijs is verplicht en moet een getal zijn.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    } else {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $rarity = mysqli_real_escape_string($conn, $_POST['rarity']);
        $price = (float) $_POST['price'];

        $sql = "INSERT INTO Cards (name, type, rarity, price) VALUES ('$name', '$type', '$rarity', $price)";

        if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green;'>Kaart succesvol toegevoegd!</p>";
        } else {
            echo "<p style='color:red;'>Fout bij toevoegen van kaart: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaart Toevoegen</title>
</head>
<body>
    <h1>Kaart Toevoegen</h1>
    <form method="POST" action="kaart_toevoegen.php">
        <label for="name">Naam:</label><br>
        <input type="text" id="name" name="name"><br><br>

        <label for="type">Type:</label><br>
        <input type="text" id="type" name="type"><br><br>

        <label for="rarity">Rarity:</label><br>
        <input type="text" id="rarity" name="rarity"><br><br>

        <label for="price">Prijs (€):</label><br>
        <input type="text" id="price" name="price"><br><br>

        <button type="submit">Kaart Toevoegen</button>
    </form>

    <div class="nav-buttons">
        <a href="index.php" class="button">Terug naar overzicht</a>
    </div>
</body>
</html>
