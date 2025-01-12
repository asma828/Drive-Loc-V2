<?php
include '../includes/autoloader.php';
$database = new Database();
$db = $database->getConnection();

$id=$_GET['id'];
$query = "DELETE FROM comments
    WHERE id_comment = :id";
     $stmt =$db->prepare($query);
     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      if($query){
          header("Location: AdminComment.php?success=".urlencode("comment delete successfully"));
          exit();
      }

?>