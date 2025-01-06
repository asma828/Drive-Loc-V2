<?php
session_start();
include '../includes/autoloader.php';

if (!isset($_SESSION['id_user']) || !isset($_GET['id'])) {
    header('Location: vehicles.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();
$reviewObj = new Review($db);

$reviewId = $_GET['id'];
$userId = $_SESSION['id_user'];

// Get the id that i will delete
$review = $reviewObj->getReviewById($reviewId);
// this line for chiking that the user who want to delete it is the one who write it 
if ($review && $review['user_id'] == $userId) {
    $reviewObj->deleteReview($reviewId, $userId);
    header("Location: vehicle_details.php?id=" . $review['vehicle_id'] . "&success=delete");
} else {
    header("Location: vehicles.php");
}
exit;