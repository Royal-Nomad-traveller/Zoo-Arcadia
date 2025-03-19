
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



