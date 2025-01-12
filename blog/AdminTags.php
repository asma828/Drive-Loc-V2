<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['role'] != 2) {
    header('Location: home.php');
    exit();
}
include '../includes/autoloader.php';

$database = new Database();
$db = $database->getConnection();

$tags= new Tag($db);
$afficheTag=$tags->getAllTags();



if(isset($_POST['submit'])) {
    $names = $_POST['tags_name'];
    var_dump($_POST);
    $success = true;
    
    for($i = 0; $i < count($names); $i++) {
        if(!$tags->addTag($names[$i])) {
            $success = false;
            break;
        }
    }
    
    if($success) {
        header('Location: AdminTags.php?msg=success');
        exit();
    } else {
        header('Location: AdminTags.php?msg=error');
        exit();
    }
}

// Show message if exists
if(isset($_GET['msg'])) {
    $message = $_GET['msg'] === 'success' ? 'Vehicles added successfully!' : 'Error adding vehicles!';
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="fixed w-64 h-full bg-black text-white p-6">
        <div class="mb-8">
            <h1 class="text-2xl font-light tracking-widest">DRIVE & LOC</h1>
            <p class="text-sm text-gray-400">Administration</p>
        </div>
        
        <nav class="space-y-2">
            <a href="../pages/admin.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800">
                <i class="fas fa-chart-bar"></i>
                <span>Dashboard</span>
            </a>
            <a href="../pages/AdminVehicles.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800">
                <i class="fas fa-car"></i>
                <span>Véhicules</span>
            </a>
            <a href="../pages/Adminreservation.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800">
                <i class="fas fa-calendar"></i>
                <span>Réservations</span>
            </a>
            <a href="../pages/AdminReviews.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800">
                <i class="fas fa-star"></i>
                <span>Avis</span>
            </a>
            <a href="dash.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800">
                <i class="fas fa-star"></i>
                <span>Blog</span>
            </a>
            <a href="AdminArticle.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800">
            <i class="fas fa-newspaper w-5"></i>
                <span>Article</span>
            </a>
            <a href="AdminComment.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800">
            <i class="fas fa-comments w-5"></i>
                <span>Commentaires</span>
            </a>
            <a href="AdminTags.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg bg-white text-black">
            <i class="fas fa-tags w-5"></i>
                <span>Tags</span>
            </a>
        </nav>
    </div>

    <div class="flex">
        <!-- Main Content -->
        <div class="ml-64 flex-1 p-8">
            <div class="flex justify-between items-center mb-6">    
    </div>
          
                <h2 class="text-3xl font-light">Gestion des Tags</h2>
                

            <!-- form pour ajouter les tags -->
            <form action="AdminTags.php" method="POST" class="flex flex-col gap-4">
            <div class="flex-1">
                <label for="category_name" class="block mb-2 text-sm font-medium text-gray-700">
                    Tag Name
                </label>
                <div id="inputs" class="space-y-3">
                    <input 
                        type="text" 
                        name="tags_name[]" 
                        class="w-full rounded-lg border border-gray-300 p-2.5 text-gray-700 focus:ring-1 focus:ring-primary focus:border-primary outline-none"
                        placeholder="Enter tag name"
                        autocomplete="off"
                    />
                </div>
            </div>

            <div class="flex justify-between items-center">
            <div class="flex gap-6 text-primary text-3xl">
                    <button 
                        type="button"
                        onclick="addInput()"
                    >
                        <i class="fas fa-plus"></i>
                    </button>
                    <button 
                        type="button"
                        onclick="removeInput()"
                    >
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
                <button 
                    type="submit"
                    name="submit"
                    class="w-full sm:w-auto px-6 py-2.5 bg-primary text-black font-medium rounded-lg hover:bg-primary/90 transition-colors"
                >
                    Save
                </button>
            </div>

</form>

        <!-- affichage des commentaires -->
         <?php foreach($afficheTag as $tag):?>
            <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-sm">tag</p>
                                <h3 class="text-3xl font-light mt-2"><?php echo $tag->getName();; ?></h3>
                            </div>
                            <a href="" class="bg-red-100 text-red-800 p-2 rounded">
                                <i class="fas fa-trash"></i>
                            </a>
                            
                        </div>
                        <div class="flex items-center mt-4">
                            <span class="text-red-500 text-sm">
                                <i class="fas fa-arrow-down"></i> 3%
                            </span>
                            <span class="text-gray-400 text-sm ml-2">vs dernier mois</span>
                        </div>
                    </div>
                    <?php endforeach ?>
                
                
    <script>
    let inputsContainer = document.getElementById('inputs');
    let inputCopy = inputsContainer.firstElementChild.cloneNode(true);
    let count = 1;

    function addInput() {
        inputsContainer.appendChild(inputCopy.cloneNode(true));
        count++;
    }

    function removeInput(){
        if (count > 1) {
            inputsContainer.removeChild(inputsContainer.lastElementChild);
            count--;
        }
    }
    </script>
</body>
</html>