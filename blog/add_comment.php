<?php
session_start();
include '../includes/autoloader.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id_user'])) {
    $db = new Database();
    $conn = $db->getConnection();
    
    $comment = new Comment($conn);
    
    $article_id = $_POST['article_id'];
    $user_id = $_SESSION['id_user'];
    $content = trim($_POST['content']);
    
    if (!empty($content)) {
        $comment->addComment($article_id, $user_id, $content);
    }
    
    // Redirect back to the article
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    header("Location: themes.php");
    exit;
}