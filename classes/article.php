<?php 
class Article {
    private $id_article;
    private $title;
    private $content;
    private $image;
    private $status;
    private $id_theme;
    private $id_user;
    private $conn;

    public function __construct($conn,$title="",$content="",$image="",$status="",$id_theme=0,$id_user=0,){
    $this->conn=$conn; 
    $this->title=$title;
    $this->content=$content;
    $this->image=$image;
    $this->status=$status;
    $this->id_theme=$id_theme;
    $this->id_user=$id_user; 
    
    }
public function getId(){
    return $this->id_article;
}
public function getTitle(){
    return $this->title;
}

public function getContent(){
    return $this->content;
}

public function getImage(){
    return $this->image;
}

public function getStatus(){
    return $this->status;
}

public function getThemeId(){
    return $this->id_theme;
}

public function getUserId(){
    return $this->id_user;
}

public function getAllArticles() {
    $query = "SELECT A.*, t.name as theme,u.name
              FROM articles A
              JOIN themes t ON A.id_theme = t.id_theme
              JOIN utilisateur u ON A.id_user=u.id_user "; 
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


}
?>