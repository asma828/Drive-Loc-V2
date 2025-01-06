<?php
class Category {
    private $conn;
    private $table = "categorie";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllCategories() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>