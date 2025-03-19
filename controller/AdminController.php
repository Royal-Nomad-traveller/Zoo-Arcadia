<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/Database.php';
require_once '../model/User.php';
require_once '../model/Services.php';
require_once '../model/Animal.php';
require_once '../model/Report.php';
require_once '../model/Habitat.php';

function afficherUtilisateurs() {
    $userModel = new Users();
    $users = $userModel->getAllUsers();

    echo '<h3>Gestion des utilisateurs</h3>';
    echo '<table class="table table-bordered table-striped-columns table-success table-custom"><tr><th>Prénom</th><th>Nom</th><th>Rôle</th><th>Actions</th></tr>';
    foreach ($users as $user) {
        echo "<tr>
                <td>{$user['prenom']}</td>
                <td>{$user['nom']}</td>
                <td>{$user['role']}</td>
                <td><button class='btn btn-danger'>Supprimer</button></td>
              </tr>";
    }
    echo '</table>';
}


function afficherServices() {
    $serviceModel = new Service();
    $services = $serviceModel->getAllServices();

    echo '<h3>Gestion des services</h3>';
    echo '<ul>';
    foreach ($services as $service) {
        echo "<li>{$service['nom']} - <button class='btn btn-warning'>Modifier</button> <button class='btn btn-danger'>Supprimer</button></li>";
    }
    echo '</ul>';
}

function afficherAnimaux() {
    $animalModel = new Animal();
    $animaux = $animalModel->getAllAnimals();

    echo '<h3 class="text-center mt-4">Gestion des animaux</h3>';
    echo '<div class="row mt-4">';
    foreach ($animaux as $animal) {
        $image_paths = json_decode($animal['image'], true); // Décoder JSON
        $first_image = isset($image_paths[0]) ? $image_paths[0] : 'assets/default.jpg'; // Image par défaut si vide

        echo '<div class="col-md-4">';
        echo '<div class="card">';
        echo '<img src="../' . htmlspecialchars($first_image) . '" class="card-img-top" alt="Image de ' . htmlspecialchars($animal['name']) . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title text-center">' . htmlspecialchars($animal['name']) . '</h5>';
        echo '<p class="card-text">Espèce : ' . htmlspecialchars($animal['species']) . '</p>';
        echo '<p class="card-text">Habitat : ' . htmlspecialchars($animal['habitat_id']) . '</p>';
        echo '<div class="d-flex justify-content-around">';
        echo '<a href="edit_animal.php?id=' . $animal['id'] . '" class="btn btn-success">Modifier</a>';
        echo '<a href="delete_animal.php?id=' . $animal['id'] . '" class="btn btn-danger">Supprimer</a>';
        echo '</div></div></div></div>';
    }
    echo '</div>';
}


function afficherHabitats() {
    $habitatModel = new Habitat();
    $habitats = $habitatModel->getAllHabitats();

    echo '<h3>Gestion des habitats</h3>';
    echo '<ul>';
    foreach ($habitats as $habitat) {
        echo "<li>{$habitat['name']} - <button class='btn btn-warning'>Modifier</button> <button class='btn btn-danger'>Supprimer</button></li>";
    }
    echo '</ul>';
}

function afficherComptesRendus() {
    $reportModel = new Report();
    $rapports = $reportModel->getAllReports();

    echo '<h3>Comptes Rendus Vétérinaires</h3>';
    echo '<ul>';
    foreach ($rapports as $rapport) {
        echo "<li>{$rapport['animal_nom']} ({$rapport['date']}) - {$rapport['contenu']}</li>";
    }
    echo '</ul>';
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

