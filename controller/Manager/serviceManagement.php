<?php
require_once __DIR__ . '/../../model/Service.php';
require_once __DIR__ . '/../../model/Horaire.php';
require_once __DIR__ . '/../AdminController.php';

$serviceManager = new Service();
$message = ""; // Message pour afficher les erreurs ou le succès

$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/services/';
if (!is_writable($uploadDir)) {
    die("Erreur : PHP ne peut pas écrire dans le dossier $uploadDir. Vérifiez les permissions !");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add_service') {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $prix = floatval($_POST['prix']);

        if (empty($name) || empty($description) || empty($prix)) {
            $message = "<p class='alert alert-danger'>Tous les champs sont obligatoires.</p>";
        } else {
            // Gestion de l'upload d'image
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $image_name = basename($_FILES['image']['name']);
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/services/';

                // Vérifier si le dossier "uploads/services" existe, sinon le créer
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $image_path = $uploadDir . $image_name;
                $relative_image_path = '/uploads/services/' . $image_name;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                    // Insérer le service en base de données
                    if ($serviceManager->addService($name, $description, $prix, $relative_image_path)) {
                        $message = "<p class='alert alert-success'>Service ajouté avec succès !</p>";
                    } else {
                        $message = "<p class='alert alert-danger'>Erreur lors de l'ajout du service en base de données.</p>";
                    }
                } else {
                    $message = "<p class='alert alert-danger'>Erreur lors du déplacement du fichier.</p>";
                }
            } else {
                $message = "<p class='alert alert-danger'>Erreur lors du téléchargement du fichier.</p>";
            }
        }
    }
}

$services = $serviceManager->getAllServices();
?>

<?php

$horaireManager = new Horaire();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add_horaire') {
        $jour = trim($_POST['jour']);
        $heure_ouverture = $_POST['heure_ouverture'];
        $heure_fermeture = $_POST['heure_fermeture'];

        // Vérifier si les valeurs sont valides
        if (empty($jour) || empty($heure_ouverture) || empty($heure_fermeture)) {
            echo "<p class='alert alert-danger'>Tous les champs sont obligatoires.</p>";
        } else {
            // Insérer dans la base de données
            if ($horaireManager->addHoraire($jour, $heure_ouverture, $heure_fermeture)) {
                echo "<p class='alert alert-success'>Horaire ajouté avec succès !</p>";
                header("Location: ../../view/admin.php#horaires"); // Redirection après ajout
                exit();
            } else {
                echo "<p class='alert alert-danger'>Erreur lors de l'ajout de l'horaire.</p>";
            }
        }
    }
}

$horaires = $horaireManager->getAllHoraires();
?>


<div class="container mt-5">
    <h2 class="mb-4">Ajouter un service</h2>

    <?php echo $message; // Affichage des messages ?>

    <form method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow">
        <input type="hidden" name="action" value="add_service">

        <div class="mb-3">
            <label for="name" class="form-label">Nom du service :</label>
            <input type="text" id="name_services" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description :</label>
            <textarea id="description_services" name="description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix (€) :</label>
            <input type="number" step="0.01" id="prix" name="prix" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image :</label>
            <input type="file" id="image_services" name="image" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Ajouter un service</button>
    </form>
</div>

<div class="container mt-5">
    <h2 class="mb-4">Ajouter un horaire</h2>
    <form action="admin.php" method="POST" class="p-4 border rounded shadow">
        <input type="hidden" name="action" value="add_horaire">

        <div class="mb-3">
            <label for="jour" class="form-label">Jour :</label>
            <select name="jour" class="form-select" required>
                <option value="Lundi">Lundi</option>
                <option value="Mardi">Mardi</option>
                <option value="Mercredi">Mercredi</option>
                <option value="Jeudi">Jeudi</option>
                <option value="Vendredi">Vendredi</option>
                <option value="Samedi">Samedi</option>
                <option value="Dimanche">Dimanche</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="heure_ouverture" class="form-label">Heure d'ouverture :</label>
            <input type="time" name="heure_ouverture" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="heure_fermeture" class="form-label">Heure de fermeture :</label>
            <input type="time" name="heure_fermeture" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Ajouter Horaire</button>
    </form>
</div>


<?php afficherHoraires(); ?>

<?php afficherServices(); ?>
