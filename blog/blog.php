<?php 
include '../includes/autoloader.php';

$db= new Database();
$conn=$db->getConnection();



$search = isset($_GET['search']) ? $_GET['search'] : '';
$tagId = isset($_GET['tag']) ? $_GET['tag'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 5;

$article = new Article($conn);
$articles = $article->searchArticles($search, $tagId, $page, $perPage);

$tagManager = new Tag($conn);
$allTags = $tagManager->getAllTags();

$totalArticles = $article->getTotalArticles($search, $tagId);
$totalPages = ceil($totalArticles / $perPage);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Blog Automobile</title>
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
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-black">
        <div class="container mx-auto px-8 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-16">
                    <a href="/" class="text-2xl font-light tracking-widest text-white">
                        DRIVE & LOC
                    </a>
                    <div class="hidden md:flex space-x-8">
                        <a href="../pages/vehicles.php" class="text-sm tracking-wider text-white hover:text-gold">VÉHICULES</a>
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

 <!-- Featured Article Hero -->
 <section class="pt-24 pb-12">
        <div class="container mx-auto px-8">
            <div class="relative rounded-lg overflow-hidden">
                <img src="/api/placeholder/1200/600" alt="Featured Article" class="w-full h-[600px] object-cover">
                <div class="absolute inset-0 gradient-overlay"></div>
                <div class="absolute bottom-0 left-0 p-12 w-full">
                    <div class="flex items-center space-x-4 mb-4">
                        <span class="bg-gold text-black px-4 py-1 text-sm">ACTUALITÉS</span>
                        <span class="text-white text-sm">12 Jan 2024</span>
                    </div>
                    <h1 class="heading-font text-4xl md:text-6xl text-white mb-4">L'Evolution de la Supercar Moderne</h1>
                    <p class="text-gray-200 mb-6 max-w-2xl">Découvrez comment les supercars d'aujourd'hui redéfinissent les limites de la performance et du luxe automobile.</p>
                    <div class="flex items-center space-x-6">
                        <img src="/api/placeholder/40/40" alt="Author" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="text-white">Jean Dupont</p>
                            <p class="text-gray-400 text-sm">Expert Automobile</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Articles Grid -->
    <section class="py-12">
        <div class="container mx-auto px-8">
            <!-- Tags Filter -->
            <div class="mb-8">
    <!-- Search Form -->
    <form method="GET" class="mb-4">
        <div class="flex gap-4">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
                placeholder="Rechercher un article..." lass="flex-1 px-4 py-2 border rounded">
                   
            <select name="per_page" class="px-4 py-2 border rounded">
                <option value="5" <?= $perPage == 5 ? 'selected' : '' ?>>5 articles</option>
                <option value="10" <?= $perPage == 10 ? 'selected' : '' ?>>10 articles</option>
                <option value="15" <?= $perPage == 15 ? 'selected' : '' ?>>15 articles</option>
            </select>
            
            <button type="submit" class="px-6 py-2 bg-black text-white rounded">
                Rechercher
            </button>
        </div>
    </form>

    <!-- Tag Filters -->
    <div class="flex flex-wrap gap-2">
        <a href="blog.php" class="px-4 py-2 rounded <?= empty($tagId) ? 'bg-black text-white' : 'border border-black' ?>">
            Tous
        </a>
        <?php foreach($allTags as $tag): ?>
            <a href="?tag=<?= $tag['id_tag'] ?><?= $search ? '&search='.urlencode($search) : '' ?>&per_page=<?= $perPage ?>" 
               class="px-4 py-2 rounded <?= $tagId ===(int) $tag['id_tag'] ? 'bg-black text-white' : 'border border-black' ?>">
                <?= htmlspecialchars($tag['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>


            <!-- Articles -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Article Card -->
            <?php     foreach($articles as $article): ?>
                <article class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <img src="<?= htmlspecialchars($article['image']) ?>" alt="Article" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="bg-black text-white px-4 py-1 text-sm"><?= htmlspecialchars($article['theme']) ?></span>
                            <span class="text-gray-500 text-sm"><?= htmlspecialchars($article['created_at']) ?></span>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                <?php
                $query = "SELECT t.name FROM tags t 
                         JOIN articles_tags at ON t.id_tag = at.id_tag 
                         WHERE at.id_article = :article_id";
                $stmt = $conn->prepare($query);
                $stmt->execute([':article_id' => $article['id_article']]);
                $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach($tags as $tag): ?>
                    <span class="bg-gray-200 px-3 py-1 rounded-full text-sm"><?= htmlspecialchars($tag['name']) ?></span>
                <?php endforeach; ?>
            </div>
                        <h3 class="heading-font text-2xl mb-4"><?= htmlspecialchars($article['title']) ?></h3>
                        <p class="text-gray-600 mb-4"><?= htmlspecialchars($article['content']) ?></p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <img src="../assets/images/icon.jpg" alt="Author" class="w-8 h-8 rounded-full">
                                <span class="text-sm text-gray-500"><?= htmlspecialchars($article['name']) ?></span>
                            </div>
                            <button class="text-gold hover:text-black transition-colors duration-300">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </article>
                <?php endforeach ?>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center gap-2 mt-8">
               <?php for($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&tag=<?= $tagId ?>&per_page=<?= $perPage ?>" 
           class="px-4 py-2 border rounded <?= $page === $i ? 'bg-black text-white' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="bg-black text-white py-24">
        <div class="container mx-auto px-8 text-center">
            <h2 class="heading-font text-4xl mb-6">Restez Informé</h2>
            <p class="text-gray-400 mb-8 max-w-2xl mx-auto">Abonnez-vous à notre newsletter pour recevoir les derniers articles et actualités du monde automobile.</p>
            <form class="max-w-md mx-auto flex gap-4">
                <input type="email" placeholder="Votre email" class="flex-1 bg-transparent border border-white px-6 py-3 focus:outline-none focus:border-gold">
                <button class="bg-white text-black px-8 py-3 hover:bg-gold transition-colors duration-300">S'ABONNER</button>
            </form>
        </div>
    </section>

    
</body>
</html>