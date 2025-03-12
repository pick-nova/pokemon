<?php
require 'database.php';
require 'vendor/autoload.php';

use Carbon\Carbon;

if (!isset($_GET['id'])) {
    die("Geen kaart ID opgegeven.");
}

$card_id = $_GET['id'];

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Haal de kaartgegevens op
    $sql = "SELECT * FROM Cards WHERE card_id = :card_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['card_id' => $card_id]);
    $card = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$card) {
        die("Kaart niet gevonden.");
    }

    // Haal types en rarities op
    $types = $conn->query("SELECT * FROM types")->fetchAll(PDO::FETCH_ASSOC);
    $rarities = $conn->query("SELECT * FROM rarities")->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $type = $_POST['type'];
        $rarity = $_POST['rarity'];
        $price = $_POST['price'];

        $update_sql = "UPDATE Cards SET name = :name, type = :type, rarity = :rarity, price = :price WHERE card_id = :card_id";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->execute([
            'name' => $name,
            'type' => $type,
            'rarity' => $rarity,
            'price' => $price,
            'card_id' => $card_id
        ]);

        header("Location: index.php");
        exit;
    }
} catch (PDOException $e) {
    die("Databasefout: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaart Bewerken</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto mt-10 bg-white p-8 shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold mb-6">Kaart Bewerken</h2>
        <form method="POST">
            <label class="block mb-2">Naam:</label>
            <input type="text" name="name" value="<?php echo($card['name']); ?>" required class="w-full p-2 border rounded mb-4">
            
            <label class="block mb-2">Type:</label>
            <select name="type" class="w-full p-2 border rounded mb-4">
                <?php foreach ($types as $t): ?>
                    <option value="<?php echo $t['id']; ?>" <?php if ($t['id'] == $card['type']) echo 'selected'; ?>>
                        <?php echo($t['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label class="block mb-2">Rarity:</label>
            <select name="rarity" class="w-full p-2 border rounded mb-4">
                <?php foreach ($rarities as $r): ?>
                    <option value="<?php echo $r['id']; ?>" <?php if ($r['id'] == $card['rarity']) echo 'selected'; ?>>
                        <?php echo($r['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label class="block mb-2">Prijs:</label>
            <input type="number" step="0.01" name="price" value="<?php echo($card['price']); ?>" required class="w-full p-2 border rounded mb-4">
            
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Opslaan</button>
            <a href="index.php" class="text-blue-500 hover:text-blue-700 ml-4">Annuleren</a>
        </form>
    </div>
</body>
</html>
