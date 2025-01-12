<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Article</title>
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
<body class="bg-white">
    <!-- Navigation -->

    <!-- Article Content -->
    <article class="pt-32 pb-16">
        <div class="container mx-auto px-8 max-w-4xl">
            <!-- Article Header -->
            <div class="mb-12 text-center">
                <div class="flex items-center justify-center space-x-4 mb-6">
                    <span class="bg-black text-white px-4 py-1 text-sm">SUPERCAR</span>
                    <span class="text-gray-500 text-sm">12 Jan 2024</span>
                </div>
                <h1 class="heading-font text-5xl mb-6">L'Evolution de la Supercar Moderne</h1>
                <div class="flex items-center justify-center space-x-4">
                    <img src="/api/placeholder/48/48" alt="Author" class="w-12 h-12 rounded-full">
                    <div class="text-left">
                        <p class="font-medium">Jean Dupont</p>
                        <p class="text-gray-500 text-sm">Expert Automobile</p>
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            <img src="/api/placeholder/1200/600" alt="Article Featured Image" class="w-full h-[600px] object-cover mb-12">

            <!-- Article Body -->
            <div class="prose max-w-none">
                <p class="text-lg leading-relaxed mb-6">Lorem ipsum dolor sit amet...</p>
                <!-- More content -->
            </div>

            <!-- Tags -->
            <div class="flex flex-wrap gap-3 my-12">
                <span class="px-4 py-2 bg-gray-100 text-sm">#Supercar</span>
                <span class="px-4 py-2 bg-gray-100 text-sm">#Luxury</span>
                <span class="px-4 py-2 bg-gray-100 text-sm">#Performance</span>
            </div>

            <!-- Comments Section -->
            <section class="mt-16">
                <h3 class="heading-font text-2xl mb-8">Commentaires (5)</h3>
                
                <!-- Comment Form -->
                <form class="mb-12">
                    <textarea class="w-full border p-4 mb-4 focus:outline-none focus:border-black" rows="4" placeholder="Votre commentaire..."></textarea>
                    <button class="bg-black text-white px-8 py-3 hover:bg-gold transition-colors duration-300">Publier</button>
                </form>

                <!-- Comments List -->
                <div class="space-y-8">
                    <!-- Comment -->
                    <div class="border-b pb-8">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <img src="/api/placeholder/40/40" alt="Commenter" class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-medium">Marie Laurent</p>
                                    <p class="text-gray-500 text-sm">10 Jan 2024</p>
                                </div>
                            </div>
                            <div class="flex space-x-4 text-sm">
                                <button class="text-gray-500 hover:text-black">Modifier</button>
                                <button class="text-gray-500 hover:text-black">Supprimer</button>
                            </div>
                        </div>
                        <p class="text-gray-700">Excellent article qui explique parfaitement l'évolution des supercars.</p>
                    </div>
                    <!-- Repeat for more comments -->
                </div>
            </section>
        </div>
    </article>
</body>
</html>