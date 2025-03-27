<?php 
require_once '../config/Database.php';
require_once __DIR__ . '/../model/Nourriture.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

function afficherComptesRendus() {
    $compteRendu = new CompteRendu();
    $comptesRendus = $compteRendu->getAllCompteRendu();

    // Regrouper les comptes rendus par habitat
    $groupedByHabitat = [];
    foreach ($comptesRendus as $cr) {
        $habitat = $cr['habitat_name']; // Nom de l'habitat
        if (!isset($groupedByHabitat[$habitat])) {
            $groupedByHabitat[$habitat] = [];
        }
        $groupedByHabitat[$habitat][] = $cr;
    }

    echo '<h3 class="text-center mt-4 mb-3">Gestion des comptes rendus</h3>';

    foreach ($groupedByHabitat as $habitatName => $comptes) {
        echo '<hr class="border border-primary border-3 opacity-75 mt-3">';
        echo '<h4 class="text-center mt-4 fst-italic text-uppercase">' . htmlspecialchars($habitatName) . '</h4>';
        echo '<div class="table-responsive">';
        echo '<table class="table table-users">';
        echo '<thead>
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>État</th>
                    <th>Nourriture</th>
                    <th>Grammage</th>
                    <th>Date de passage</th>
                    <th>Détail</th>
                    <th>Actions</th>
                </tr>
              </thead>';
        echo '<tbody>';

        foreach ($comptes as $compteRendu) {
            echo '<tr>';
            echo '<td>';
            $imagePath = !empty($compteRendu['image']) ? stripslashes(trim($compteRendu['image'], '[]"')) : null;
            if (!empty($imagePath)) {
                echo '<img class="img rounded" src="/' . htmlspecialchars($imagePath) . '" width="110" height="auto" alt="' . htmlspecialchars($compteRendu['animal_name']) . '">';
            } else {
                echo '<span>Aucune image</span>';
            }
            echo '</td>';
            echo '<td>' . htmlspecialchars($compteRendu['animal_name']) . '</td>';
            echo '<td>' . htmlspecialchars($compteRendu['etat']) . '</td>';
            echo '<td>' . htmlspecialchars($compteRendu['nourriture']) . '</td>';
            echo '<td>' . htmlspecialchars($compteRendu['grammage']) . ' g</td>';
            echo '<td>' . htmlspecialchars($compteRendu['date_passage']) . '</td>';
            echo '<td>' . htmlspecialchars($compteRendu['detail']) . '</td>';
            echo '<td>
                    <a href="edit_compterendu.php?id=' . $compteRendu['id'] . '" class="btn btn-success mb-2">Modifier</a>
                    <a href="delete_compterendu.php?id=' . $compteRendu['id'] . '" class="btn btn-danger">Supprimer</a>
                  </td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
        echo '</div>';
    }
}


function afficherCommentaire() {
    $commentaire = new Commentaire();
    $commentaires = $commentaire->getAllCommentaires();

    echo '<h3 class="text-center mt-4 mb-3">Gestion des Commentaires</h3>';
    echo '<div class="table-responsive">';
    echo '<table class="table table-users">';
    echo '<thead>
            <tr>
                <th>Habitat</th>
                <th>Vétérinaire</th>
                <th>Commentaire</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
          </thead>';
    echo '<tbody>';

    foreach ($commentaires as $commentaire) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($commentaire['habitat_name']) . '</td>';
        echo '<td>' . htmlspecialchars($commentaire['veterinaire']) . '</td>';
        echo '<td>' . nl2br(htmlspecialchars($commentaire['commentaire'])) . '</td>';
        echo '<td>' . htmlspecialchars($commentaire['date_commentaire']) . '</td>';
        echo '<td>
                <a href="edit_commentaire.php?id=' . $commentaire['id'] . '" class="btn btn-success mb-2">Modifier</a>
                <a href="delete_commentaire.php?id=' . $commentaire['id'] . '" class="btn btn-danger">Supprimer</a>
              </td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
    echo '</div>';
}

function afficherNourriture() {
    $nourriture = new Nourriture();
    $nourritures = $nourriture->getAnimalsWithFood();

    // Regrouper la nourriture par habitat
    $groupedByHabitat = [];
    foreach ($nourritures as $n) {
        $habitat = $n['habitat_name']; // Nom de l'habitat
        if (!isset($groupedByHabitat[$habitat])) {
            $groupedByHabitat[$habitat] = [];
        }
        $groupedByHabitat[$habitat][] = $n;
    }

    echo '<h3 class="text-center mt-4 fw-bold">L\'Alimentation saisi par les employers</h3>';

    foreach ($groupedByHabitat as $habitatName => $animals) {
        echo '<hr class="border border-success border-3 opacity-75 mt-3">';
        echo '<h4 class="text-center mt-4 fst-italic text-uppercase">' . htmlspecialchars($habitatName) . '</h4>';
        echo '<div class="table-responsive mt-4">';
        echo '<table class="table table-horaires">';
        echo '<thead>
                <tr>
                    <th>Image</th>
                    <th>Animal</th>
                    <th>Espèce</th>
                    <th>Nourriture</th>
                    <th>Quantité</th>
                    <th>Date</th>
                </tr>
              </thead>';
        echo '<tbody>';

        foreach ($animals as $nourriture) {
            echo '<tr>';
            echo '<td>';
            $imagePath = !empty($nourriture['image']) ? stripslashes(trim($nourriture['image'], '[]"')) : null;
            if (!empty($imagePath)) {
                echo '<img class="img rounded" src="/' . htmlspecialchars($imagePath) . '" width="100" height="auto" alt="' . htmlspecialchars($nourriture['animal_name']) . '">';
            } else {
                echo '<span>Aucune image</span>';
            }
            echo '</td>';
            echo '<td>' . htmlspecialchars($nourriture['animal_name']) . '</td>';
            echo '<td>' . htmlspecialchars($nourriture['species']) . '</td>';
            echo '<td>' . htmlspecialchars($nourriture['food']) . '</td>';
            echo '<td>' . htmlspecialchars($nourriture['quantity']) . ' kg</td>';
            echo '<td>' . htmlspecialchars($nourriture['date_time']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
        echo '</div>';
    }
}
