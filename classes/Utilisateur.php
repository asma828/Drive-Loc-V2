<?php
class Utilisateur {
    private $db;

    public function __construct(Database $database) {
        $this->db = $database->getConnection();
    }

    public function signup($nom, $email, $password, $role_id = 1) {
        // Vérifier si l'email existe déjà
        $stmt = $this->db->prepare("SELECT id_user FROM utilisateur WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return "Cet email existe déjà";
        }

        // Vérifier la force du mot de passe
        if(strlen($password) < 6) {
            return "Le mot de passe doit contenir au moins 8 caractères";
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO utilisateur (name, email, password, role_id) 
            VALUES (:name, :email, :password, :role_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $nom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password_hash);
            $stmt->bindParam(':role_id', $role_id);
            $stmt->execute();
            return "Inscription réussie";
        } catch(PDOException $e) {
            return "Erreur lors de l'inscription: " . $e->getMessage();
        }
    }

    public function connexion($email, $password) {
        // Use a named placeholder for the email
        $sql = "SELECT * FROM utilisateur WHERE email = :email";
        $stmt = $this->db->prepare($sql);
    
        // Bind the parameter
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    
        // Execute the query
        $stmt->execute();
    
        // Check if the user exists
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Verify the password
            if (password_verify($password, $row['password'])) {
                // Start the session and set session variables
                session_start();
                $_SESSION['id_user'] = $row['id_user'];
                $_SESSION['role'] = $row['role_id'];
                $_SESSION['name'] = $row['name'];
                var_dump($_SESSION);
                return "Connexion réussie";
            }
            return "Mot de passe incorrect";
        }
        return "Email non trouvé";
    }
    public function numbreofclient(){
        $query="SELECT (COUNT(*) - 1) as total FROM utilisateur";
        $stmt = $this->db->prepare($query);
         $stmt->execute();
         $result = $stmt->fetch(PDO::FETCH_ASSOC);
         return $result;
}
}
?>