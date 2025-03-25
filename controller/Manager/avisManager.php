<?php
require_once __DIR__ . '/../../config/Database.php';

$pdo = Database::getInstance()->getConnection();

function afficherAvis() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM avis");
    echo "<ul>";
    while ($avis = $stmt->fetch()) {
        echo "<li>{$avis['commentaire']} 
              <a href='../controller/Manager/avisManager.php?action=valider&id={$avis['id']}' class='btn btn-success'>Valider</a> 
              <a href='../controller/Manager/avisManager.php?action=invalider&id={$avis['id']}' class='btn btn-danger'>Invalider</a>
              </li>";
    }
    echo "</ul>";
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($_GET['action'] === 'valider') {
        $pdo->prepare("UPDATE avis SET statut = 'validé' WHERE id = ?")->execute([$id]);
    } elseif ($_GET['action'] === 'invalider') {
        $pdo->prepare("UPDATE avis SET statut = 'refusé' WHERE id = ?")->execute([$id]);
    }
    header("Location: ../../employees.php?tab=avis");
}
