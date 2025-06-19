<?php
$cssFile = '../public/design/admin.css';
$title = 'Employé - Tableau de bord';
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard'; // Valeur par défaut
session_start();
$_SESSION['employe_id'] = $_SESSION['user_id'];

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employé') {
    header("Location: ../index.php");
    exit();
}
?>
<?php require_once '../includes/head.php'; ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="#">Bienvenue - <?= $_SESSION['nom'] ?> <?= $_SESSION['prenom'] ?></a>
        <a href="../controller/logout.php" class="btn btn-danger">Déconnexion</a>
    </div>
</nav>

<main class="main-content">
    <div class="container mt-4">
        <h2 class="text-center">Espace Employé</h2>
        <?php
if (isset($_GET['success']) || isset($_GET['error'])) {
    if ($activeTab === 'feeding') {
        if (isset($_GET['success'])) {
            echo '<div class="alert alert-success">Nourriture ajoutée avec succès.</div>';
        } elseif (isset($_GET['error'])) {
            echo '<div class="alert alert-danger">Erreur lors de l’ajout de la nourriture.</div>';
        }
    }

    if ($activeTab === 'avis') {
        echo '<div class="alert alert-success">L\'avis a bien été mis à jour.</div>';
    }
}
?>

        <!-- Navigation entre les sections -->
        <ul class="nav nav-tabs" id="employerTabs">
            <li class="nav-item"><a class="nav-link <?php echo ($activeTab === 'dashboard') ? 'active' : ''; ?>" href="employer.php?tab=dashboard">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link <?php echo ($activeTab === 'avis') ? 'active' : ''; ?>" href="employer.php?tab=avis">Gérer les Avis</a></li>
            <li class="nav-item"><a class="nav-link <?php echo ($activeTab === 'services') ? 'active' : ''; ?>" href="employer.php?tab=services">Gérer les Services</a></li>
            <li class="nav-item"><a class="nav-link <?php echo ($activeTab === 'feeding') ? 'active' : ''; ?>" href="employer.php?tab=feeding">Gestion Alimentation</a></li>
        </ul>

        <div class="tab-content mt-3">
            <!-- Dashboard -->
            <div class="tab-pane fade <?php echo ($activeTab === 'dashboard') ? 'show active' : ''; ?>" id="dashboard">
                <h3>Tableau de bord</h3>
                <p>Bienvenue dans votre espace employé. Utilisez les onglets ci-dessus pour gérer les avis, les services et l'alimentation des animaux.</p>
            </div>

            <!-- Gestion des Avis -->
            <div class="tab-pane fade <?php echo ($activeTab === 'avis') ? 'show active' : ''; ?>" id="avis">
                <h2 class="text-center">Validation des avis</h2>

                <?php
                    require_once '../controller/Manager/avisManager.php';
                    afficherAvis();
                ?>
                <?php echo '<hr class="border border-success border-3 opacity-75 mt-3">'; ?>
                <h2 class="text-center">Liste des avis validés</h2>
                <?php
                    afficherAvisValides();
                ?>
            </div>

            <!-- Gestion des Services -->
            <div class="tab-pane fade <?php echo ($activeTab === 'services') ? 'show active' : ''; ?>" id="services">
                <?php 
                    require_once '../controller/Manager/serviceManagement.php';
                ?>
            </div>

            <!-- Gestion de l'Alimentation des Animaux -->
            <div class="tab-pane fade <?php echo ($activeTab === 'feeding') ? 'show active' : ''; ?>" id="feeding">
                <?php 
                    require_once '../controller/Manager/nourritureManagement.php';
                ?>
            </div>
        </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
