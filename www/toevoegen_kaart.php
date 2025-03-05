<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Haal de gegevens uit het formulier op en escape ze voor veiligheid
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $rarity = mysqli_real_escape_string($conn, $_POST['rarity']);
    $price = floatval($_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $hp = isset($_POST['hp']) ? intval($_POST['hp']) : null;
    $attack = !empty($_POST['attack']) ? mysqli_real_escape_string($conn, $_POST['attack']) : null;
    $ability = !empty($_POST['ability']) ? mysqli_real_escape_string($conn, $_POST['ability']) : null;
    $weaknesses = !empty($_POST['weaknesses']) ? mysqli_real_escape_string($conn, $_POST['weaknesses']) : null;
    $resistances = !empty($_POST['resistances']) ? mysqli_real_escape_string($conn, $_POST['resistances']) : null;
    $retreat_cost = isset($_POST['retreat_cost']) ? intval($_POST['retreat_cost']) : null;

    // Voeg de kaart toe aan de 'Cards' tabel
    $sql_card = "INSERT INTO Cards (name, type, rarity, price, description) VALUES ('$name', '$type', '$rarity', $price, '$description')";
    if (mysqli_query($conn, $sql_card)) {
        $card_id = mysqli_insert_id($conn); // Haal de ID van de toegevoegde kaart op

        // Voeg details toe aan de 'Details' tabel
        $sql_details = "INSERT INTO Details (card_id, hp, attack, ability, weaknesses, resistances, retreat_cost) 
                        VALUES ($card_id, $hp, '$attack', '$ability', '$weaknesses', '$resistances', $retreat_cost)";

        if (mysqli_query($conn, $sql_details)) {
            echo "<p class='text-green-600'>Kaart succesvol toegevoegd!</p>";
        } else {
            echo "<p class='text-red-600'>Fout bij het toevoegen van details: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p class='text-red-600'>Fout bij het toevoegen van kaart: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voeg een nieuwe Pokémon Kaart toe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white text-center py-4">
        <h1 class="text-3xl font-bold">Nieuwe Pokémon Kaart Toevoegen</h1>
        <a href="index.php" class="text-blue-500 hover:text-blue-700">Terug naar overzicht</a>
    </header>

    <div class="max-w-4xl mx-auto px-8 py-12 bg-white rounded-lg shadow-lg mt-8">
        <form action="toevoegen_kaart.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-gray-700">Naam:</label>
                <input type="text" name="name" required class="w-full border px-2 py-1">
            </div>
            <div>
                <label class="block text-gray-700">Type:</label>
                <input type="text" name="type" required class="w-full border px-2 py-1">
            </div>
            <div>
                <label class="block text-gray-700">Zeldzaamheid:</label>
                <input type="text" name="rarity" required class="w-full border px-2 py-1">
            </div>
            <div>
                <label class="block text-gray-700">Prijs:</label>
                <input type="number" name="price" step="0.01" required class="w-full border px-2 py-1">
            </div>
            <div>
                <label class="block text-gray-700">Beschrijving:</label>
                <textarea name="description" class="w-full border px-2 py-1"></textarea>
            </div>

            <!-- Extra details voor de 'Details' tabel -->
            <div>
                <label class="block text-gray-700">HP:</label>
                <input type="number" name="hp" class="w-full border px-2 py-1">
            </div>
            <div>
                <label class="block text-gray-700">Aanval:</label>
                <input type="text" name="attack" class="w-full border px-2 py-1">
            </div>
            <div>
                <label class="block text-gray-700">Vaardigheid:</label>
                <input type="text" name="ability" class="w-full border px-2 py-1">
            </div>
            <div>
                <label class="block text-gray-700">Zwaktes:</label>
                <input type="text" name="weaknesses" class="w-full border px-2 py-1">
            </div>
            <div>
                <label class="block text-gray-700">Weerstanden:</label>
                <input type="text" name="resistances" class="w-full border px-2 py-1">
            </div>
            <div>
                <label class="block text-gray-700">Terugtrekkosten:</label>
                <input type="number" name="retreat_cost" class="w-full border px-2 py-1">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Kaart Toevoegen</button>
        </form>
    </div>

    <footer class="bg-gray-800 text-white text-center py-4 mt-8">
        &copy; 2021 Pokémon Verzameling
    </footer>
</body>
</html>
