<?php
include '../includes/autoloader.php';


$database = new Database();
$db = $database->getConnection();

$vehicleObj = new Vehicle($db);
$categoryObj = new Category($db);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$category = isset($_GET['category']) ? $_GET['category'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit = 6; 

$filters = [
    'category' => $category,
    'search' => $search
];

$vehicles = $vehicleObj->getVehicles($page, $limit, $filters);
$total = $vehicleObj->getTotalCount($filters);
$total_pages = ceil($total / $limit);
$categories = $categoryObj->getAllCategories();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Véhicules - Drive & Loc</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@200;300;400;500;600&display=swap');
        
        body {
            font-family: 'Montserrat', sans-serif;
        }
        
        .heading-font {
            font-family: 'Playfair Display', serif;
        }
        
        .hover-scale {
            transition: transform 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-black text-white">
        <div class="container mx-auto px-8 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-16">
                    <a href="home.php" class="text-2xl font-light tracking-widest">
                        DRIVE & LOC
                    </a>
                    <div class="hidden md:flex space-x-8">
                        <a href="vehicles.php" class="text-sm tracking-wider text-gold">VÉHICULES</a>
                        <a href="affichereservation.php" class="text-sm tracking-wider hover:text-gold transition-colors duration-300">RÉSERVER</a>
                        <a href="reviews.php" class="text-sm tracking-wider hover:text-gold transition-colors duration-300">AVIS</a>
                    </div>
                </div>
                <div class="flex items-center space-x-8">
                    <a href="logout.php" class="text-sm bg-white text-black px-6 py-2 hover:bg-gold transition-colors duration-300">LOGOUT</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-black text-white py-20">
        <div class="container mx-auto px-8">
            <h1 class="heading-font text-5xl mb-6">Notre Flotte d'Exception</h1>
            <p class="text-xl font-light max-w-2xl">Découvrez notre sélection de véhicules de prestige pour une expérience de conduite inoubliable.</p>
        </div>
    </header>

    <!-- Filters Section -->
    <section class="py-8 bg-white border-b">
        <div class="container mx-auto px-8">
            <form method="GET" class="flex flex-wrap items-center gap-6">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="<?= htmlspecialchars($search) ?>"
                           placeholder="Rechercher un véhicule..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-black">
                </div>
                <select name="category" 
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-black">
                    <option value="">Toutes les catégories</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?= $cat['id_categorie'] ?>" 
                                <?= $category == $cat['id_categorie'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" 
                        class="px-6 py-2 bg-black text-white hover:bg-gold transition-colors duration-300">
                    Filtrer
                </button>
            </form>
        </div>
    </section>

    <!-- Vehicles Grid -->
    <section class="py-16">
        <div class="container mx-auto px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach($vehicles as $vehicle): ?>
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale">
                        <div class="relative">
                            <img src="<?= htmlspecialchars($vehicle['image']) ?>" 
                                 alt="<?= htmlspecialchars($vehicle['name']) ?>"
                                 class="w-full h-64 object-cover">
                            <div class="absolute top-4 right-4 bg-black text-white px-4 py-2 text-sm">
                                À partir de <?= number_format($vehicle['prix'], 2) ?>€/jour
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($vehicle['name']) ?></h3>
                            <p class="text-gray-600 mb-4">
                                <?= htmlspecialchars($vehicle['model']) ?> - 
                                <?= htmlspecialchars($vehicle['category_name']) ?>
                            </p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-star text-gold"></i>
                                    <span>4.9 (12 avis)</span>
                                </div>
                                <a href="vehicle_details.php?id=<?= $vehicle['id_vechicule'] ?>" 
                                   class="bg-black text-white px-6 py-2 hover:bg-gold transition-colors duration-300">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if($total_pages > 1): ?>
                <div class="mt-12 flex justify-center">
                    <div class="flex space-x-2">
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="?page=<?= $i ?>&category=<?= $category ?>&search=<?= urlencode($search) ?>"
                               class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded 
                                      hover:bg-black hover:text-white transition-colors duration-300
                                      <?= $page === $i ? 'bg-black text-white' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

     <!-- Footer -->
     <footer class="bg-black text-white py-16">
        <div class="container mx-auto px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div>
                    <h4 class="text-2xl font-light mb-6">DRIVE & LOC</h4>
                    <p class="text-gray-400">L'excellence automobile à votre service.</p>
                </div>
                <div>
                    <h5 class="text-sm font-medium mb-4">NAVIGATION</h5>
                    <ul class="space-y-2">
                        <li><a href="/vehicles.php" class="text-gray-400 hover:text-white">Véhicules</a></li>
                        <li><a href="/reservation.php" class="text-gray-400 hover:text-white">Réservation</a></li>
                        <li><a href="/reviews.php" class="text-gray-400 hover:text-white">Avis Clients</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-sm font-medium mb-4">CONTACT</h5>
                    <ul class="space-y-2 text-gray-400">
                        <li>+33 1 23 45 67 89</li>
                        <li>contact@driveloc.com</li>
                        <li>75008 Paris, France</li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-sm font-medium mb-4">NEWSLETTER</h5>
                    <form class="space-y-4">
                        <input type="email" placeholder="Votre email" class="w-full bg-transparent border-b border-gray-700 py-2 focus:outline-none focus:border-white">
                        <button class="w-full bg-white text-black py-2 hover:bg-gold transition-colors duration-300">
                            S'INSCRIRE
                        </button>
                    </form>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-16 pt-8 flex justify-between items-center">
                <p class="text-gray-400">© 2024 Drive & Loc. Tous droits réservés.</p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>