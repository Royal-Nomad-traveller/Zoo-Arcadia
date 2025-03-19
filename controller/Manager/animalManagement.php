<?php
require_once __DIR__ . '/../../model/Animal.php';
require_once __DIR__ . '/../../model/Habitat.php';


$animalManager = new Animal();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add_animal') {
        $name = $_POST['name'];
        $species = $_POST['species'];
        $habitat = intval($_POST['habitat']);

        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $image_name = basename($_FILES['image']['name']);
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/animals/';

            // Vérifier si le dossier "uploads/animals" existe, sinon le créer
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $image_path = $uploadDir . $image_name;
            $relative_image_path = '/uploads/animals/' . $image_name;

            // Vérifier que le fichier temporaire existe
            if (!file_exists($_FILES['image']['tmp_name'])) {
                echo "Erreur : le fichier temporaire n'existe pas.";
                exit;
            }

            // Déplacement du fichier
            if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                $relative_image_path = '/uploads/animals/' . $image_name; // Chemin accessible depuis le navigateur
                if ($animalManager->addAnimal($name, $species, $habitat, $relative_image_path)) {
                    echo "Animal ajouté avec succès !";
                    header("Location: ../../view/admin.php#animals"); // Ajustez ce chemin si nécessaire
                    exit();
                } else {
                    echo "Erreur lors de l'ajout de l'animal.";
                }
                
            } else {
                echo "Erreur lors du déplacement du fichier.";
            }            
        }  else {
            echo "Erreur lors du téléchargement du fichier : " . $_FILES['image']['error'];
        }
    }
}

$animals = $animalManager->getAllAnimals();
?>

<div class="container mt-5">
    <h2 class="mb-4">Ajouter un animal</h2>

    <form method="POST" action="admin.php" enctype="multipart/form-data" class="p-4 border rounded shadow">
        <input type="hidden" name="action" value="add_animal">

        <div class="mb-3">
            <label for="name" class="form-label">Nom :</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="species" class="form-label">Espèce :</label>
            <input type="text" id="species" name="species" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="habitat" class="form-label">Habitat :</label>
            <select id="habitat" name="habitat" class="form-control" required>
                <?php
                $habitatModel = new Habitat();
                $habitats = $habitatModel->getAllHabitats();
                foreach ($habitats as $habitat) {
                    echo "<option value='{$habitat['id']}'>{$habitat['name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image :</label>
            <input type="file" id="image" name="image" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter un animal</button>
    </form>
</div>



