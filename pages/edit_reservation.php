<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

include '../includes/autoloader.php';


$database = new Database();
$db = $database->getConnection();
$reservation = new Reservation($db);

$id_reservation = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID.');

// Get all available pickup locations
$places = $reservation->getAllPlaces();

// Get the current reservation details
$query = "SELECT r.*, v.name as vehicle_name, v.model 
          FROM reservation r 
          JOIN vechicule v ON r.vehicle_id = v.id_vechicule 
          WHERE r.id_reservation = :id AND r.user_id = :user_id";
$stmt = $db->prepare($query);
$stmt->bindParam(":id", $id_reservation);
$stmt->bindParam(":user_id", $_SESSION['id_user']);
$stmt->execute();
$current_reservation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$current_reservation) {
    header('Location: affichereservation.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $place_id = $_POST['place_id'];

    $query = "UPDATE reservation 
              SET start_date = :start_date, 
                  end_date = :end_date, 
                  place_id = :place_id 
              WHERE id_reservation = :id_reservation 
              AND user_id = :user_id";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->bindParam(':place_id', $place_id);
    $stmt->bindParam(':id_reservation', $id_reservation);
    $stmt->bindParam(':user_id', $_SESSION['id_user']);

    if ($stmt->execute()) {
        header('Location: affichereservation.php?success=1');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la Réservation - Drive & Loc</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold mb-6">Modifier la Réservation</h1>
            
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">
                    <?php echo htmlspecialchars($current_reservation['vehicle_name'] . ' ' . $current_reservation['model']); ?>
                </h2>
            </div>

            <form action="" method="POST" class="space-y-6">
                <div>
                    <label class="block text-gray-700 mb-2" for="start_date">Date de début</label>
                    <input type="date" 
                           id="start_date" 
                           name="start_date" 
                           value="<?php echo $current_reservation['start_date']; ?>"
                           min="<?php echo date('Y-m-d'); ?>"
                           class="w-full p-2 border rounded focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="end_date">Date de fin</label>
                    <input type="date" 
                           id="end_date" 
                           name="end_date" 
                           value="<?php echo $current_reservation['end_date']; ?>"
                           min="<?php echo date('Y-m-d'); ?>"
                           class="w-full p-2 border rounded focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2" for="place_id">Lieu de prise en charge</label>
                    <select name="place_id" 
                            id="place_id" 
                            class="w-full p-2 border rounded focus:outline-none focus:border-blue-500"
                            required>
                        <?php foreach ($places as $place): ?>
                            <option value="<?php echo $place['id_place']; ?>"
                                    <?php echo ($place['id_place'] == $current_reservation['place_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($place['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" 
                            class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                        Enregistrer les modifications
                    </button>
                    <a href="affichereservation.php" 
                       class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Add date validation
    document.getElementById('start_date').addEventListener('change', function() {
        document.getElementById('end_date').min = this.value;
    });
    </script>
</body>
</html>