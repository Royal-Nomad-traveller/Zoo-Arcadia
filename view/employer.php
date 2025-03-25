<?php
$cssFile = '../public/design/admin.css';
$title = 'Employé - Tableau de bord';
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard'; // Valeur par défaut
session_start();
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

        <!-- Navigation entre les sections -->
        <ul class="nav nav-tabs" id="employerTabs">
            <li class="nav-item"><a class="nav-link <?php echo ($activeTab === 'dashboard') ? 'active' : ''; ?>" href="employer.php?tab=dashboard">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link <?php echo ($activeTab === 'reviews') ? 'active' : ''; ?>" href="employer.php?tab=reviews">Gérer les Avis</a></li>
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
            <div class="tab-pane fade <?php echo ($activeTab === 'reviews') ? 'show active' : ''; ?>" id="reviews">
                <h3>Gérer les Avis</h3>
                <p>Validez ou invalidez les avis des visiteurs.</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Avis</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ici tu devras récupérer les avis depuis la base de données -->
                    </tbody>
                </table>
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
