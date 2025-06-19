<?php
require_once __DIR__ . '/../../config/Database.php';

$pdo = Database::getInstance()->getConnection();

function afficherAvis() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM avis WHERE statut = 'en attente' ORDER BY date_creation DESC");
    echo "<div class='row mt-5'>";
    while ($avis = $stmt->fetch()) {
        echo "<div class='col-md-6 col-lg-4 mb-3'>
                <div class='card shadow-sm h-100'>
                    <div class='card-body'>
                        <p class='card-text'>{$avis['commentaire']}</p>
                        <div class='d-flex justify-content-between'>
                            <a href='../controller/Manager/avisManager.php?action=valider&id={$avis['id']}' class='btn btn-success btn-sm'>Valider</a>
                            <a href='../controller/Manager/avisManager.php?action=invalider&id={$avis['id']}' class='btn btn-danger btn-sm'>Invalider</a>
                        </div>
                    </div>
                </div>
              </div>";
    }
    echo "</div>";
}

function afficherAvisValides() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM avis WHERE statut = 'validé' ORDER BY date_creation DESC");
    echo "<div class='row'>";
    while ($avis = $stmt->fetch()) {
        echo "<div class='col-md-6 col-lg-4 mb-3'>
                <div class='card shadow-sm h-100'>
                    <div class='card-body'>
                        <p class='card-text'>{$avis['commentaire']}</p>
                    </div>
                </div>
              </div>";
    }
    echo "</div>";
}

// Traitement de la validation ou de l'invalidation d'un avis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if ($action === 'valider') {
        $pdo->prepare("UPDATE avis SET statut = 'validé' WHERE id = ?")->execute([$id]);
    } elseif ($action === 'invalider') {
        $pdo->prepare("UPDATE avis SET statut = 'refusé' WHERE id = ?")->execute([$id]);
    }
    header("Location: ../../view/employer.php?tab=avis&success=1");
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($_GET['action'] === 'valider') {
        $pdo->prepare("UPDATE avis SET statut = 'validé' WHERE id = ?")->execute([$id]);
    } elseif ($_GET['action'] === 'invalider') {
        $pdo->prepare("UPDATE avis SET statut = 'refusé' WHERE id = ?")->execute([$id]);
    }
    header("Location: ../../view/employer.php?tab=avis");
    exit();
}
