<?php
require_once __DIR__ . '/../config/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $commentaire = $_POST['commentaire'];
    $note = (int) $_POST['note'];

    $pdo = Database::getInstance()->getConnection();

    $stmt = $pdo->prepare("INSERT INTO avis (pseudo, commentaire, note, statut, date_creation) VALUES (?, ?, ?, 'en attente', NOW())");
    $stmt->execute([$pseudo, $commentaire, $note]);

    header("Location: ../index.php?message=avis_envoye");
    exit;
}
