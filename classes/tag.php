<?php
class Tag{
private $id_tag;
private $name;
private $conn;

public function __construct($conn){
    $this->conn=$conn;
    
    }
    
    public function getId(){
        return $this->id_tag;
    }
    public function getName(){
        return $this->name;
    }

    public function setId($id) {
        $this->id_tag = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getAllTags() {
        $query = "SELECT * FROM tags";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $tags = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
            $tag = new Tag($this->conn); 
            $tag->setId($row['id_tag']);
            $tag->setName($row['name']);
            $tags[] = $tag;            
        }
    
        return $tags; // Return an array of Tag objects
    }

    public function addTag($name) {
        $query = "INSERT INTO tags (name) 
                  VALUES (:name)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);

        
        return $stmt->execute();
    }
}
?>