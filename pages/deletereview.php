<?php
include '../includes/autoloader.php';
$database = new Database();
$db = $database->getConnection();

$id=$_GET['id'];
$query = "DELETE FROM reviews
    WHERE id_reviews = :id";
     $stmt =$db->prepare($query);
     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      if($query){
          header("Location: AdminReviews.php?success=".urlencode("review delete successfully"));
          exit();
      }

?>
