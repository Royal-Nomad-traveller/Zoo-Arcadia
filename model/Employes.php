<?php
require_once __DIR__ . '/../config/Database.php';

class Employes {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    /**
     * Récupérer tous les employés
     */
    public function getAllEmployes() {
        $stmt = $this->pdo->prepare("SELECT id, prenom, nom, email, role FROM employes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer un employé par son ID
     */
    public function getEmployeById($id) {
        $stmt = $this->pdo->prepare("SELECT id, prenom, nom, email, role FROM employes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Vérifier si un email existe déjà
     */
        public function getEmployeByEmail($email) {
            $query = "SELECT * FROM employes WHERE email = :email";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

    /**
     * Ajouter un nouvel employé
     */
    public function addEmploye($prenom, $nom, $email, $role, $password) {
        if ($this->getEmployeByEmail($email)) {
            return "Cet email est déjà utilisé.";
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO employes (prenom, nom, email, role, password) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$prenom, $nom, $email, $role, $hashedPassword]);
    }

    /**
     * Mettre à jour les informations d'un employé
     */
    public function updateEmploye($id, $prenom, $nom, $email, $role, $password = null) {
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->pdo->prepare("UPDATE employes SET prenom = ?, nom = ?, email = ?, role = ?, password = ? WHERE id = ?");
            return $stmt->execute([$prenom, $nom, $email, $role, $hashedPassword, $id]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE employes SET prenom = ?, nom = ?, email = ?, role = ? WHERE id = ?");
            return $stmt->execute([$prenom, $nom, $email, $role, $id]);
        }
    }

    /**
     * Supprimer un employé
     */
    public function deleteEmploye($id) {
        $stmt = $this->pdo->prepare("DELETE FROM employes WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

class Employee {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
        if (!$this->pdo) {
            die("Erreur : Impossible de se connecter à la base de données.");
        }
    }

    public function getEmployeeByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM employes WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
