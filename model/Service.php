<?php
// Fichier : Service.php
require_once __DIR__ . '/../config/Database.php';

class Service {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getAllServices() {
        $stmt = $this->pdo->prepare("SELECT * FROM services");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServiceById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addService($name, $description, $prix, $image_path) {
        $stmt = $this->pdo->prepare("INSERT INTO services (name, description, prix, image_path) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $description, $prix, $image_path]);
    }

    public function updateService($id, $name, $description, $prix, $image_path) {
        $stmt = $this->pdo->prepare("UPDATE services SET name = ?, description = ?, prix = ?, image_path = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $prix, $image_path, $id]);
    }

    public function deleteService($id) {
        $stmt = $this->pdo->prepare("DELETE FROM services WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

