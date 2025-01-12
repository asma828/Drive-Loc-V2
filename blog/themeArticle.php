<?php
include '../includes/autoloader.php';

if (isset($_GET['id_theme'])) {
    $id_theme = $_GET['id_theme'];
    
    $db = new Database();
    $conn = $db->getConnection();
    
    $themes = new Theme($conn);
    $theme = $themes->getThemeById($id_theme);
    $articles = $themes->getArticleByTheme($id_theme);
    
    $comment = new Comment($conn);
} else {
    header("Location: themes.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles - <?php echo htmlspecialchars($theme['name']); ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@200;300;400;500;600&display=swap');
        
        body { font-family: 'Montserrat', sans-serif; }
        .heading-font { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    
    <!-- Articles Grid -->
    <section class="pt-32 pb-16">
        <div class="container mx-auto px-8">
            <h1 class="heading-font text-5xl mb-12 text-center"><?php echo htmlspecialchars($theme['name']); ?></h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach($articles as $article): ?>
                <article class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="bg-black text-white px-4 py-1 text-sm"><?php echo htmlspecialchars($theme['name']); ?></span>
                            <span class="text-gray-500 text-sm"><?php echo $article['created_at']; ?></span>
                        </div>
                        
                        <h3 class="heading-font text-2xl mb-4"><?php echo htmlspecialchars($article['title']); ?></h3>
                        <p class="text-gray-600 mb-4"><?php echo substr(htmlspecialchars($article['content']), 0, 150); ?>...</p>
                        
                        <!-- Comments Section -->
                        <?php $comments = $comment->getArticleComments($article['id_article']); ?>
                        <div class="mt-4 pt-4 border-t">
                            <h4 class="font-semibold mb-2">Comments (<?php echo count($comments); ?>)</h4>
                            
                            <?php if(isset($_SESSION['id_user'])): ?>
                            <form action="add_comment.php" method="POST" class="mb-4">
                                <input type="hidden" name="article_id" value="<?php echo $article['id_article']; ?>">
                                <textarea name="content" class="w-full p-2 border rounded" rows="2" placeholder="Add a comment..."></textarea>
                                <button type="submit" class="mt-2 px-4 py-2 bg-black text-white rounded text-sm">Comment</button>
                            </form>
                            <?php endif; ?>

                            <?php foreach(array_slice($comments, 0, 2) as $cmt): ?>
                            <div class="mb-2 p-2 bg-gray-50 rounded">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="font-medium"><?php echo htmlspecialchars($cmt['username']); ?></span>
                                    <span class="text-gray-500"><?php echo $cmt['created_at']; ?></span>
                                </div>
                                <p class="text-sm mt-1"><?php echo htmlspecialchars($cmt['content']); ?></p>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</body>
</html>
