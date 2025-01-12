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

    public function __construct($conn,$title="",$content="",$image="",$status="",$id_theme=0,$id_user=0){
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
    $query = "SELECT A.*, t.name as theme, u.name, GROUP_CONCAT(tg.name) as tags
              FROM articles A
              JOIN themes t ON A.id_theme = t.id_theme
              JOIN utilisateur u ON A.id_user = u.id_user
              LEFT JOIN articles_tags at ON A.id_article = at.id_article
              LEFT JOIN tags tg ON at.id_tag = tg.id_tag
              GROUP BY A.id_article";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


  public function CreateArticle($conn, $title, $content, $image, $id_theme, $id_user, $tags) {
    $query = "INSERT INTO articles (title, content, image, id_theme, id_user) VALUES (:title, :content, :image, :id_theme, :id_user)";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':title' => $title,
        ':content' => $content,
        ':image' => $image,
        ':id_theme' => $id_theme,
        ':id_user' => $id_user
    ]);
    
    $articleId = $conn->lastInsertId();
    
    // Insert tags (already an array from multiple select)
    if (!empty($tags)) {
        foreach($tags as $tagId) {
            $query = "INSERT INTO articles_tags (id_article, id_tag) VALUES (:article_id, :tag_id)";
            $stmt = $conn->prepare($query);
            $stmt->execute([':article_id' => $articleId, ':tag_id' => $tagId]);
        }
    }
    
    return $articleId;
}


 public function CountArticle(){
    $query="SELECT COUNT(*) as total from articles";
    $stmt=$this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

 }
 public function PendingArticle(){
    $query="SELECT COUNT(*) as total from articles where status='pending'";
    $stmt=$this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

 }

 public function AprouveArticle(){
    $query="SELECT COUNT(*) as total from articles where status='approved'";
    $stmt=$this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

 }

 public function searchArticles($search = null, $tag = null, $page = 1, $perPage = 5) {
    // Base query
    $query = "SELECT DISTINCT A.*, t.name as theme, u.name, GROUP_CONCAT(tg.name) as tags
              FROM articles A
              JOIN themes t ON A.id_theme = t.id_theme
              JOIN utilisateur u ON A.id_user = u.id_user
              LEFT JOIN articles_tags at ON A.id_article = at.id_article
              LEFT JOIN tags tg ON at.id_tag = tg.id_tag";
    
    $conditions = [];
    $params = [];
    
    // Add search condition
    if ($search) {
        $conditions[] = "(A.title LIKE :search OR A.content LIKE :search)";
        $params[':search'] = "%$search%";
    }
    
    // Add tag filter
    if ($tag) {
        $conditions[] = "at.id_tag = :tag";
        $params[':tag'] = $tag;
    }

    // Combine conditions if any exist
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }
    
    // Add GROUP BY before LIMIT
    $query .= " GROUP BY A.id_article";
    
    // Add pagination - using LIMIT directly with calculated offset
    $offset = ($page - 1) * $perPage;
    $query .= " LIMIT " . (int)$offset . ", " . (int)$perPage;
    
    $stmt = $this->conn->prepare($query);
    
    // Execute with parameters (excluding LIMIT values which are now part of the query)
    if (!empty($params)) {
        $stmt->execute($params);
    } else {
        $stmt->execute();
    }
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getTotalArticles($search = null, $tag = null) {
    $query = "SELECT COUNT(DISTINCT A.id_article) as total 
              FROM articles A
              JOIN themes t ON A.id_theme = t.id_theme
              JOIN utilisateur u ON A.id_user = u.id_user
              LEFT JOIN articles_tags at ON A.id_article = at.id_article
              LEFT JOIN tags tg ON at.id_tag = tg.id_tag";
    
    $conditions = [];
    $params = [];
    
    if ($search) {
        $conditions[] = "A.title LIKE :search OR A.content LIKE :search";
        $params[':search'] = "%$search%";
    }
    
    if ($tag) {
        $conditions[] = "at.id_tag = :tag";
        $params[':tag'] = $tag;
    }

    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }
    
    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}

public function afficheArticle(){
    $query="SELECT articles.id_article, articles.image,articles.title,articles.status,utilisateur.name,themes.name as theme
  FROM articles
  JOIN themes ON articles.id_theme=themes.id_theme
  JOIN utilisateur ON articles.id_user=utilisateur.id_user";
    $stmt = $this->conn->prepare($query);
     $stmt->execute();
     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
     return $result;
 }
}
?>