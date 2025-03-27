<?php
require_once __DIR__ . '/../veterinaireController.php';
require_once __DIR__ . '/../../model/CompteRendu.php';
require_once __DIR__ . '/../../model/Animal.php';

$compteRenduManager = new CompteRendu();
$animalModel = new Animal();
$message = ""; // Message pour afficher les erreurs ou le succès

// Récupérer tous les animaux pour le formulaire
$animals = $animalModel->getAllAnimals();

// Gestion de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add_compte_rendu') {
        // Récupérer les données du formulaire
        $animal_id = intval($_POST['animal']);
        $etat = trim($_POST['etat']);
        $nourriture = trim($_POST['nourriture']);
        $grammage = intval($_POST['grammage']);
        $date_passage = $_POST['date'];
        $detail = trim($_POST['detail']);

        // Validation des champs
        if (empty($animal_id) || empty($etat) || empty($nourriture) || empty($grammage) || empty($date_passage)) {
            $message = "<p class='alert alert-danger'>Tous les champs obligatoires doivent être remplis.</p>";
        } else {
            // Insérer le compte rendu en base de données
            if ($compteRenduManager->ajouterCompteRendu($animal_id, $etat, $nourriture, $grammage, $date_passage, $detail)) {
                $message = "<p class='alert alert-success'>Compte rendu ajouté avec succès !</p>";
            } else {
                $message = "<p class='alert alert-danger'>Erreur lors de l'ajout du compte rendu en base de données.</p>";
            }
        }
    }
}

// Récupérer tous les comptes rendus pour affichage
$comptesRendus = $compteRenduManager->getAllCompteRendu();
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Ajouter un compte rendu</h2>
    <?= $message; ?>

    <form class="p-4 border rounded shadow" method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add_compte_rendu">

        <div class="mb-3">
            <label for="animal" class="form-label">Animal :</label>
            <select id="animal" name="animal" class="form-control" required>
                <?php foreach ($animals as $animal): ?>
                    <option value="<?= htmlspecialchars($animal['id']) ?>"><?= htmlspecialchars($animal['name']) ?> (<?= htmlspecialchars($animal['species']) ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="etat" class="form-label">État :</label>
            <input type="text" id="etat" name="etat" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="nourriture" class="form-label">Nourriture proposée :</label>
            <input type="text" name="nourriture" id="nourriture" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="grammage" class="form-label">Grammage de la nourriture (g) :</label>
            <input type="number" name="grammage" id="grammage" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date de passage :</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="detail" class="form-label">Détail de l'état de l'animal :</label>
            <textarea name="detail" id="detail" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
