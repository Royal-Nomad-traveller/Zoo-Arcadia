<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<pre>';
    print_r($_POST);
    print_r($_SESSION);
    echo '</pre>';
}

require_once __DIR__ . '/../../model/Nourriture.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['employe_id'])) {
        die("Erreur : Employé non authentifié.");
    }

    $employe_id = $_SESSION['employe_id'];
    $animal_id = $_POST['animal_id'];
    $food = $_POST['food'];
    $quantity = $_POST['quantity'];
    $date_time = $_POST['date_time'];

    $nourritureManager = new Nourriture();
    if ($nourritureManager->ajouterNourriture($employe_id, $animal_id, $food, $quantity, $date_time)) {
    header("Location: employer.php?tab=feeding&success=1#feeding");
    exit();

}

}
?>
<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Nourriture ajoutée avec succès.</div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">Erreur lors de l’ajout de la nourriture.</div>
<?php endif; ?>


<?php
require_once __DIR__ . '/../../model/Animal.php';

$animalManager = new Animal();
$animaux = $animalManager->getAllAnimals();
?>
<div class="container mt-5 mb-5">
    <h3 class="text-center mt-2 mb-3">Gestion Alimentation</h3>
    <form class="p-4 border rounded shadow" action="employer.php?tab=feeding" method="POST">
        <div class="mb-3">
            <label class="form-label" for="animal">Choisir un animal :</label>
            <select name="animal_id" class="form-control" required>
                <?php foreach ($animaux as $animal) : ?>
                    <option value="<?= htmlspecialchars($animal['id']) ?>">
                        <?= htmlspecialchars($animal['name']) ?> (<?= htmlspecialchars($animal['habitat_name']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="food">Type de nourriture :</label>
            <input type="text" name="food" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label" for="quantity">Quantité (kg) :</label>
            <input type="number" name="quantity" step="0.1" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label" for="date_time">Date & Heure :</label>
            <input class="form-control" type="datetime-local" name="date_time" data-mdb-inline="true" required>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>

<?php
$nourritureManager = new Nourriture();
$nourritures = $nourritureManager->afficherNourriture();
$habitats = [];
foreach ($nourritures as $nourriture) {
    $habitats[$nourriture['habitat_name']][] = $nourriture;
}
?>

<h3 class="text-center mt-4 fw-bold">Gestion de l'Alimentation</h3>
<?php foreach ($habitats as $habitatName => $animals) : 
    echo '<hr class="border border-success border-3 opacity-75 mt-3">';
    ?>
    <h4 class="text-center mt-4 fst-italic text-uppercase"><?= htmlspecialchars($habitatName) ?></h4>
    <div class="table-responsive mt-4">
        <table class="table table-horaires">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Animal</th>
                    <th>Espèce</th>
                    <th>Nourriture</th>
                    <th>Quantité</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($animals as $nourriture) : ?>
                <tr>
                    <td>
                        <?php 
                        // Gérer le chemin de l'image pour chaque animal
                        $imagePath = !empty($nourriture['image']) ? stripslashes(trim($nourriture['image'], '[]"')) : null;
                        ?>
                        <?php if (!empty($imagePath)) : ?>
                            <img class="img rounded" src="/<?= htmlspecialchars($imagePath) ?>" width="100" height="auto" alt="<?= htmlspecialchars($nourriture['animal_name']) ?>">
                        <?php else : ?>
                            <span>Aucune image</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($nourriture['animal_name']) ?></td>
                    <td><?= htmlspecialchars($nourriture['species']) ?></td>
                    <td><?= htmlspecialchars($nourriture['food']) ?></td>
                    <td><?= htmlspecialchars($nourriture['quantity']) ?> kg</td>
                    <td><?= htmlspecialchars($nourriture['date_time']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>


