<?php
include '../includes/autoloader.php';

$database = new Database();
$conn = $database->getConnection();

$article=new Article($conn,'','','','',0,0);
$counts=$article->CountArticle();

$pending=$article->PendingArticle();
$approuve=$article->AprouveArticle();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Admin Dashboard</title>
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
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-black text-white">
            <div class="p-6">
                <h2 class="text-xl font-light tracking-widest">DRIVE & LOC</h2>
            </div>
            <nav class="mt-6">
                <a href="#" class="flex items-center px-6 py-3 bg-gray-900">
                    <i class="fas fa-chart-line w-5"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 hover:bg-gray-900">
                    <i class="fas fa-newspaper w-5"></i>
                    <span class="ml-3">Articles</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 hover:bg-gray-900">
                    <i class="fas fa-folder w-5"></i>
                    <span class="ml-3">Thèmes</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 hover:bg-gray-900">
                    <i class="fas fa-tags w-5"></i>
                    <span class="ml-3">Tags</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 hover:bg-gray-900">
                    <i class="fas fa-comments w-5"></i>
                    <span class="ml-3">Commentaires</span>
                </a>

</nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            <div class="bg-white shadow-sm">
                <div class="flex justify-between items-center px-8 py-4">
                    <h1 class="heading-font text-2xl">Dashboard Blog</h1>
                    <div class="flex items-center space-x-4">
                        <button class="relative">
                            <i class="fas fa-bell text-gray-600"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-4 h-4 rounded-full flex items-center justify-center">3</span>
                        </button>
                        <img src="/api/placeholder/32/32" alt="Admin" class="w-8 h-8 rounded-full">
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="p-8">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Articles -->
                     <?php foreach($counts as $count):?>
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-sm">Total Articles</p>
                                <h3 class="text-3xl font-light mt-2"><?php echo $count['total']; ?></h3>
                            </div>
                            <span class="bg-blue-100 text-blue-800 p-2 rounded">
                                <i class="fas fa-newspaper"></i>
                            </span>
                        </div>
                        <div class="flex items-center mt-4">
                            <span class="text-green-500 text-sm">
                                <i class="fas fa-arrow-up"></i> 12%
                            </span>
                            <span class="text-gray-400 text-sm ml-2">vs dernier mois</span>
                        </div>
                        <?php endforeach ?>
                    </div>

                    <!-- Pending Articles -->
                     <?php foreach ($pending as $pendarticle):?>
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-sm">Articles en Attente</p>
                                <h3 class="text-3xl font-light mt-2"><?php echo $pendarticle['total']?></h3>
                            </div>
                            <span class="bg-yellow-100 text-yellow-800 p-2 rounded">
                                <i class="fas fa-clock"></i>
                            </span>
                        </div>
                        <div class="flex items-center mt-4">
                            <span class="text-gray-400 text-sm">À approuver</span>
                        </div>
                    </div>
                <?php endforeach ?>
                    <!-- Total Comments -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-sm">Commentaires</p>
                                <h3 class="text-3xl font-light mt-2">1,284</h3>
                            </div>
                            <span class="bg-purple-100 text-purple-800 p-2 rounded">
                                <i class="fas fa-comments"></i>
                            </span>
                        </div>
                        <div class="flex items-center mt-4">
                            <span class="text-red-500 text-sm">
                                <i class="fas fa-arrow-down"></i> 3%
                            </span>
                            <span class="text-gray-400 text-sm ml-2">vs dernier mois</span>
                        </div>
                    </div>

                    <!-- Articles approuver -->
                     <?php foreach ($approuve as $app):?>
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 text-sm">Articles Approuver</p>
                                <h3 class="text-3xl font-light mt-2"><?php echo $app['total']?></h3>
                            </div>
                            <span class="bg-green-100 text-green-800 p-2 rounded">
                                <i class="fas fa-users"></i>
                            </span>
                        </div>
                        <div class="flex items-center mt-4">
                            <span class="text-green-500 text-sm">
                                <i class="fas fa-arrow-up"></i> 8%
                            </span>
                            <span class="text-gray-400 text-sm ml-2">vs dernier mois</span>
                        </div>
                    </div>
                </div>
<?php endforeach ?>
                <!-- Recent Articles Table -->
                <div class="bg-white rounded-lg shadow-sm mb-8">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl font-medium">Articles Récents</h2>
                            <button class="text-sm text-gray-500 hover:text-black">Voir tout</button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left bg-gray-50">
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Titre</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Auteur</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Thème</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <img src="/api/placeholder/40/40" alt="Article" class="w-10 h-10 rounded object-cover mr-3">
                                            <span>L'Evolution de la Supercar Moderne</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">Jean Dupont</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded text-sm">Supercar</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded text-sm">Publié</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-3">
                                            <button class="text-gray-400 hover:text-blue-600">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="text-gray-400 hover:text-red-600">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- More rows... -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Comments -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl font-medium">Derniers Commentaires</h2>
                            <button class="text-sm text-gray-500 hover:text-black">Voir tout</button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Comment -->
                            <div class="flex items-start space-x-4">
                                <img src="/api/placeholder/40/40" alt="User" class="w-10 h-10 rounded-full">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-medium">Marie Laurent</h4>
                                        <span class="text-sm text-gray-500">Il y a 2h</span>
                                    </div>
                                    <p class="text-gray-600 text-sm mt-1">Excellent article qui explique parfaitement l'évolution des supercars...</p>
                                    <div class="flex items-center space-x-4 mt-2">
                                        <button class="text-sm text-gray-500 hover:text-green-600">Approuver</button>
                                        <button class="text-sm text-gray-500 hover:text-red-600">Supprimer</button>
                                        <a href="#" class="text-sm text-gray-500 hover:text-blue-600">Voir l'article</a>
                                    </div>
                                </div>
                            </div>
                            <!-- More comments... -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>