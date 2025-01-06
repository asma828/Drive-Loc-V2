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

$vechiculeObj= new Vehicle($db);
$afficheVechicule=$vechiculeObj->afficheVechicule();

$categoryObj = new Category($db);
$categories = $categoryObj->getAllCategories();

if(isset($_POST['submit'])) {
    $names = $_POST['vehicle_name'];
    $models = $_POST['vehicle_model'];
    $prices = $_POST['vehicle_price'];
    $categories = $_POST['vehicle_category'];
    $images = $_POST['vehicle_image'];
    
    $success = true;
    
    for($i = 0; $i < count($names); $i++) {
        if(!$vechiculeObj->addVehicle(
            $names[$i], 
            $models[$i], 
            $prices[$i], 
            $categories[$i], 
            $images[$i]
        )) {
            $success = false;
            break;
        }
    }
    
    if($success) {
        header('Location: AdminVehicles.php?msg=success');
        exit();
    } else {
        header('Location: AdminVehicles.php?msg=error');
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
            <a href="admin.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800">
                <i class="fas fa-chart-bar"></i>
                <span>Dashboard</span>
            </a>
            <a href="AdminVehicles.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg bg-white text-black">
                <i class="fas fa-car"></i>
                <span>Véhicules</span>
            </a>
            <a href="Adminreservation.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800">
                <i class="fas fa-calendar"></i>
                <span>Réservations</span>
            </a>
            <a href="AdminReviews.php" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-gray-800">
                <i class="fas fa-star"></i>
                <span>Avis</span>
            </a>
        </nav>
    </div>

    <div class="flex">
        <!-- Main Content -->
        <div class="ml-64 flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
            <?php if(isset($message)): ?>
    <div class="bg-<?php echo $_GET['msg'] === 'success' ? 'green' : 'red'; ?>-100 border-l-4 border-<?php echo $_GET['msg'] === 'success' ? 'green' : 'red'; ?>-500 text-<?php echo $_GET['msg'] === 'success' ? 'green' : 'red'; ?>-700 p-4 mb-4" role="alert">
        <p><?php echo $message; ?></p>
    </div>
          <?php endif; ?>
                <h2 class="text-3xl font-light">Gestion des Véhicules</h2>
                <button id="addVehicle" class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-plus mr-2"></i>Ajouter en Masse
                </button>
            </div>

            <div class="fixed inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center hidden z-50" id="pop_add_vehicle">
        <div class="bg-white rounded-lg w-1/2 p-6 relative overflow-y-auto">
            <button id="ClosePopUp" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl font-bold">
                &times;
            </button>
            <h3 class="text-xl font-primary mb-4 text-center text-black">Add Vehicle</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <div id="inputs" class="space-y-5">
                    <div class="input-group">
                        <!-- Vehicle Name -->
                        <div class="flex flex-col">
                            <label for="name" class="text-black font-primary font-semibold">Vehicle Name</label>
                            <input type="text" id="name" name="vehicle_name[]" class="shadow-md p-2 rounded-md" required>
                        </div>

                        <!-- Vehicle Model -->
                        <div class="flex flex-col">
                            <label for="model" class="text-black font-primary font-semibold">Vehicle Model</label>
                            <input type="text" id="model" name="vehicle_model[]" class="shadow-md p-2 rounded-md" required>
                        </div>

                        <!-- Price -->
                        <div class="flex flex-col">
                            <label for="price" class="text-black font-primary font-semibold">Price</label>
                            <input type="number" step="0.01" id="price" name="vehicle_price[]" class="shadow-md p-2 rounded-md" required>
                        </div>

                        <!-- Category -->
                        <div class="flex flex-col">
                            <label for="category" class="text-black font-primary font-semibold">Category</label>
                            <select id="category" name="vehicle_category[]" class="shadow-md p-2 rounded-md" required>
                                <option value="">Select Category</option>
                                <?php foreach($categories as $category): ?>
                                 <option value="<?php echo htmlspecialchars($category['id_categorie']); ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                              <?php endforeach; ?>
                                
                            </select>
                        </div>

                        <!-- Vehicle Image -->
                        <div class="flex flex-col">
                            <label for="image" class="text-black font-primary font-semibold">Vehicle Image</label>
                            <input type="text" id="image" name="vehicle_image[]" class="shadow-md p-2 rounded-md" required>
                        </div>
                    </div>
                </div>
                <div class="flex gap-6 text-primary text-3xl mt-4">
                    <button class="text-black" type="button" onclick="addInput()">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button class="text-black" type="button" onclick="removeInput()">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>

                <!-- Submit Button -->
                <button id="submit" name="submit" class="bg-black text-white px-6 py-3 rounded-md mt-4 hover:bg-gold transition-colors duration-300">
                    Add Vehicle
                </button>
            </form>
        </div>
    </div>

            <!-- Filters -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <select class="border rounded-lg px-4 py-2">
                        <option>Catégorie</option>
                    </select>
                    <select class="border rounded-lg px-4 py-2">
                        <option>Disponibilité</option>
                    </select>
                    <input type="text" placeholder="Rechercher..." class="border rounded-lg px-4 py-2">
                    <button class="bg-gray-800 text-white rounded-lg px-4 py-2">Filtrer</button>
                </div>
            </div>

            <!-- Vehicles Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden overflow-y-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Véhicule</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Catégorie</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Prix/Jour</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                        <?php foreach($afficheVechicule as $vechicule): ?>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img src="<?= htmlspecialchars($vechicule['image']) ?>" class="h-10 w-10 rounded-lg mr-3">
                                    <div>
                                        <div class="font-medium"><?= htmlspecialchars($vechicule['car']) ?></div>
                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($vechicule['model']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4"><?= htmlspecialchars($vechicule['name']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($vechicule['prix']) ?>€</td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Disponible
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-3">
                                    <a href="updatereservation.php?id=<?php echo $vechicule['id_vechicule'] ?>" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="deleteVehicule.php?id=<?php echo $vechicule['id_vechicule'] ?>" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                            <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">20</span> results
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Previous</span>
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        1
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        2
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Next</span>
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const addVehicle = document.getElementById("addVehicle");
        const pop_add_vehicle = document.getElementById("pop_add_vehicle");
        const ClosePopUp = document.getElementById("ClosePopUp");

        addVehicle.addEventListener("click", () => {
            pop_add_vehicle.classList.toggle("hidden");
        });

        ClosePopUp.addEventListener("click", () => {
            pop_add_vehicle.classList.toggle("hidden");
        });

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