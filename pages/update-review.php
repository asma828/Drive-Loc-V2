<?php
session_start();
include '../includes/autoloader.php';

if (!isset($_SESSION['id_user']) || !isset($_POST['review_id'])) {
    header('Location: vehicles.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();
$reviewObj = new Review($db);

$reviewId = $_POST['review_id'];
$userId = $_SESSION['id_user'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

// Get the id of the review that i want to modify
$review = $reviewObj->getReviewById($reviewId);

if ($review && $review['user_id'] == $userId) {
    $reviewObj->updateReview($reviewId, $userId, $rating, $comment);
    header("Location: vehicle_details.php?id=" . $review['vehicle_id'] . "&success=update");
} else {
    header("Location: vehicles.php");
}
exit;