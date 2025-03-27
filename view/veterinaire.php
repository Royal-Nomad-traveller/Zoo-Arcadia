<!-- Un vétérinaire passe quotidiennement dans le zoo, ainsi, depuis son espace, il remplira les
comptes rendus par animaux. Le détail est disponible en US 4
Il peut en plus, mettre un commentaire sur les habitats afin qu’il/elle puisse donner son avis
son état et s’il faut l’améliorer ou non.
Le vétérinaire voit également sur son espace et par animal, tout ce que l’animal a pu manger
via la saisie de l’employé sur son espace. -->

<!-- Le vétérinaire, passe régulièrement et saisie des informations depuis son espace sur un animal
donné en mentionnant :
 L'état de l’animal
 La nourriture proposée
 Le grammage de la nourriture
 Date de passage
 Détail de l’état de l’animal (information facultative)
Il est très important pour José de mentionner l’état de l’animal sur cette page.
Enfin, au clic sur un animal de l’habitat, le visiteur doit pouvoir visualiser le détail de l’animal,
ce qui inclue ses propriétés mais également l’avis du vétérinaire. -->

<?php

$title = "Vétérinaire";
$cssFile = "../public/design/admin.css";
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard'; // Valeur par défaut
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'vétérinaire') {
    header("Location: ../index.php");
    exit();
}
?>
<!-- Contenu principal -->
<?php require_once '../includes/head.php'; ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="#">Bienvenue - <?= $_SESSION['nom'] ?> <?= $_SESSION['prenom'] ?></a>
        <a href="../controller/logout.php" class="btn btn-danger">Déconnexion</a>
    </div>
</nav>

<div class="main-content">
    <div class="container mt-4">
        <h2 class="text-center">Espace Vétérinaire</h2>

        <!-- Navigation entre les sections -->
        <ul class="nav nav-tabs" id="veterinaireTabs">
            <li class="nav-item"><a class="nav-link <?php echo ($activeTab === 'tab-bord') ? 'active' : ''; ?>" href="veterinaire.php?tab=tab-bord">Tableau de bord</a></li>
            <li class="nav-item"><a class="nav-link <?php echo ($activeTab === 'compte-rendu') ? 'active' : ''; ?>" href="veterinaire.php?tab=compte-rendu">Compte rendu</a></li>
            <li class="nav-item"><a class="nav-link <?php echo ($activeTab === 'commentaire') ? 'active' : ''; ?>" href="veterinaire.php?tab=commentaire">Commentaire</a></li>
        </ul>

        <div class="tab-content mt-3">
            <!-- Section Tableau de bord -->
            <div class="tab-pane fade <?php echo ($activeTab === 'tab-bord') ? 'show active' : ''; ?>" id="tab-bord">
                <?php
                require_once '../controller/veterinaireController.php';
                afficherNourriture();
                ?>
            </div>

            <!-- Section Compte Rendu -->
            <div class="tab-pane fade <?php echo ($activeTab === 'compte-rendu') ? 'show active' : ''; ?>" id="compte-rendu">
               <?php 
               require_once '../controller/Manager/compteRenduManagement.php'; 
               afficherComptesRendus();
               ?>
            </div>

            <!-- Section Commentaire -->
            <div class="tab-pane fade <?php echo ($activeTab === 'commentaire') ? 'show active' : ''; ?>" id="commentaire">
                <?php
                require_once '../controller/Manager/commentaireManagement.php';
                afficherCommentaire();
                ?>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>