<?php 
class Theme {
    private $id_theme;
    private $name;
    private $image;
    private $conn;


public function __construct($conn){
$this->conn=$conn;

}

public function getId(){
    return $this->id_theme;
}
public function getName(){
    return $this->name;
}
public function getImage(){
    return $this->image;
}

public function getAllThemes() {
    $query = "SELECT * from themes"; 
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


}
