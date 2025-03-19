<?php
require_once __DIR__ . '/../../model/Service.php';

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

<div class="container mt-5">
    <h2 class="mb-4">Ajouter un service</h2>

    <?php echo $message; // Affichage des messages ?>

    <form method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow">
        <input type="hidden" name="action" value="add_service">

        <div class="mb-3">
            <label for="name" class="form-label">Nom du service :</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description :</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix (€) :</label>
            <input type="number" step="0.01" id="prix" name="prix" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image :</label>
            <input type="file" id="image" name="image" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Ajouter un service</button>
    </form>
</div>

<?php afficherServices(); ?>
