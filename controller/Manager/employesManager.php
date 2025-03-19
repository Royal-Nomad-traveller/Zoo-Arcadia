<?php
require_once __DIR__ . '/../../model/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_user') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash du mot de passe

    $userModel = new Users();
    $userModel->addUser($prenom, $nom, $role, $password);
}
?>

<div class="tab-pane fade show active" id="users">
    <?php afficherUtilisateurs(); ?>

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
            <label for="role" class="form-label">Rôle :</label>
            <select id="role" name="role" class="form-control" required>
                <option value="vétérinaire">Vétérinaire</option>
                <option value="employé">Employé</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe :</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter un utilisateur</button>
    </form>
</div>
