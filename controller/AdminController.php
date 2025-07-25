<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/Service.php';
require_once __DIR__ . '/../model/Animal.php';
require_once __DIR__ . '/../model/Report.php';
require_once __DIR__ . '/../model/Habitat.php';
require_once __DIR__ . '/../model/CompteRendu.php';

function afficherUtilisateurs() {
    $employeModel = new Employes(); // Utilisation de la bonne classe
    $employes = $employeModel->getAllEmployes();

    echo '<h3 class="text-center mt-4">Gestion des employés</h3>';
    echo '<div class="table-responsive">';
    echo '<table class="table table-users">';
    echo '<thead><tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Actions</th>
          </tr></thead>';
    echo '<tbody>';

    foreach ($employes as $employe) {
        $icon = ($employe['role'] === 'vétérinaire') ? '🏥' : '🏢';

        echo '<tr>';
        echo '<td>' . htmlspecialchars($employe['id']) . '</td>';
        echo '<td>' . htmlspecialchars($employe['nom']) . '</td>'; // Utilisation de "nom"
        echo '<td>' . htmlspecialchars($employe['prenom']) . '</td>'; // Utilisation de "prenom"
        echo '<td>' . htmlspecialchars($employe['email']) . '</td>';
        echo '<td>' . $icon . ' ' . htmlspecialchars($employe['role']) . '</td>';
        echo    '<td>
                    <form method="POST" action="admin.php" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cet utilisateur ?\');">
                        <input type="hidden" name="action" value="delete_user">
                        <input type="hidden" name="id" value="' . $employe['id'] . '">
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
    echo '</div>';
}

function afficherComptesRendus() {
    $compteRenduModel = new CompteRendu();

    // Vérification des filtres
    $animal_id = isset($_GET['animal_id']) && $_GET['animal_id'] !== "" ? $_GET['animal_id'] : null;
    $date_passage = isset($_GET['date_passage']) && $_GET['date_passage'] !== "" ? $_GET['date_passage'] : null;

    // Appliquer les filtres
    if ($animal_id && $date_passage) {
        $rapports = $compteRenduModel->getCompteRenduByAnimalIdAndDate($animal_id, $date_passage);
    } elseif ($animal_id) {
        $rapports = $compteRenduModel->getCompteRenduByAnimalId($animal_id);
    } elseif ($date_passage) {
        $rapports = $compteRenduModel->getCompteRenduByDate($date_passage);
    } else {
        $rapports = $compteRenduModel->getAllCompteRendu();
    }

    echo '<div class="container mt-4">
        <h3 class="mb-4">Filtrer les Comptes Rendus Vétérinaires</h3>

        <form method="GET" action="" class="p-4 border rounded shadow bg-light">
            <input type="hidden" name="tab" value="reports"> <!-- Garder l’onglet actif -->

            <div class="mb-3">
                <label for="animal_id" class="form-label">Animal :</label>
                <select name="animal_id" id="animal_id" class="form-select">
                    <option value="">Tous</option>';

                    // Récupérer la liste des animaux avec la connexion existante
                    $pdo = Database::getInstance()->getConnection();
                    $stmt = $pdo->query("SELECT id, name FROM animals");
                    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($animals as $animal) {
                        $selected = (isset($_GET['animal_id']) && $_GET['animal_id'] == $animal['id']) ? 'selected' : '';
                        echo "<option value='{$animal['id']}' $selected>{$animal['name']}</option>";
                    }

    echo '</select> </div>

            <div class="mb-3">
                <label for="date_passage" class="form-label">Date :</label>
                <input type="date" id="date_passage" name="date_passage" class="form-control" 
                    value="' . (isset($_GET['date_passage']) ? htmlspecialchars($_GET['date_passage']) : '') . '">
            </div>

            <button type="submit" class="btn btn-success w-100">Filtrer</button>
        </form>
      </div>';



        // Affichage des comptes rendus filtrés
        echo '<div class="table-responsive mt-5">';
        echo '<table class="table table-users">';
        echo '<thead>
                <tr>
                    <th>Animal</th>
                    <th>Date</th>
                    <th>Détails</th>
                </tr>
            </thead>';
        echo '<tbody>';

        foreach ($rapports as $rapport) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($rapport['animal_name']) . '</td>';
            echo '<td>' . htmlspecialchars($rapport['date_passage']) . '</td>';
            echo '<td>' . htmlspecialchars($rapport['detail']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
        echo '</div>';

}


function afficherHabitats() {
    $habitatModel = new Habitat();
    $habitats = $habitatModel->getAllHabitats();

    echo '<h3 class="text-center mt-4">Gestion des habitats</h3>';
    echo '<div class="row mt-4">';

    foreach ($habitats as $habitat) {
        $image_path = !empty($habitat['image_path']) ? 'uploads/' . basename($habitat['image_path']) : 'assets/default-habitat.jpg';

        echo '<div class="col-md-6 col-lg-4">';
        echo '<div class="card habitat-card mb-3">'; // Ajout d'une classe pour le style
        echo '<img src="../' . htmlspecialchars($image_path) . '" class="card-img-top" alt="' . htmlspecialchars($habitat['name']) . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title text-center">' . htmlspecialchars($habitat['name']) . '</h5>';
        echo '<p class="card-text">' . htmlspecialchars($habitat['description']) . '</p>';
        echo '<div class="btn-container">'; // Conteneur des boutons avec espacement
        echo '<a href="edit_habitat.php?id=' . $habitat['id'] . '" class="btn btn-success">Modifier</a>';
        echo '<a href="delete_habitat.php?id=' . $habitat['id'] . '" class="btn btn-danger">Supprimer</a>';
        echo '</div>';
        echo '</div></div></div>';
    }

    echo '</div>'; // Fin du row
}


function afficherAnimaux() {
    $animalModel = new Animal();
    $animaux = $animalModel->getAllAnimals();

    // Associer les habitats à des icônes
    $icons = [
        "Savane" => "🌾",
        "Jungle" => "🌴",
        "Marais" => "🌿",
    ];

    $habitats = [];
    foreach ($animaux as $animal) {
        $habitats[$animal['habitat_name']][] = $animal;
    }

    echo '<h3 class="text-center mt-4">Gestion des animaux</h3>';

    foreach ($habitats as $habitat_name => $animals) {
        $icon = isset($icons[$habitat_name]) ? $icons[$habitat_name] : "🏡";
        echo '<hr class="border border-success border-3 opacity-75 mt-3">'; // Ligne de séparation
        echo '<h3 class="mt-3 mb-4 text-center">' . $icon . ' ' . htmlspecialchars($habitat_name) . '</h3>';
        echo '<div class="row mt-2">';

        foreach ($animals as $animal) {
            $image_paths = json_decode($animal['image'], true);
            $first_image = isset($image_paths[0]) ? $image_paths[0] : 'assets/default.jpg';

            echo '<div class="col-md-6 col-lg-4 mb-4">';
            echo '<div class="card animal-card">'; // Ajout de la classe animal-card
            echo '<img src="../' . htmlspecialchars($first_image) . '" class="card-img-top" alt="Image de ' . htmlspecialchars($animal['name']) . '">';
            echo '<div class="card-body p-4">';
            echo '<h5 class="card-title text-center">' . htmlspecialchars($animal['name']) . '</h5>';
            echo '<p class="card-text">Espèce : ' . htmlspecialchars($animal['species']) . '</p>';
            echo '<p class="card-text">Habitat : ' . htmlspecialchars($habitat_name) . '</p>';
            echo '<div class="btn-container">'; // Conteneur pour les boutons avec espacement
            echo '<a href="edit_animal.php?id=' . $animal['id'] . '" class="btn btn-success">Modifier</a>';
            echo '<a href="delete_animal.php?id=' . $animal['id'] . '" class="btn btn-danger">Supprimer</a>';
            echo '</div>';
            echo '</div></div></div>';
        }

        echo '</div>'; // Fin de la row
    }
}

function afficherServices($afficherBoutons = true) {
    $serviceModel = new Service();
    $services = $serviceModel->getAllServices();

    echo '<h3 class="text-center mt-4">Nos Services</h3>';
    echo '<div class="row mt-4">';

    foreach ($services as $service) {
        $image_path = !empty($service['image_path']) ? $service['image_path'] : 'assets/default-service.jpg';

        echo '<div class="col-md-6 col-lg-4">';
        echo '<div class="card service-card mb-3">';
        echo '<img src="' . htmlspecialchars($image_path) . '" class="card-img-top" alt="' . htmlspecialchars($service['name']) . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title text-center">' . htmlspecialchars($service['name']) . '</h5>';
        echo '<p class="card-text">' . htmlspecialchars($service['description']) . '</p>';
        echo '<p class="card-text"><strong>Prix :</strong> ' . htmlspecialchars($service['prix']) . ' €</p>';

        // Afficher les boutons seulement si $afficherBoutons est true
        if ($afficherBoutons) {
            echo '<div class="btn-container">';
            echo '<a href="edit_service.php?id=' . $service['id'] . '" class="btn btn-success">Modifier</a>';
            echo '<a href="delete_service.php?id=' . $service['id'] . '" class="btn btn-danger">Supprimer</a>';
            echo '</div>';
        }

        echo '</div></div></div>';
    }

    echo '</div>';
}

function afficherHoraires() {
    $horaireModel = new Horaire();
    $horaires = $horaireModel->getAllHoraires();

    echo '<h3 class="text-center mt-4">Horaires d\'ouverture</h3>';
    echo '<div class="table-responsive">';
    echo '<table class="table table-horaires">';
    echo '<thead><tr>
            <th>Jour</th>
            <th>Ouverture</th>
            <th>Fermeture</th>
            <th>Actions</th>
          </tr></thead>';
    echo '<tbody>';

    $icons = [
        "Lundi" => "📅",
        "Mardi" => "📅",
        "Mercredi" => "📅",
        "Jeudi" => "📅",
        "Vendredi" => "📅",
        "Samedi" => "🎉",
        "Dimanche" => "⛱️"
    ];

    foreach ($horaires as $horaire) {
        $jour = htmlspecialchars($horaire['jour']);
        $icon = isset($icons[$jour]) ? $icons[$jour] : "📆";

        echo '<tr>';
        echo '<td>' . $icon . ' ' . $jour . '</td>';
        echo '<td>' . htmlspecialchars($horaire['heure_ouverture']) . '</td>';
        echo '<td>' . htmlspecialchars($horaire['heure_fermeture']) . '</td>';
        echo '<td>
                <a href="edit_horaire.php?id=' . $horaire['id'] . '" class="btn btn-success mb-2">Modifier</a>
                <a href="delete_horaire.php?id=' . $horaire['id'] . '" class="btn btn-danger">Supprimer</a>
              </td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
    echo '</div>';
}



function afficherDashboard() {
    echo "<h3>Dashboard - Consultations par Animal</h3>";
    echo "<p>📊 Graphique en cours de développement...</p>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add_habitat') {
            $name = $_POST['name'];
            $type = $_POST['type'];
            $location = $_POST['location'];
            $description = $_POST['description'];

            $habitatModel = new Habitat();
            $habitatModel->addHabitat($name, $type, $location, $description);

            header('Location: ../view/admin.php');
            exit();
        } 

        elseif ($action === 'add_animal') {
            $name = $_POST['name'];
            $species = $_POST['species'];
            $habitat = intval($_POST['habitat']); // Assurer que c'est un entier

            // Gestion de l'image
            $uploadDir = '../uploads/animals/'; // Dossier cible

            // Vérifier et créer le dossier s'il n'existe pas
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $image_json = json_encode([]); // Valeur par défaut

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image_name = time() . '_' . basename($_FILES['image']['name']); // Ajouter un timestamp
                $image_path = $uploadDir . $image_name;
                $relative_image_path = 'uploads/animals/' . $image_name; // Chemin relatif

                if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                    $image_json = json_encode([$relative_image_path]); // Stockage JSON
                }
            }

            $animalModel = new Animal();
            if ($animalModel->addAnimal($name, $species, $habitat, $image_json)) {
                echo "Animal ajouté avec succès !";
            } else {
                echo "Erreur lors de l'ajout de l'animal.";
            }

            header('Location: ../view/admin.php');
            exit();
        }
    }
}

