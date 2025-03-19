
<?php
require_once __DIR__ . '/../config/Database.php'; // Ajout pour inclure la classe Database

class User {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT id, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}
?>

<?php
require_once '../config/Database.php';

class Users {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getAllUsers() {
        $stmt = $this->pdo->prepare("SELECT prenom, nom, role FROM employes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function addUser($prenom, $nom, $role, $password) {
        $stmt = $this->pdo->prepare("INSERT INTO employes (prenom, nom, role, password) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$prenom, $nom, $role, $password]);
    }
    
}
?>


