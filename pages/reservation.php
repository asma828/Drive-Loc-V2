<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

include '../includes/autoloader.php';

$database = new Database();
$db = $database->getConnection();

$reservationObj = new Reservation($db);
$vehicleObj = new Vehicle($db);

$vehicle_id = isset($_GET['vehicle']) ? $_GET['vehicle'] : die('Vehicle ID not specified');
$vehicle = $vehicleObj->getVehicleById($vehicle_id);
$places = $reservationObj->getAllPlaces();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'user_id' => $_SESSION['id_user'],
        'vehicle_id' => $vehicle_id,
        'place_id' => $_POST['place_id'],
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date']
    ];

    if ($reservationObj->createReservation($data)) {
        $success = true; 
    } else {
        $error = "Vehicle is not available for selected dates";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver - <?= htmlspecialchars($vehicle['name']) ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
<nav class="bg-black text-white">
        <div class="container mx-auto px-8 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-16">
                    <a href="home.php" class="text-2xl font-light tracking-widest">
                        DRIVE & LOC
                    </a>
                    <div class="hidden md:flex space-x-8">
                        <a href="vehicles.php" class="text-sm tracking-wider hover:text-gold transition-colors duration-300">VÉHICULES</a>
                        <a href="affichereservation.php" class="text-sm tracking-wider text-gold">RÉSERVER</a>
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
            <h1 class="heading-font text-5xl mb-6">Réservation</h1>
            <p class="text-xl font-light max-w-2xl">Complétez votre réservation en quelques étapes simples.</p>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold mb-6">Réserver <?= htmlspecialchars($vehicle['name']) ?></h1>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-gray-700 mb-2">Lieu de prise en charge</label>
                    <select name="place_id" required class="w-full border rounded-lg px-3 py-2">
                        <?php foreach ($places as $place): ?>
                            <option value="<?= $place['id_place'] ?>">
                                <?= htmlspecialchars($place['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-2">Date de début</label>
                        <input type="date" name="start_date" required 
                               min="<?= date('Y-m-d') ?>"
                               class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Date de fin</label>
                        <input type="date" name="end_date" required 
                               min="<?= date('Y-m-d') ?>"
                               class="w-full border rounded-lg px-3 py-2">
                    </div>
                </div>

                <button type="submit" class="w-full bg-black text-white py-3 rounded-lg hover:bg-opacity-90">
                    Confirmer la réservation
                </button>
            </form>
        </div>
    </div>

    <?php if (isset($success)): ?>
    <script>
        Swal.fire({
            title: 'Réservation Confirmée!',
            text: 'Votre véhicule a été réservé avec succès',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#000'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'vehicles.php';
            }
        });
    </script>
    <?php endif; ?>

    <?php if (isset($error)): ?>
    <script>
        Swal.fire({
            title: 'Erreur',
            text: '<?= $error ?>',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#000'
        });
    </script>
    <?php endif; ?>

<!-- Additional Information -->
<section class="container mx-auto px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <i class="fas fa-shield-alt text-4xl mb-4"></i>
                <h3 class="text-xl font-medium mb-2">Assurance All-Risk incluse</h3>
                <p class="text-gray-600">Profitez d'une couverture complète pendant toute la durée de votre location.</p>
            </div>
            <div class="text-center">
                <i class="fas fa-clock text-4xl mb-4"></i>
                <h3 class="text-xl font-medium mb-2">Assistance 24/7</h3>
                <p class="text-gray-600">Notre équipe est disponible à tout moment pour vous assister.</p>
            </div>
            <div class="text-center">
                <i class="fas fa-hand-holding-heart text-4xl mb-4"></i>
                <h3 class="text-xl font-medium mb-2">Service Conciergerie</h3>
                <p class="text-gray-600">Un service personnalisé pour une expérience sur mesure.</p>
            </div>
        </div>
    </section>

    <!-- Footer (same as previous pages) -->
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