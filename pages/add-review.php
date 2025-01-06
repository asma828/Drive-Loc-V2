<?php
session_start();
include '../includes/autoloader.php';

if (!isset($_SESSION['id_user']) || !isset($_POST['vehicle_id'])) {
    header('Location: vehicles.php?success=".urlencode("id not found"))');
    exit;
}

$database = new Database();
$db = $database->getConnection();
$reviewObj = new Review($db);

$userId = $_SESSION['id_user'];
$vehicleId = $_POST['vehicle_id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

// Verify that user can review on a car he reserve at least once
if ($reviewObj->canUserReview($userId, $vehicleId)) {
    if ($reviewObj->addReview($userId, $vehicleId, $rating, $comment)) {
        header("Location: vehicle_details.php?id=success=1");
    } else {
        header("Location: vehicle_details.php?id=error=1");
    }
} 
exit;
?>