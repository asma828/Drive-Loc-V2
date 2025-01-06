<?php

include '../includes/autoloader.php';


$database = new Database();
$db = $database->getConnection();

$id = $_GET['id'];
$query="UPDATE reservation SET status= 'Anuller' WHERE id_reservation = :id";
       $stmt =$db->prepare($query);
       $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if($query){
            header("Location: Adminreservation.php?success=".urlencode("Reservation confirmed successfully"));
            exit();
        }
?>