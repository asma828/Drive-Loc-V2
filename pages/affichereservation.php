<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

include '../includes/autoloader.php';


$database = new Database();
$db = $database->getConnection();

$reservation = new Reservation($db);
$review = new Review($db);

// Get user's reservations
$userReservations = $reservation->getReservationsByUser($_SESSION['id_user']);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Drive & Loc</title>
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

      <!-- Header -->
      <header class="bg-black text-white py-20">
        <div class="container mx-auto px-8">
            <h1 class="heading-font text-5xl mb-6">Votre reservation</h1>
            <p class="text-xl font-light max-w-2xl">Vous pouvez decouvrir et gerer votre reservation ici</p>
        </div>
    </header>
    
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Mes Réservations</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($userReservations as $reservation): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="<?php echo htmlspecialchars($reservation['image']); ?>" 
                         alt="<?php echo htmlspecialchars($reservation['vehicle_name']); ?>"
                         class="w-full h-48 object-cover">
                    
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-2">
                            <?php echo htmlspecialchars($reservation['vehicle_name'] . ' ' . $reservation['model']); ?>
                        </h2>
                        
                        <div class="mb-4">
                            <p class="text-gray-600">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                Du <?php echo date('d/m/Y', strtotime($reservation['start_date'])); ?>
                                au <?php echo date('d/m/Y', strtotime($reservation['end_date'])); ?>
                            </p>
                            <p class="text-gray-600">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <?php echo htmlspecialchars($reservation['pickup_location']); ?>
                            </p>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div class="space-x-2">
                                <a href="edit_reservation.php?id=<?php echo $reservation['id_reservation']; ?>" 
                                   class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    Modifier
                                </a>
                                <a href="DeleteReservation.php?id=<?php echo $reservation['id_reservation']; ?>)"
                                class="inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                    Annuler
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

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