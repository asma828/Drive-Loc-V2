<?php

include '../includes/autoloader.php';


$database = new Database();
$db = $database->getConnection();

$id = $_GET['id'];
$query="UPDATE articles SET status= 'rejected' WHERE id_article = :id";
       $stmt =$db->prepare($query);
       $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if($query){
            header("Location: AdminArticle.php?success=".urlencode("Article rejected successfully"));
            exit();
        }
?>








