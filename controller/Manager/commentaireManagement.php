<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../veterinaireController.php';
require_once __DIR__ . '/../../model/Commentaire.php';
require_once __DIR__ . '/../../model/Habitat.php';

$commentaireManager = new Commentaire();
$habitatModel = new Habitat();
$message = ""; // Message pour afficher les erreurs ou le succès

// Récupérer tous les habitats pour le formulaire
$habitats = $habitatModel->getAllHabitats();

// Gestion de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add_commentaire') {
        // Récupérer les données du formulaire
        $habitat_id = intval($_POST['habitat']);
        $veterinaire = trim($_POST['veterinaire']);
        $commentaire = trim($_POST['commentaire']);
        $date_commentaire = $_POST['date_commentaire'];

        // Validation des champs
        if (empty($habitat_id) || empty($veterinaire) || empty($commentaire) || empty($date_commentaire)) {
            $message = "<p class='alert alert-danger'>Tous les champs obligatoires doivent être remplis.</p>";
        } else {
            // Insérer le commentaire en base de données
            if ($commentaireManager->ajouterCommentaire($habitat_id, $veterinaire, $commentaire, $date_commentaire)) {
                $message = "<p class='alert alert-success'>Commentaire ajouté avec succès !</p>";
            } else {
                $message = "<p class='alert alert-danger'>Erreur lors de l'ajout du commentaire en base de données.</p>";
            }
        }
    }
}

// Récupérer tous les commentaires pour affichage
$commentaires = $commentaireManager->getAllCommentaires();
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Ajouter un commentaire</h2>
    <?= $message; ?>

    <form class="p-4 border rounded shadow" method="POST" action="">
        <input type="hidden" name="action" value="add_commentaire">

        <div class="mb-3">
            <label for="habitat" class="form-label">Habitat :</label>
            <select id="habitat" name="habitat" class="form-control" required>
                <?php foreach ($habitats as $habitat): ?>
                    <option value="<?= htmlspecialchars($habitat['id']) ?>">
                        <?= htmlspecialchars($habitat['name']) ?> (<?= htmlspecialchars($habitat['location']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="veterinaire" class="form-label">Vétérinaire :</label>
            <input type="text" id="veterinaire" name="veterinaire" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="commentaire" class="form-label">Commentaire :</label>
            <textarea name="commentaire" id="commentaire" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="date_commentaire" class="form-label">Date :</label>
            <input type="date" name="date_commentaire" id="date_commentaire" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>

