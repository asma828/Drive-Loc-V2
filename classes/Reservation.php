<?php
class Reservation {
    private $conn;
    

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createReservation($data) {
        if (!$this->isVehicleAvailable($data['vehicle_id'], $data['start_date'], $data['end_date'])) {
            return false;
        }

        $query = "INSERT INTO reservation
                  (user_id, vehicle_id, place_id, start_date, end_date) 
                  VALUES 
                  (:user_id, :vehicle_id, :place_id, :start_date, :end_date)";

        $stmt = $this->conn->prepare($query);

        // Clean data
        $user_id = htmlspecialchars(strip_tags($data['user_id']));
        $vehicle_id = htmlspecialchars(strip_tags($data['vehicle_id']));
        $place_id = htmlspecialchars(strip_tags($data['place_id']));
        $start_date = htmlspecialchars(strip_tags($data['start_date']));
        $end_date = htmlspecialchars(strip_tags($data['end_date']));

        // Bind data
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":vehicle_id", $vehicle_id);
        $stmt->bindParam(":place_id", $place_id);
        $stmt->bindParam(":start_date", $start_date);
        $stmt->bindParam(":end_date", $end_date);

        return $stmt->execute();
    }

    public function isVehicleAvailable($vehicleId, $startDate, $endDate) {
        $query = "SELECT COUNT(*) as count 
                  FROM reservation
                  WHERE vehicle_id = :vehicle_id 
                  AND start_date < :end_date 
                  AND end_date > :start_date";

        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":vehicle_id", $vehicleId);
        $stmt->bindParam(":start_date", $startDate);
        $stmt->bindParam(":end_date", $endDate);

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['count'] == 0;
    }

    public function getReservationsByUser($userId) {
        $query = "SELECT r.*, v.name as vehicle_name, v.model, v.image, 
                         p.name as pickup_location
                  FROM reservation r
                  JOIN vechicule v ON r.vehicle_id = v.id_vechicule
                  JOIN place p ON r.place_id = p.id_place
                  WHERE r.user_id = :user_id
                  ORDER BY r.start_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllPlaces() {
        $query = "SELECT * FROM place ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function numbreofreservation(){
       $query="SELECT COUNT(*) as total FROM reservation";
       $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
}

 public function affichereservation(){
    $query="SELECT DATEDIFF(reservation.end_date,reservation.start_date) as durée,reservation.status,reservation.id_reservation,vechicule.image,vechicule.name,vechicule.prix,utilisateur.name as client
    FROM vechicule
    join reservation on vechicule.id_vechicule=reservation.vehicle_id
    join utilisateur on utilisateur.id_user=reservation.user_id";
    $stmt = $this->conn->prepare($query);
     $stmt->execute();
     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
     return $result;
 }

 
}