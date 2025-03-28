<?php
// Fichier : Animal.php
require_once __DIR__ . '/../config/Database.php';

class Animal {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getAllAnimals() {
        $stmt = $this->pdo->prepare("
            SELECT animals.*, habitats.name AS habitat_name 
            FROM animals 
            JOIN habitats ON animals.habitat_id = habitats.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getAnimalById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM animals WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addAnimal($name, $species, $habitat, $images) {
        $stmt = $this->pdo->prepare("INSERT INTO animals (name, species, habitat_id, image) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $species, $habitat, $images]);
    }

    public function updateAnimal($id, $name, $species, $habitat, $images) {
        $stmt = $this->pdo->prepare("UPDATE animals SET name = ?, species = ?, habitat_id = ?, image = ? WHERE id = ?");
        return $stmt->execute([$name, $species, $habitat, $images, $id]);
    }

    public function deleteAnimal($id) {
        $stmt = $this->pdo->prepare("DELETE FROM animals WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function getLimitedAnimals($limit = 10) {
        $stmt = $this->pdo->prepare("
            SELECT animals.*, habitats.name AS habitat_name 
            FROM animals 
            JOIN habitats ON animals.habitat_id = habitats.id
            LIMIT ?
        ");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
