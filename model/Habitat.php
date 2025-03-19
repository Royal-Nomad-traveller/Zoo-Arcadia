<?php 
// Fichier : Habitat.php
require_once __DIR__ . '/../config/Database.php';

class Habitat {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getAllHabitats() {
        $stmt = $this->pdo->prepare("SELECT * FROM habitats");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHabitatById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM habitats WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addHabitat($name, $location, $description, $image_path) {
        $stmt = $this->pdo->prepare("INSERT INTO habitats (name,location, description, image_path) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $location, $description, $image_path]);
    }    

    public function updateHabitat($id, $name, $location, $description) {
        $stmt = $this->pdo->prepare("UPDATE habitats SET name = ?, location = ?, description = ? WHERE id = ?");
        return $stmt->execute([$name, $location, $description, $id]);
    }

    public function deleteHabitat($id) {
        $stmt = $this->pdo->prepare("DELETE FROM habitats WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
