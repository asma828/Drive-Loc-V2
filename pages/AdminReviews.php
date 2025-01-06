<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['role'] != 2) {
    header('Location: home.php');
    exit();
}

include '../includes/autoloader.php';


$database = new Database();
$db = $database->getConnection();
$reviewObj= new Review($db);
$affichereviews=$reviewObj->afficheReviews();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="fixed w-64 h-full bg-black text-white p-6">
        <div class="mb-8">
            <h1 class="text-2xl font-light tracking-widest">DRIVE & LOC</h1>
            <p class="text-sm text-gray-400">Administration</p>
        </div>
        
        <nav class="space-y-2">
            <a href="admin.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800">
                <i class="fas fa-chart-bar"></i>
                <span>Dashboard</span>
            </a>
            <a href="AdminVehicles.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800">
                <i class="fas fa-car"></i>
                <span>Véhicules</span>
            </a>
            <a href="Adminreservation.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800">
                <i class="fas fa-calendar"></i>
                <span>Réservations</span>
            </a>
            
            <a href="AdminReviews.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg bg-white text-black">
                <i class="fas fa-star"></i>
                <span>Avis</span>
            </a>
        </nav>
    </div>
    <div class="flex">
        <!-- Main Content -->
        <div class="ml-64 flex-1 p-8">
            <h2 class="text-3xl font-light mb-6">Gestion des Avis</h2>

            <!-- Filters -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <select class="border rounded-lg px-4 py-2">
                        <option>Note</option>
                        <option>5 étoiles</option>
                        <option>4 étoiles</option>
                        <option>3 étoiles</option>
                        <option>2 étoiles</option>
                        <option>1 étoile</option>
                    </select>
                    <select class="border rounded-lg px-4 py-2">
                        <option>Véhicule</option>
                    </select>
                    <input type="text" placeholder="Client..." class="border rounded-lg px-4 py-2">
                    <button class="bg-gray-800 text-white rounded-lg px-4 py-2">Filtrer</button>
                </div>
            </div>

            <!-- Reviews Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Review Card -->
    <?php foreach($affichereviews as $review):?>
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center">
                                <img src="<?= htmlspecialchars($review['image'])?>" class="h-10 w-10 rounded-full mr-3">
                                <div>
                                    <div class="font-medium"><?= htmlspecialchars($review['client'])?></div>
                                    <div class="text-sm text-gray-500"><?= htmlspecialchars($review['rating'])?></div>
                                </div>
                            </div>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="font-medium mb-1"><?= htmlspecialchars($review['name'])?></div>
                            <p class="text-gray-600"><?= htmlspecialchars($review['comment'])?></p>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button class="text-gray-600 hover:text-gray-900">
                                <i class="fas fa-eye"></i>
                            </button>
                            <a href="deletereview.php?id=<?php echo $review['id_reviews']?>" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
             <?php   endforeach;?>
                

            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">3</a>
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</body>
</html>