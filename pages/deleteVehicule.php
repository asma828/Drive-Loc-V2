<?php
include '../includes/autoloader.php';


$database = new Database();
$db = $database->getConnection();

if (isset($_GET['id'])) {
    $id_reservation = $_GET['id'];
    $query = "DELETE FROM vechicule
    WHERE id_vechicule = :id";
     $stmt =$db->prepare($query);
     $stmt->bindParam(':id', $id_reservation, PDO::PARAM_INT);
      $stmt->execute();
      if($query){
          header("Location: AdminVehicles.php?success=".urlencode("vehicule delete successfully"));
          exit();
      }
}
?>