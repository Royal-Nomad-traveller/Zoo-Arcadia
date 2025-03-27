<?php
require_once __DIR__ . '/../config/Database.php';

class CompteRendu {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }   


    public function ajouterCompteRendu($animal_id, $etat, $nourriture, $grammage, $date_passage, $detail) {
    $stmt = $this->pdo->prepare("
        INSERT INTO compte_rendus (animal_id, etat, nourriture, grammage, date_passage, detail, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");
    if (!$stmt->execute([$animal_id, $etat, $nourriture, $grammage, $date_passage, $detail])) {
        die("Erreur SQL : " . implode(", ", $stmt->errorInfo()));
    }
    return true;
    }

    public function getAllCompteRendu() {
        $stmt = $this->pdo->query("
            SELECT cr.*, a.name AS animal_name, a.image AS image, h.name AS habitat_name
            FROM compte_rendus cr
            JOIN animals a ON cr.animal_id = a.id
            JOIN habitats h ON a.habitat_id = h.id
            ORDER BY h.name, cr.date_passage DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCompteRenduById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM compte_rendus WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCompteRendu($id, $etat, $nourriture, $grammage, $date_passage, $detail) {
        $stmt = $this->pdo->prepare("UPDATE compte_rendus SET etat = ?, nourriture = ?, grammage = ?, date_passage = ?, detail = ? WHERE id = ?");
        return $stmt->execute([$etat, $nourriture, $grammage, $date_passage, $detail, $id]);
    }

    public function deleteCompteRendu($id) {
        $stmt = $this->pdo->prepare("DELETE FROM compte_rendus WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getCompteRenduByAnimalId($animal_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM compte_rendus WHERE animal_id = ?");
        $stmt->execute([$animal_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCompteRenduByDate($date) {
        $stmt = $this->pdo->prepare("SELECT * FROM compte_rendus WHERE date_passage = ?");
        $stmt->execute([$date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCompteRenduByEtat($etat) {
        $stmt = $this->pdo->prepare("SELECT * FROM compte_rendus WHERE etat = ?");
        $stmt->execute([$etat]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCompteRenduByNourriture($nourriture) {
        $stmt = $this->pdo->prepare("SELECT * FROM compte_rendus WHERE nourriture = ?");
        $stmt->execute([$nourriture]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}