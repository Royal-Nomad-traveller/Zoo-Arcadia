<?php
// Fichier : Report.php
require_once __DIR__ . '/../config/Database.php';

class Report {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getAllReports() {
        $stmt = $this->pdo->prepare("SELECT * FROM reports");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReportById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM reports WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addReport($animal_nom, $date, $contenu) {
        $stmt = $this->pdo->prepare("INSERT INTO reports (animal_nom, date, contenu) VALUES (?, ?, ?)");
        return $stmt->execute([$animal_nom, $date, $contenu]);
    }

    public function updateReport($id, $animal_nom, $date, $contenu) {
        $stmt = $this->pdo->prepare("UPDATE reports SET animal_nom = ?, date = ?, contenu = ? WHERE id = ?");
        return $stmt->execute([$animal_nom, $date, $contenu, $id]);
    }

    public function deleteReport($id) {
        $stmt = $this->pdo->prepare("DELETE FROM reports WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
