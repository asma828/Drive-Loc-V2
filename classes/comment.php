<?php
class Comment {
    private $id_comment;
    private $id_article;
    private $id_user;
    private $content;
    private $created_at;
    private $conn;

    public function __construct($conn){
        $this->conn=$conn;
        }

        public function getId() { return $this->id_comment; }
        public function getArticleId() { return $this->id_article; }
        public function getUserId() { return $this->id_user; }
        public function getContent() { return $this->content; }
        public function getCreatedAt() { return $this->created_at; }
    
        public function setId($id) { $this->id_comment = $id; }
        public function setArticleId($id) { $this->id_article = $id; }
        public function setUserId($id) { $this->id_user = $id; }
        public function setContent($content) { $this->content = $content; }
        public function setCreatedAt($date) { $this->created_at = $date; }



    public function afficheComment(){
        $query="SELECT comments.id_comment,comments.content,articles.image,articles.title,utilisateur.name
        FROM comments
        JOIN articles ON comments.id_article=articles.id_article
        JOIN utilisateur ON comments.id_user=utilisateur.id_user";
         $stmt = $this->conn->prepare($query);
         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticleComments($article_id) {
        $query = "SELECT c.*, u.name as username 
                 FROM comments c 
                 JOIN utilisateur u ON c.id_user = u.id_user 
                 WHERE c.id_article = :article_id AND c.is_deleted = FALSE 
                 ORDER BY c.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':article_id' => $article_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add comment
    public function addComment($article_id, $user_id, $content) {
        $query = "INSERT INTO comments (id_article, id_user, content) 
                 VALUES (:article_id, :user_id, :content)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':article_id' => $article_id,
            ':user_id' => $user_id,
            ':content' => $content
        ]);
    }

    // Delete comment
    public function deleteComment($comment_id, $user_id) {
        $query = "UPDATE comments SET is_deleted = TRUE 
                 WHERE id_comment = :comment_id AND id_user = :user_id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':comment_id' => $comment_id,
            ':user_id' => $user_id
        ]);
    }
}
