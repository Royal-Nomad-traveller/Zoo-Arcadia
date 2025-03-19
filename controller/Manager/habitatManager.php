<?php
require_once __DIR__ . '/../../model/Habitat.php';

$habitatManager = new Habitat();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $name = $_POST['name'];
        $location = $_POST['location'];
        $description = $_POST['description'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $image_name = basename($_FILES['image']['name']);
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';

            // Vérifier si le dossier "uploads" existe, sinon le créer
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $image_path = $uploadDir . $image_name;

            // Vérifier que le fichier temporaire existe
            if (!file_exists($_FILES['image']['tmp_name'])) {
                echo "Erreur : le fichier temporaire n'existe pas.";
                exit;
            }

            // Déplacement du fichier
            if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                $relative_image_path = '/uploads/' . $image_name; // Chemin accessible depuis le navigateur
                $habitatManager->addHabitat($name, $location, $description, $relative_image_path);
                echo "Fichier uploadé avec succès !";
            } else {
                echo "Erreur lors du déplacement du fichier.";
            }
        } else {
            echo "Erreur lors du téléchargement du fichier : " . $_FILES['image']['error'];
        }
    }
}

$habitats = $habitatManager->getAllHabitats();
?>



    <div class="container mt-5">
        <h2 class="mb-4">Ajouter un habitat</h2>
        
        <form method="POST" action="admin.php" enctype="multipart/form-data" class="p-4 border rounded shadow">
            <input type="hidden" name="action" value="add">

            <div class="mb-3">
                <label for="name" class="form-label">Nom :</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Localisation :</label>
                <input type="text" id="location" name="location" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description :</label>
                <textarea id="description" name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image :</label>
                <input type="file" id="image" name="image" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter un habitat</button>
        </form>
    </div>

    <h2 class="text-center mt-5">Liste des habitats</h2>
    <div class="row">
        <?php foreach ($habitats as $habitat): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img class="card-img-top" src="<?php echo htmlspecialchars('/uploads/' . basename($habitat['image_path'])); ?>" alt="<?php echo htmlspecialchars($habitat['name']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($habitat['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($habitat['description']); ?></p>
                        <a href="edit_habitat.php?id=<?php echo $habitat['id']; ?>" class="btn btn-success">Modifier</a>
                        <a href="delete_habitat.php?id=<?php echo $habitat['id']; ?>" class="btn btn-danger">Supprimer</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

