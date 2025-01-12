<?php
session_start();
// if (!isset($_SESSION['id_user'])) {
//     header('Location: ../pages/login.php');
//     exit();
// }
include '../includes/autoloader.php';
var_dump($_SESSION);
var_dump($_POST);
$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {    
        $title = $_POST['title'];
        $content = $_POST['content'];
        $id_theme = $_POST['theme'];
        $id_user = $_SESSION['id_user'];
        
        // image upload
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../assets/images/';
            $imageName = basename($_FILES['image']['name']);
            $image = $uploadDir . $imageName;
            
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        }
        

        $article = new Article($conn);
        $article->CreateArticle($conn, $title, $content, $image, $id_theme, $id_user, $_POST['tags']);        
        header('Location: blog.php?success=1');
        exit();
        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

$themes=new Theme($conn);

$afficeThemes=$themes->getAllThemes();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Créer un Article</title>
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

    <!-- Article Form -->
    <section class="pt-32 pb-16">
        <div class="container mx-auto px-8 max-w-4xl">
            <h1 class="heading-font text-4xl mb-12">Créer un Article</h1>
            
            <form action="create-article.php" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg">
                <!-- Title -->
                <div class="mb-8">
                    <label class="block text-sm font-medium mb-2">Titre</label>
                    <input type="text" name="title" class="w-full border p-3 focus:outline-none focus:border-black" placeholder="Titre de l'article">
                </div>

                <!-- Theme Selection -->
                <div class="mb-8">
                    <label class="block text-sm font-medium mb-2">Thème</label>
                    <select name="theme" class="w-full border p-3 focus:outline-none focus:border-black">
                        <option>Sélectionnez un thème</option>
                        <?php foreach ($afficeThemes as $theme): ?>
                          <option value="<?php echo $theme['id_theme']; ?>">
                    <?php echo $theme['name']; ?>
                        </option>
               <?php endforeach; ?>
                    </select>
                </div>

                <!-- Image Upload -->
                <div class="mb-8">
                   <label class="block text-sm font-medium mb-2">Image principale</label>
                   <div class="border-2 border-dashed border-gray-300 p-8 text-center relative">
                <input type="file" name="image" id="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
        <div class="pointer-events-none">
                  <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                  <p class="text-gray-500">Glissez votre image ici ou cliquez pour parcourir</p>
        </div>
    </div>
</div>

                <!-- Content -->
                <div class="mb-8">
                    <label class="block text-sm font-medium mb-2">Contenu</label>
                    <textarea name="content" class="w-full border p-3 focus:outline-none focus:border-black" rows="12" placeholder="Contenu de l'article..."></textarea>
                </div>

                <!-- Tags -->
                <div class="mb-8">
    <label class="block text-sm font-medium mb-2">Tags</label>
    <select name="tags[]" multiple class="w-full border p-3 focus:outline-none focus:border-black">
        <?php
        $query = "SELECT * FROM tags";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($tags as $tag): ?>
            <option value="<?php echo $tag['id_tag']; ?>">
                <?php echo $tag['name']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <p class="text-sm text-gray-500 mt-1">Maintenez Ctrl (Cmd sur Mac) pour sélectionner plusieurs tags</p>
</div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-4">
                    <button type="submit" class="px-6 py-3 bg-black text-white hover:bg-gold transition-colors duration-300">Publier l'article</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>