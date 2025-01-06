<?php

session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}
if ($_SESSION['role'] == 2) {

    header('Location: admin.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Luxury Car Experience</title>
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
        
        .diagonal-slice {
            clip-path: polygon(0 0, 100% 0, 85% 100%, 0% 100%);
        }
        
        .hover-scale {
            transition: transform 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.02);
        }

        .gradient-overlay {
            background: linear-gradient(45deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.4) 100%);
        }

        .text-stroke {
            -webkit-text-stroke: 1px #ffffff;
            color: transparent;
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body class="bg-black text-white min-h-screen">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-b from-black to-transparent">
        <div class="container mx-auto px-8 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-16">
                    <a href="/" class="text-2xl font-light tracking-widest">
                        DRIVE & LOC
                    </a>
                    <div class="hidden md:flex space-x-8">
                        <a href="vehicles.php" class="text-sm tracking-wider hover:text-gold transition-colors duration-300">VÉHICULES</a>
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

    <!-- Hero Section -->
    <section class="h-screen relative overflow-hidden">
        <!-- Background Video/Image -->
        <div class="absolute inset-0">
            <img src="../assets/images/car.jpg" alt="Luxury Car" class="w-full h-full object-cover">
            <div class="absolute inset-0 gradient-overlay"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative h-full container mx-auto px-8 flex items-center">
            <div class="w-full md:w-2/3 animate-slide-up">
                <h1 class="heading-font text-7xl md:text-9xl mb-6">
                    Excellence
                    <span class="text-stroke block">Automobile</span>
                </h1>
                <p class="text-xl md:text-2xl font-light mb-12 max-w-2xl">
                    Découvrez notre collection exclusive de véhicules de prestige pour une expérience de conduite incomparable.
                </p>
                <div class="flex space-x-6">
                    <a href="vehicles.php" class="bg-white text-black px-8 py-4 hover:bg-gold transition-colors duration-300">
                        DÉCOUVRIR LA FLOTTE
                    </a>
                    <a href="reservation.php" class="border border-white px-8 py-4 hover:bg-white hover:text-black transition-colors duration-300">
                        RÉSERVER MAINTENANT
                    </a>
                </div>
            </div>
        </div>

                <!-- Featured Car Card -->
                <div class="hover-scale cursor-pointer">
                    <img src="../assets/images/car.jpg" alt="Featured Car" class="w-full h-48 object-cover mb-4">
                    <h4 class="text-lg font-light mb-2">Porsche 911 GT3</h4>
                    <p class="text-sm text-gray-400">À partir de 1200€/jour</p>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Luxury Experience Section -->
    <section class="py-24 bg-white text-black">
        <div class="container mx-auto px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="heading-font text-5xl mb-8">L'Excellence au Service de Votre Expérience</h2>
                    <p class="text-lg text-gray-600 mb-8">
                        Chaque voyage mérite d'être extraordinaire. Notre collection de véhicules de prestige est méticuleusement entretenue pour vous offrir une expérience de conduite incomparable.
                    </p>
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <div class="text-3xl font-light mb-2">50+</div>
                            <div class="text-sm text-gray-600">Véhicules de Luxe</div>
                        </div>
                        <div>
                            <div class="text-3xl font-light mb-2">24/7</div>
                            <div class="text-sm text-gray-600">Service Conciergerie</div>
                        </div>
                        <div>
                            <div class="text-3xl font-light mb-2">100%</div>
                            <div class="text-sm text-gray-600">Satisfaction Client</div>
                        </div>
                        <div>
                            <div class="text-3xl font-light mb-2">5★</div>
                            <div class="text-sm text-gray-600">Note Moyenne</div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <img src="../assets/images/car.jpg" alt="Luxury Experience" class="w-full h-auto">
                    <div class="absolute -bottom-8 -left-8 bg-black text-white p-8 max-w-sm">
                        <blockquote class="text-lg italic mb-4">
                            "Une expérience de location exceptionnelle, au-delà de toutes mes attentes."
                        </blockquote>
                        <cite class="text-sm">- Jean Dupont, Client Premium</cite>
                    </div>
                </div>
            </div>
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