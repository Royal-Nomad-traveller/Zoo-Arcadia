<?php
require_once __DIR__ . '/../config/Database.php';

class Commentaire {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // Ajouter un commentaire
    public function ajouterCommentaire($habitat_id, $veterinaire, $commentaire, $date_commentaire) {
        $stmt = $this->pdo->prepare("
            INSERT INTO commentaire (habitat_id, veterinaire, commentaire, date_commentaire, created_at) 
            VALUES (?, ?, ?, ?, NOW())
        ");
        if (!$stmt->execute([$habitat_id, $veterinaire, $commentaire, $date_commentaire])) {
            die("Erreur SQL : " . implode(", ", $stmt->errorInfo()));
        }
        return true;
    }

    // Récupérer tous les commentaires
    public function getAllCommentaires() {
        $stmt = $this->pdo->query("
            SELECT c.*, h.name AS habitat_name
            FROM commentaire c
            JOIN habitats h ON c.habitat_id = h.id
            ORDER BY c.date_commentaire DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un commentaire par son ID
    public function getCommentaireById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM commentaire WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour un commentaire
    public function updateCommentaire($id, $veterinaire, $commentaire, $date_commentaire) {
        $stmt = $this->pdo->prepare("
            UPDATE commentaire 
            SET veterinaire = ?, commentaire = ?, date_commentaire = ? 
            WHERE id = ?
        ");
        return $stmt->execute([$veterinaire, $commentaire, $date_commentaire, $id]);
    }

    // Supprimer un commentaire
    public function deleteCommentaire($id) {
        $stmt = $this->pdo->prepare("DELETE FROM commentaire WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Récupérer les commentaires par ID d'habitat
    public function getCommentairesByHabitatId($habitat_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM commentaire WHERE habitat_id = ?");
        $stmt->execute([$habitat_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les commentaires par vétérinaire
    public function getCommentairesByVeterinaire($veterinaire) {
        $stmt = $this->pdo->prepare("SELECT * FROM commentaire WHERE veterinaire = ?");
        $stmt->execute([$veterinaire]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les commentaires par date
    public function getCommentairesByDate($date_commentaire) {
        $stmt = $this->pdo->prepare("SELECT * FROM commentaire WHERE date_commentaire = ?");
        $stmt->execute([$date_commentaire]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

