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
$nomberofreservation=$reservationObj->numbreofreservation();

$vechiculeObj= new Vehicle($db);
$nomberofVechicule=$vechiculeObj->numbreofVechicule();

$utilisateurObj= new Utilisateur($database);
$numberofclient=$utilisateurObj->numbreofclient();

$reviewsObj= new Review($db);
$numberofreviews=$reviewsObj->numberofreviews();
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
            <a href="admin.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg bg-white text-black">
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
            <a href="AdminReviews.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800">
                <i class="fas fa-star"></i>
                <span>Avis</span>
            </a>
            
        </nav>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-light">Dashboard</h2>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <i class="fas fa-bell text-gray-600"></i>
                    <div class="absolute top-0 -right-1 w-2 h-2 bg-red-500 rounded-full"></div>
                </div>
                <img src="../assets/images/admin.jpg" alt="Admin" class="w-10 h-10 rounded-full">
            </div>
            <div class="flex items-center space-x-8">
                    <a href="logout.php" class="text-sm bg-white text-black px-6 py-2 hover:bg-gold transition-colors duration-300">LOGOUT</a>
                </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Vehicles -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-car text-gray-600"></i>
                    <span class="text-sm text-green-500">+12%</span>
                </div>
                <h3 class="text-3xl font-light mb-1"><?= htmlspecialchars($nomberofVechicule['total']) ?></h3>
                <p class="text-sm text-gray-600">Total Véhicules</p>
            </div>
            <!-- Active Reservations -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-calendar text-gray-600"></i>
                    <span class="text-sm text-green-500">+18%</span>
                </div>
                <h3 class="text-3xl font-light mb-1"><?= htmlspecialchars($nomberofreservation['total']) ?></h3>
                <p class="text-sm text-gray-600">Réservations Actives</p>
            </div>
            <!-- New Clients -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-users text-gray-600"></i>
                    <span class="text-sm text-green-500">+25%</span>
                </div>
                <h3 class="text-3xl font-light mb-1"><?= htmlspecialchars($numberofclient['total']) ?></h3>
                <p class="text-sm text-gray-600">Nouveaux Clients</p>
            </div>
            <!-- Average Rating -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-star text-gray-600"></i>
                    <span class="text-sm text-green-500">+0.3</span>
                </div>
                <h3 class="text-3xl font-light mb-1"><?= htmlspecialchars($numberofreviews['total']) ?></h3>
                <p class="text-sm text-gray-600">Client avis</p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Revenue Chart -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-xl font-light">Revenus Mensuels</h3>
                </div>
                <div class="p-6">
                    <div class="h-64 flex items-center justify-center text-gray-400">
                        <img src="/api/placeholder/400/200" alt="Revenue Chart">
                    </div>
                </div>
            </div>

            <!-- Popular Vehicles -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-xl font-light">Véhicules Populaires</h3>
                </div>
                <div class="p-6">
                    <div class="h-64 flex items-center justify-center text-gray-400">
                        <img src="/api/placeholder/400/200" alt="Vehicles Chart">
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-light">Activité Récente</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <!-- Activity Item -->
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-calendar text-gray-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">Nouvelle réservation</p>
                                <p class="text-sm text-gray-600">Porsche 911 GT3 - 3 jours</p>
                            </div>
                        </div>
                        <span class="text-sm text-gray-600">Il y a 2 heures</span>
                    </div>
                    <!-- Repeat for more activity items -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>