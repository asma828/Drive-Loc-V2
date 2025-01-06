<?php
session_start();
include '../includes/autoloader.php';

$database = new Database();
$db = $database->getConnection();
$vehicleObj = new Vehicle($db);
$reviewObj = new Review($db);

$id = isset($_GET['id']) ? $_GET['id'] : die('ID not specified');
$vehicle = $vehicleObj->getVehicleById($id);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($vehicle['name']) ?> - Drive & Loc</title>
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

    <!-- Vehicle Details Section -->
    <div class="container mx-auto px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Left Column: Images -->
            <div class="space-y-6">
                <div class="bg-white p-2 rounded-lg shadow-lg">
                    <img src="<?= htmlspecialchars($vehicle['image']) ?>" 
                         alt="<?= htmlspecialchars($vehicle['name']) ?>"
                         class="w-full h-96 object-cover rounded">
                </div>
    
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white p-2 rounded-lg shadow">
                        <img src="<?= htmlspecialchars($vehicle['image']) ?>" 
                             class="w-full h-24 object-cover rounded cursor-pointer hover:opacity-75">
                    </div>
                
                </div>
            </div>

            <!-- Right Column: Details -->
            <div class="space-y-8">
                <div>
                    <h1 class="heading-font text-4xl mb-2"><?= htmlspecialchars($vehicle['name']) ?></h1>
                    <p class="text-xl text-gray-600"><?= htmlspecialchars($vehicle['model']) ?></p>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="flex items-center text-gold">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="text-gray-600">(12 avis)</span>
                </div>

                <div class="bg-black text-white p-6 rounded-lg">
                    <div class="text-3xl font-light mb-2">
                        <?= number_format($vehicle['prix'], 2) ?>€ <span class="text-sm">/jour</span>
                    </div>
                    <p class="text-gray-400">Prix incluant l'assurance et l'assistance 24/7</p>
                </div>

                <!-- Vehicle Specifications -->
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <i class="fas fa-cog text-gold mb-2"></i>
                        <h3 class="font-semibold">Transmission</h3>
                        <p class="text-gray-600">Automatique</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <i class="fas fa-tachometer-alt text-gold mb-2"></i>
                        <h3 class="font-semibold">Puissance</h3>
                        <p class="text-gray-600">450 CV</p>
                    </div>
                    
                </div>

                <!-- Reservation Button -->
                <a href="reservation.php?vehicle=<?= $vehicle['id_vechicule'] ?>" 
                   class="block w-full bg-black text-white text-center py-4 rounded-lg hover:bg-gold transition-colors duration-300">
                    Réserver ce véhicule
                </a>
            </div>
        </div>

        <!-- Description Section -->
        <div class="mt-16">
            <h2 class="heading-font text-3xl mb-6">Description</h2>
            <div class="bg-white p-8 rounded-lg shadow">
                <p class="text-gray-600 leading-relaxed">
                    <?= htmlspecialchars($vehicle['description'] ?? 'Description détaillée du véhicule...') ?>
                </p>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-16">
            <h2 class="heading-font text-3xl mb-6">Avis Clients</h2>
           
            <?php 
    $userId = $_SESSION['id_user'];
    
    if ($userId) {
        $canReview = $reviewObj->canUserReview($userId, $id);
        if ($canReview) { 
    ?>
        <!-- Review Form -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <form action="add-review.php" method="POST" class="space-y-4">
                <input type="hidden" name="vehicle_id" value="<?= $id ?>">
                
                <div>
                    <label class="block mb-2">Note</label>
                    <div class="flex space-x-4">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                        <label class="cursor-pointer">
                            <input type="radio" name="rating" value="<?= $i ?>" class="hidden peer">
                            <i class="fas fa-star text-2xl peer-checked:text-gold text-gray-300"></i>
                        </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <div>
                    <label class="block mb-2">Commentaire</label>
                    <textarea name="comment" rows="4" 
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-gold"
                            required></textarea>
                </div>

                <button type="submit" 
                        class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gold transition-colors duration-300">
                    Publier l'avis
                </button>
            </form>
        </div>
    <?php 
        } else {
            echo '<p class="mb-6 text-gray-600">Vous pourrez laisser un avis après avoir loué ce véhicule.</p>';
        }
    }
    ?>

    <!-- Display existing reviews -->
    <div class="space-y-6">
        <?php 
        $reviews = $reviewObj->getReviewsByVehicle($id);
        if($reviews): 
            foreach($reviews as $review): 
                $yourReview = isset($_SESSION['id_user']) && $review['user_id'] == $_SESSION['id_user'];
        ?>
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-semibold"><?= htmlspecialchars($review['user_name']) ?></h3>
                        <div class="flex items-center text-gold text-sm mt-1">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star <?= $i <= $review['rating'] ? 'text-gold' : 'text-gray-300' ?>"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <span class="text-gray-500 text-sm">
                        <?= date('d/m/Y', strtotime($review['created_at'])) ?>
                    </span>
                </div>
                <p class="text-gray-600"><?= htmlspecialchars($review['comment']) ?></p>
                <?php if($yourReview): ?>
                 <div class="flex space-x-3">
                        <button onclick="editReview(<?= $review['id_reviews'] ?>, <?= $review['rating'] ?>, '<?= htmlspecialchars($review['comment'], ENT_QUOTES) ?>')" class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-edit"></i>
                        </button>
                        <a href="delete-review.php?id=<?= $review['id_reviews'] ?>" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div> 
                    <?php endif; ?>
            </div>
        <?php 
            endforeach; 
        else: 
        ?>
            <p class="text-gray-600">Aucun avis pour le moment.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-full max-w-lg">
        <form action="update-review.php" method="POST" class="space-y-4">
            <input type="hidden" name="review_id" id="editReviewId">
            
            <div>
                <label class="block mb-2">Note</label>
                <div class="flex space-x-4">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                    <label>
                        <input type="radio" name="rating" value="<?= $i ?>" class="hidden peer">
                        <i class="fas fa-star text-2xl peer-checked:text-gold text-gray-300"></i>
                    </label>
                    <?php endfor; ?>
                </div>
            </div>

            <div>
                <label class="block mb-2">Commentaire</label>
                <textarea name="comment" id="editComment" rows="4" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-gold"
                        required></textarea>
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" onclick="closeEditModal()" 
                        class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                    Annuler
                </button>
                <button type="submit" 
                        class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gold">
                    Modifier
                </button>
            </div>
        </form>
    </div>
</div>

        <!-- Similar Vehicles -->
        <div class="mt-16">
            <h2 class="heading-font text-3xl mb-6">Véhicules Similaires</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-black text-white py-16">
        
    </footer>

    <script>
function editReview(reviewId, rating, comment) {
    // Set values
    document.getElementById('editReviewId').value = reviewId;
    document.getElementById('editComment').value = comment;
    document.querySelector(`input[name="rating"][value="${rating}"]`).checked = true;
    
    
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>

</body>
</html>