<?php
class Comment {
    private $id_comment;
    private $id_article;
    private $id_user;
    private $content;
    private $conn;

    public function __construct($conn){
        $this->conn=$conn;
        }

    public function getId(){
        return $this->id_comment;
    }

    public function getArticleId(){
        return $this->id_article;
    }
   
    public function getUserId(){
        return $this->id_user;
    }

    public function content(){
        return $this->content;
    }

    public function afficheComment(){
        $query="SELECT comments.id_comment,comments.content,articles.image,articles.title,utilisateur.name
        FROM comments
        JOIN articles ON comments.id_article=articles.id_article
        JOIN utilisateur ON comments.id_user=utilisateur.id_user";
         $stmt = $this->conn->prepare($query);
         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}