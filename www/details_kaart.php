<?php
require 'database.php';

if (isset($_GET['id'])) {
    $card_id = intval($_GET['id']);

    $sql_card = "SELECT * FROM Cards WHERE card_id = $card_id";
    $result_card = mysqli_query($conn, $sql_card);

    $sql_details = "SELECT * FROM Details WHERE card_id = $card_id";
    $result_details = mysqli_query($conn, $sql_details);

    if ($result_card && mysqli_num_rows($result_card) > 0) {
        $card = mysqli_fetch_assoc($result_card);
        $details = mysqli_fetch_assoc($result_details); 
    } else {
        echo "<h2>Kaart niet gevonden!</h2>";
        exit;
    }
} else {
    echo "<h2>Ongeldig verzoek!</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaart Details - <?php echo($card['name']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white text-center py-4">
        <h1 class="text-3xl font-bold">Pokémon Kaart Details</h1>
        <a href="index.php" class="text-blue-500 hover:text-blue-700">Terug naar overzicht</a>
    </header>

    <div class="max-w-4xl mx-auto px-8 py-12 bg-white rounded-lg shadow-lg mt-8">
        <div class="flex flex-col md:flex-row items-center">
            <img src="https://assets.pokemon.com/assets/cms2/img/pokedex/full/0<?php echo $card['card_id']; ?>.png" 
                alt="<?php echo($card['name']); ?>" class="w-64 h-64 object-cover mb-4 md:mb-0 md:mr-8">
            
            <div>
                <h2 class="text-3xl font-bold mb-4"><?php echo($card['name']); ?></h2>
                <p class="text-gray-600 mb-2">Type: <?php echo($card['type']); ?></p>
                <p class="text-gray-600 mb-2">Rarity: <?php echo($card['rarity']); ?></p>
                <p class="text-gray-800 font-semibold mb-2">Prijs: €<?php echo number_format($card['price'], 2); ?></p>
                <p class="text-gray-600 mb-4">
                    Beschrijving: <?php echo isset($card['description']) && $card['description'] !== null ? nl2br(htmlspecialchars($card['description'])) : 'Geen beschrijving beschikbaar.'; ?>
                </p>

                <!-- Extra details weergeven als ze beschikbaar zijn -->
                <?php if ($details): ?>
                    <div class="mt-4">
                        <p class="text-gray-600 mb-2">HP: <?php echo($details['hp'] ?? 'N/A'); ?></p>
                        <p class="text-gray-600 mb-2">Aanval: <?php echo($details['attack'] ?? 'N/A'); ?></p>
                        <p class="text-gray-600 mb-2">Vaardigheid: <?php echo($details['ability'] ?? 'Geen'); ?></p>
                        <p class="text-gray-600 mb-2">Zwaktes: <?php echo($details['weaknesses'] ?? 'Geen'); ?></p>
                        <p class="text-gray-600 mb-2">Weerstanden: <?php echo($details['resistances'] ?? 'Geen'); ?></p>
                        <p class="text-gray-600 mb-2">Terugtrekkosten: <?php echo($details['retreat_cost'] ?? 'N/A'); ?></p>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600 mb-2">Geen extra details beschikbaar.</p>
                <?php endif; ?>

                <a href="index.php" class="text-blue-500 hover:text-blue-700">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Terug naar overzicht</button>
                </a>
            </div>
        </div>
    </div>

    <footer class="bg-gray-800 text-white text-center py-4 mt-8">
        &copy;
