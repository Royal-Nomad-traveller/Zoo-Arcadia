<?php
// Fichier : Horaire.php
require_once __DIR__ . '/../config/Database.php';

class Horaire {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getAllHoraires() {
        $stmt = $this->pdo->prepare("SELECT * FROM horaires");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addHoraire($jour, $heure_ouverture, $heure_fermeture) {
        $stmt = $this->pdo->prepare("INSERT INTO horaires (jour, heure_ouverture, heure_fermeture) VALUES (?, ?, ?)");
        return $stmt->execute([$jour, $heure_ouverture, $heure_fermeture]);
    }

    public function updateHoraire($id, $jour, $heure_ouverture, $heure_fermeture) {
        $stmt = $this->pdo->prepare("UPDATE horaires SET jour = ?, heure_ouverture = ?, heure_fermeture = ? WHERE id = ?");
        return $stmt->execute([$jour, $heure_ouverture, $heure_fermeture, $id]);
    }

    public function deleteHoraire($id) {
        $stmt = $this->pdo->prepare("DELETE FROM horaires WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
