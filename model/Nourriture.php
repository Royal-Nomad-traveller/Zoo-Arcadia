<?php
require_once __DIR__ . '/../config/Database.php';

class Nourriture {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // ✅ Ajouter une nourriture
    public function ajouterNourriture($employe_id, $animal_id, $food, $quantity, $date_time) {
    try {
        $stmt = $this->pdo->prepare("
            INSERT INTO food_log (employe_id, animal_id, food, quantity, date_time) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$employe_id, $animal_id, $food, $quantity, $date_time]);
    } catch (PDOException $e) {
        echo "<pre>Erreur SQL : " . $e->getMessage() . "</pre>";
        return false;
    }
}

    public function afficherNourriture() {
        $stmt = $this->pdo->prepare("
            SELECT fl.id, fl.food, fl.quantity, fl.date_time, 
                   a.name AS animal_name, a.species AS species, a.image AS image, 
                   h.name AS habitat_name, 
                   CONCAT(e.nom, ' ', e.prenom) AS employe_name
            FROM food_log fl
            JOIN animals a ON fl.animal_id = a.id
            JOIN habitats h ON a.habitat_id = h.id
            JOIN employes e ON fl.employe_id = e.id
            ORDER BY h.name ASC, a.name ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
    

    // ✅ Modifier une nourriture existante
    public function changerNourriture($id, $food, $quantity, $date_time) {
        $stmt = $this->pdo->prepare("
            UPDATE food_log 
            SET food = ?, quantity = ?, date_time = ?
            WHERE id = ?
        ");
        return $stmt->execute([$food, $quantity, $date_time, $id]);
    }

    // ✅ Supprimer une nourriture
    public function supprimerNourriture($id) {
        $stmt = $this->pdo->prepare("DELETE FROM food_log WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ✅ Afficher les animaux avec leur nourriture selon leur habitat et triés alphabétiquement
    public function getAnimalsWithFood() {
        $stmt = $this->pdo->query("
            SELECT a.id AS animal_id, a.name AS animal_name, a.image, 
                   a.species, f.food, f.quantity, f.date_time, h.name AS habitat_name
            FROM food_log AS f 
            JOIN animals AS a ON f.animal_id = a.id
            JOIN habitats AS h ON a.habitat_id = h.id
            ORDER BY h.name, f.date_time DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>
