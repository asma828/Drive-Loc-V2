<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

include '../includes/autoloader.php';


$database = new Database();
$db = $database->getConnection();

if (isset($_GET['id'])) {
    $id_reservation = $_GET['id'];
    $query = "DELETE FROM reservation 
              WHERE id_reservation = :id";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id_reservation, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        header('Location: affichereservation.php?success=delete');
    } else {
        header('Location: affichereservation.php?error=1');
    }
} else {
    header('Location: affichereservation.php');
}
exit();
?>