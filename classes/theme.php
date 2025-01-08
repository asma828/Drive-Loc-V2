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


}
