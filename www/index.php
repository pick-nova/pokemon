<?php
require 'database.php';

$sql = "SELECT * FROM Cards";
$result = mysqli_query($conn, $sql);

require 'vendor/autoload.php';

use Carbon\Carbon;

printf("Now: %s", Carbon::now(1));

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Verzameling</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white text-center py-4">
        <h1 class="text-3xl font-bold">Pokémon Verzameling</h1>

        <a href="login.php" class="text-blue-500 hover:text-blue-700">inloggen</a>
        
    </header>
    <div class="max-w-7xl mx-auto px-8 py-12">
        <h2 class="text-3xl font-bold mb-8">Mijn Pokémon Kaarten</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="https://assets.pokemon.com/assets/cms2/img/pokedex/full/0<?php echo $row['card_id']; ?>.png" 
                        alt="<?php echo $row['name']; ?>" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($row['type']); ?> type Pokémon</p>
                        <p class="text-gray-800 font-semibold">Rarity: <?php echo htmlspecialchars($row['rarity']); ?></p>
                        <p class="text-green-600 font-bold">Prijs: €<?php echo number_format($row['price'], 2); ?></p>
                        
                    </div>
                    <a href="details_kaart.php?id=<?php echo $row['card_id']; ?>" class="text-blue-500 hover:text-blue-700">
                     <button class="bg-blue-500 text-white px-4 py-2 rounded">Bekijk Details</button>
                    </a>

                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <footer class="bg-gray-800 text-white text-center py-4">
        &copy; 2021 Pokémon Verzameling
    
</body>
</html>
