<?php
require_once __DIR__ . '/../config/Database.php';

class Avis {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // Ajouter un avis
    public function ajouterAvis($employe_id, $commentaire) {
        $stmt = $this->pdo->prepare("INSERT INTO avis (employe_id, commentaire) VALUES (?, ?)");
        return $stmt->execute([$employe_id, $commentaire]);
    }

    // Récupérer tous les avis
    public function getAllAvis() {
        $stmt = $this->pdo->query("SELECT a.*, e.nom FROM avis a JOIN employes e ON a.employe_id = e.id ORDER BY a.date_creation DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mettre à jour le statut d'un avis (valider ou refuser)
    public function changerStatutAvis($id, $statut) {
        $stmt = $this->pdo->prepare("UPDATE avis SET statut = ? WHERE id = ?");
        return $stmt->execute([$statut, $id]);
    }
}
?>
