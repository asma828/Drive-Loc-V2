<?php
include '../includes/autoloader.php';

$db= new Database();
$conn=$db->getConnection();
$themes=new Theme($conn);

$afficeThemes=$themes->getAllThemes();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Thèmes du Blog</title>
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
    <!-- Navigation (Same as previous) -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-black">
        <div class="container mx-auto px-8 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-16">
                    <a href="/" class="text-2xl font-light tracking-widest text-white">
                        DRIVE & LOC
                    </a>
                    <div class="hidden md:flex space-x-8">
                        <a href="vehicles.php" class="text-sm tracking-wider text-white hover:text-gold">VÉHICULES</a>
                        <a href="blog.php" class="text-sm tracking-wider text-white hover:text-gold">BLOG</a>
                        <a href="themes.php" class="text-sm tracking-wider text-white hover:text-gold">THÈMES</a>
                    </div>
                </div>
                <div class="flex items-center space-x-8">
                    <a href="create-article.php" class="text-sm bg-white text-black px-6 py-2 hover:bg-gold transition-colors duration-300">CRÉER UN ARTICLE</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Theme Categories -->
    <section class="pt-32 pb-16">
        <div class="container mx-auto px-8">
            <h1 class="heading-font text-5xl mb-12 text-center">Explorez Nos Thèmes</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Theme Card -->
<?php foreach($afficeThemes as $theme):?>
    <a href="articles.php?id_theme=<?php echo $theme['id_theme']; ?>" class="relative group cursor-pointer">
                <div class="relative group cursor-pointer">
                    <img src="<?php echo $theme['image'] ?>" alt="Supercars" class="w-full h-80 object-cover rounded-lg">
                    <div class="absolute inset-0 bg-black bg-opacity-50 group-hover:bg-opacity-70 transition-all duration-300 rounded-lg flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="heading-font text-3xl mb-2"><?php echo $theme['name']; ?></h3>
                            <p class="text-gray-300">15 articles</p>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>
</body>
</html>