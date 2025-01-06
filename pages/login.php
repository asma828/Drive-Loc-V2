<?php
session_start();
include '../includes/autoloader.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = new Database();
    $utilisateur = new Utilisateur($db);
    
    $resultat = $utilisateur->connexion($email, $password);
    
    if($resultat == "Connexion réussie") {
        // Redirection basée sur le rôle stocké dans la session
        if($_SESSION['role'] == 2) { 
            header("Location: admin.php");
        } else { 
            header("Location: home.php");
        }
        exit();
    } else {
        header("Location: login.php?error=" . urlencode($resultat));
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Connexion</title>
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

        .gradient-overlay {
            background: linear-gradient(45deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.4) 100%);
        }

        .form-input {
            @apply w-full bg-transparent border-b border-gray-300 py-3 px-2 focus:outline-none focus:border-gold transition-colors duration-300;
        }

        .btn-primary {
            @apply bg-black text-white px-8 py-3 hover:bg-gold transition-all duration-300;
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="min-h-screen bg-white">
    
  <!-- Navigation -->
  

     <nav class="fixed top-0 left-0 right-0 z-50 bg-black bg-opacity-90">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="home.php" class="text-2xl text-white font-light tracking-widest">
                    DRIVE & LOC
                </a>
                <!-- <a href="/" class="text-white hover:text-gold transition-colors duration-300">
                    <i class="fas fa-times text-xl"></i> -->
                </a>
            </div>
        </div>
    </nav> 

    <!-- Split Screen Layout -->
    <div class="flex min-h-screen">
        <!-- Left Side - Image -->
        <div class="hidden lg:block w-1/2 relative">
            <img src="../assets/images/car.jpg" alt="Luxury Car" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 gradient-overlay"></div>
            <div class="absolute bottom-0 left-0 p-16 text-white">
                <h2 class="heading-font text-5xl mb-4">L'Excellence<br>Automobile</h2>
                <p class="text-xl font-light max-w-md">Accédez à notre collection exclusive de véhicules de prestige.</p>
            </div>
        </div>

        <!-- Right Side - Auth Forms -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-16">
            <div class="w-full max-w-md animate-fade-in">
                <!-- Login Form -->
                <div id="loginForm" class="space-y-8">
                    <div class="text-center mb-12">
                        <h1 class="heading-font text-4xl mb-4">Connexion</h1>
                        <p class="text-gray-600">Accédez à votre espace personnel</p>
                    </div>

                    <form class="space-y-6" id="loginForm" action="" method="POST">
                        <div>
                            <input type="email" name="email" placeholder="Email" class="form-input">
                        </div>
                        <div>
                            <input type="password" name="password" placeholder="Mot de passe" class="form-input">
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-2">
                                <span class="text-gray-600">Se souvenir de moi</span>
                            </label>
                            <a href="#" class="text-gray-600 hover:text-black">Mot de passe oublié ?</a>
                        </div>
                        <button type="submit" class="btn-primary w-full">SE CONNECTER</button>
                    </form>

                    <div class="text-center">
                        <p class="text-gray-600">
                            Pas encore membre ?
                            <a href="register.php" class="text-black hover:text-gold">Créer un compte</a>
                        </p>
                    </div>
                </div>

                <!-- Register Form (Initially Hidden) -->
                <div id="registerForm" class="space-y-8 hidden">
                    <div class="text-center mb-12">
                        <h1 class="heading-font text-4xl mb-4">Créer un compte</h1>
                        <p class="text-gray-600">Rejoignez l'expérience Drive & Loc</p>
                    </div>

                    <form class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <input type="text" placeholder="Prénom" class="form-input">
                            </div>
                            <div>
                                <input type="text" placeholder="Nom" class="form-input">
                            </div>
                        </div>
                        <div>
                            <input type="email" placeholder="Email" class="form-input">
                        </div>
                        <div>
                            <input type="tel" placeholder="Téléphone" class="form-input">
                        </div>
                        <div>
                            <input type="password" placeholder="Mot de passe" class="form-input">
                        </div>
                        <div>
                            <input type="password" placeholder="Confirmer le mot de passe" class="form-input">
                        </div>
                        <div class="flex items-start space-x-2 text-sm">
                            <input type="checkbox" class="mt-1">
                            <span class="text-gray-600">
                                J'accepte les <a href="#" class="text-black hover:text-gold">conditions générales</a> et la
                                <a href="#" class="text-black hover:text-gold">politique de confidentialité</a>
                            </span>
                        </div>
                        <button type="submit" class="btn-primary w-full">CRÉER MON COMPTE</button>
                    </form>

                    <div class="text-center">
                        <p class="text-gray-600">
                            Déjà membre ?
                            <a href="login.php" class="text-black hover:text-gold">Se connecter</a>
                        </p>
                    </div>
                </div>

                <!-- Social Login -->
                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-600">Ou continuer avec</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <button class="flex items-center justify-center px-4 py-3 border border-gray-300 hover:border-black transition-colors duration-300">
                            <i class="fab fa-google mr-2"></i>
                            Google
                        </button>
                        <button class="flex items-center justify-center px-4 py-3 border border-gray-300 hover:border-black transition-colors duration-300">
                            <i class="fab fa-apple mr-2"></i>
                            Apple
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>