
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

$reservationObj = new Reservation($db);
$afficherreservation=$reservationObj->affichereservation();

$vechiculeObj= new Vehicle($db);

$utilisateurObj= new Utilisateur($database);
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
            <a href="Adminreservation.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg bg-white text-black">
                <i class="fas fa-calendar"></i>
                <span>Réservations</span>
            </a>
            <a href="AdminReviews.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800">
                <i class="fas fa-star"></i>
                <span>Avis</span>
            </a>
          
        </nav>
    </div>
<div class="flex">
        <!-- Main Content -->
        <div class="ml-64 flex-1 p-8">
            <h2 class="text-3xl font-light mb-6">Gestion des Réservations</h2>

            <!-- Filters -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <select class="border rounded-lg px-4 py-2">
                        <option>Status</option>
                    </select>
                    <input type="date" class="border rounded-lg px-4 py-2">
                    <input type="text" placeholder="Client..." class="border rounded-lg px-4 py-2">
                    <button class="bg-gray-800 text-white rounded-lg px-4 py-2">Filtrer</button>
                </div>
            </div>

            <!-- Reservations Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Image</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Client</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Véhicule</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Durée</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Montant</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                        <?php foreach($afficherreservation as $reservation): ?>
                            <td class="h-8 w-8 rounded-full mr-3">
                                <img src="<?= htmlspecialchars( $reservation['image']) ?>" alt="">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    
                                    <div>
                                        <div class="font-medium"><?= htmlspecialchars( $reservation['client']) ?></div>
                                        
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4"><?= htmlspecialchars( $reservation['name']) ?></td>
                            <td class="px-6 py-4">
                                
                                <div class="text-sm text-gray-500"><?= htmlspecialchars( $reservation['durée']) ?>jour</div>
                            </td>
                            <td class="px-6 py-4"><?= htmlspecialchars( $reservation['prix']) ?>€</td>
                            <td class="px-6 py-4">
                            
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                <?= htmlspecialchars( $reservation['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-3">
                                    <button class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="aproveReservation.php?id=<?php echo $reservation['id_reservation'] ?>" class="text-green-600 hover:text-green-900">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="denyResrvation.php?id=<?php echo $reservation['id_reservation'] ?>" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            
            </div>
        </div>
    </div>
</body>
</html>