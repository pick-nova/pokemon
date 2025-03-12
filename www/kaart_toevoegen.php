<?php
require 'database.php';

session_start();

// if ($_SESSION['role'] != 'employee') {
//     echo "Je hebt geen toegang tot deze pagina.";
//     exit;
// }


$stmt = $conn->prepare("SELECT * FROM types");
$stmt->execute();
$types = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM rarities");
$stmt->execute();
$rarities = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
        $name = $_POST['name'];
        $type = $_POST['type'];
        $rarity = $_POST['rarity'];
        $price = (float) $_POST['price'];

        try {
            $sql = "INSERT INTO Cards (name, type, rarity, price) VALUES (:name, :type, :rarity, :price)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':rarity', $rarity);
            $stmt->bindParam(':price', $price);

            if ($stmt->execute()) {
                echo "<p style='color:green;'>Kaart succesvol toegevoegd!</p>";
            } else {
                echo "<p style='color:red;'>Fout bij toevoegen van kaart.</p>";
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Fout bij toevoegen van kaart: " . $e->getMessage() . "</p>";
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
    <div>
        <label for="rarity">Rarity:</label><br>
        <select name="rarity" id="rarity">
            <?php foreach ($rarities as $rarity): ?>
                <option value="<?php echo $rarity['id']; ?>"><?php echo $rarity['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
        <label for="price">Prijs (€):</label><br>
        <input type="text" id="price" name="price"><br><br>

        <div class="form-group flex">
            <label for="type">Selecteer een Type pokemon:</label>
            <select name="type" id="type">
                <?php foreach ($types as $type): ?>
                    <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
                <?php endforeach; ?> 
            </select>
        </div>

        <button type="submit">Kaart Toevoegen</button>
    </form>

    <div class="nav-buttons">
        <a href="index.php" class="button">Terug naar overzicht</a>
    </div>
</body>
</html>
