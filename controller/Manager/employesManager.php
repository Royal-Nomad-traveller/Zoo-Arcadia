<?php
require_once __DIR__ . '/../../model/Employes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_user') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email']; // Ajout de l'email (il manquait)
    $role = $_POST['role'];
    $password = $_POST['password']; 

    $employeModel = new Employes();

    // Vérifier si l'email existe déjà avant d'ajouter
    if ($employeModel->getEmployeByEmail($email)) {
        echo "Erreur : cet email est déjà utilisé.";
        exit;
    }

    // Ajouter l'employé
    $result = $employeModel->addEmploye($prenom, $nom, $email, $role, $password);

    

    if ($result) {
        echo "Employé ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'employé.";
    }
}
?>


<div class="tab-pane fade show active" id="users">

    <h3>Ajouter un utilisateur</h3>
    <form method="POST" action="admin.php" class="p-4 border rounded shadow mb-4">
        <input type="hidden" name="action" value="add_user">

        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom :</label>
            <input type="text" id="prenom" name="prenom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="nom" class="form-label">Nom :</label>
            <input type="text" id="nom" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email :</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe :</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rôle :</label>
            <select id="role" name="role" class="form-control" required>
                <option value="vétérinaire">Vétérinaire</option>
                <option value="employé">Employé</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Ajouter un utilisateur</button>
    </form>

    <?php afficherUtilisateurs(); ?>
</div>
