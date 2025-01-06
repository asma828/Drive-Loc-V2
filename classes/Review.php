<?php
class Review {
    private $conn;
    private $table = "reviews";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function canUserReview($userId, $vehicleId) {
        // Checking if the user has a reservation for this vehicle
        $query = "SELECT COUNT(*) as count 
                 FROM reservation 
                 WHERE user_id = :user_id 
                 AND vehicle_id = :vehicle_id 
                 AND status = 'Confirme'";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':vehicle_id', $vehicleId);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("User $userId, Vehicle $vehicleId, Count: " . $result['count']);
        return $result['count'] > 0;
    }

    public function addReview($userId, $vehicleId, $rating, $comment) {
        $query = "INSERT INTO reviews (user_id, vehicle_id, rating, comment) 
                 VALUES (:user_id, :vehicle_id, :rating, :comment)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':vehicle_id', $vehicleId);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':comment', $comment);

        return $stmt->execute();
    }

    public function getReviewsByVehicle($vehicleId) {
        $query = "SELECT r.*, u.name as user_name 
                 FROM " . $this->table . " r
                 JOIN utilisateur u ON r.user_id = u.id_user
                 WHERE r.vehicle_id = :vehicle_id 
                 AND r.deleted_at IS NULL
                 ORDER BY r.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':vehicle_id', $vehicleId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function numberofreviews(){
        $query="SELECT COUNT(*) as total FROM reviews";
        $stmt = $this->conn->prepare($query);
         $stmt->execute();
         $result = $stmt->fetch(PDO::FETCH_ASSOC);
         return $result;
    }

    public function afficheReviews(){
        $query="SELECT vechicule.image,vechicule.name,utilisateur.name as client,reviews.comment,reviews.rating,reviews.id_reviews 
        FROM reviews
        join vechicule on vechicule.id_vechicule= reviews.vehicle_id
        join utilisateur on utilisateur.id_user= reviews.user_id";
    
       $stmt =$this->conn->prepare($query);
      $stmt->execute();
      $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }

    public function deleteReview($reviewId, $userId) {
        // soft delete by setting deleted_at
        $query = "UPDATE reviews 
                  SET deleted_at = CURRENT_TIMESTAMP 
                  WHERE id_reviews = :review_id 
                  AND user_id = :user_id";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':review_id', $reviewId);
        $stmt->bindParam(':user_id', $userId);
        
        return $stmt->execute();
    }

    public function updateReview($reviewId, $userId, $rating, $comment) {
        $query = "UPDATE reviews 
                  SET rating = :rating, 
                      comment = :comment 
                  WHERE id_reviews = :review_id 
                  AND user_id = :user_id 
                  AND deleted_at IS NULL";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':review_id', $reviewId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':comment', $comment);
        
        return $stmt->execute();
    }

    public function getReviewById($reviewId) {
        $query = "SELECT * FROM reviews 
                  WHERE id_reviews = :review_id 
                  AND deleted_at IS NULL";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':review_id', $reviewId);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>