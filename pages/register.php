<?php
include '../includes/autoloader.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = new Database();
    $utilisateur = new Utilisateur($db);
    $resultat = $utilisateur->signup($nom, $email, $password);

    if($resultat == "Inscription réussie") {
        header("Location: login.php?success=1");
    } else {
        header("Location: register.php?error=" . urlencode($resultat));
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Inscription</title>
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
                <h2 class="heading-font text-5xl mb-4">Rejoignez<br>l'Excellence</h2>
                <p class="text-xl font-light max-w-md">Créez votre compte pour accéder à notre collection exclusive de véhicules de prestige.</p>
            </div>
        </div>

        <!-- Right Side - Registration Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-16">
            <div class="w-full max-w-md animate-fade-in">
                <div class="text-center mb-12">
                    <h1 class="heading-font text-4xl mb-4">Créer votre compte</h1>
                    <p class="text-gray-600">Accédez à l'expérience Drive & Loc</p>
                </div>

                <form class="space-y-6" id="signupForm" action="" method="POST">
                    <!-- Personal Information -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-light">Informations Personnelles</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <input type="text" name="nom" placeholder="Nom" class="form-input" required>
                            </div>
                            
                        </div>
                        <div>
                            <input type="email" name="email" placeholder="Email" class="form-input" required>
                        </div>
                       
                    </div>


                    <!-- Account Security -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-light">Sécurité du Compte</h3>
                        <div>
                            <input type="password" name="password" placeholder="Mot de passe" class="form-input" required>
                        </div>
                        <!-- <div>
                            <input type="password" placeholder="Confirmer le mot de passe" class="form-input" required>
                        </div> -->
                    </div>

                    <button type="submit" class="btn-primary w-full">CRÉER MON COMPTE</button>
                </form>

                <div class="text-center mt-8">
                    <p class="text-gray-600">
                        Déjà membre ?
                        <a href="login.php" class="text-black hover:text-gold">Se connecter</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>