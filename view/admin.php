<!-- filepath: /Applications/XAMPP/xamppfiles/htdocs/view/admin.php -->
<?php
$cssFile = '../public/design/admin.css';
require_once '../controller/AdminController.php';
$name = 'José';
$title = 'Admin - Tableau de bord';
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard'; // Valeur par défaut
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
?>

<?php require_once '../includes/head.php'; ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">Bienvenue - <?= $name ?> </a>
            <button class="btn btn-danger" onclick="logout()">Déconnexion</button>
        </div>
    </nav>
    <main class="main-content">
        <div class="container mt-4">
            <h2 class="text-center">Espace Administrateur</h2>

            <!-- Navigation entre les sections -->
            <ul class="nav nav-tabs" id="adminTabs">
                <li class="nav-item"><a class="nav-link <?php echo ($activeTab === 'users') ? 'active' : ''; ?>" href="admin.php?tab=users">Utilisateurs</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($activeTab === 'reports') ? 'active' : ''; ?>" href="admin.php?tab=reports">Comptes Rendus</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($activeTab === 'habitats') ? 'active' : ''; ?>" href="admin.php?tab=habitats">Habitats</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($activeTab === 'animals') ? 'active' : ''; ?>" href="admin.php?tab=animals">Animaux</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($activeTab === 'services') ? 'active' : ''; ?>" href="admin.php?tab=services">Services</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($activeTab === 'dashboard') ? 'active' : ''; ?>" href="admin.php?tab=dashboard">Dashboard</a></li>
            </ul>


            
            <div class="tab-content mt-3">
                <!-- Section Utilisateurs -->
                <div class="tab-pane fade <?php echo ($activeTab === 'users') ? 'show active' : ''; ?>" id="users">
                    <?php require_once '../controller/Manager/employesManager.php'; ?>
                </div>

                <!-- Section Habitat -->
                <div class="tab-pane fade <?php echo ($activeTab === 'habitats') ? 'show active' : ''; ?>" id="habitats">
                    <?php 
                        require_once '../controller/Manager/habitatManager.php'; 
                        afficherHabitats();
                    ?>
                </div>

                <!-- Section Animaux -->
                <div class="tab-pane fade <?php echo ($activeTab === 'animals') ? 'show active' : ''; ?>" id="animals">
                    <?php 
                        require_once '../controller/Manager/animalManagement.php'; 
                        afficherAnimaux();
                    ?>
                </div>

                <!-- Section Comptes Rendus -->
                <div class="tab-pane fade <?php echo ($activeTab === 'reports') ? 'show active' : ''; ?>" id="reports">
                    
                </div>

                <!-- Section Services -->
                <div class="tab-pane fade <?php echo ($activeTab === 'services') ? 'show active' : ''; ?>" id="services">
                    <?php 
                        require_once '../controller/Manager/serviceManagement.php';
                    ?>
                </div>


                <!-- Section Dashboard -->
                <div class="tab-pane fade <?php echo ($activeTab === 'dashboard') ? 'show active' : ''; ?>" id="dashboard">
                    <?php afficherDashboard(); ?>
                </div>
            </div>
        </div>
    </main>
    
    <script>
        function logout() {
            window.location.href = "../controller/logout.php";
        }
    </script>
<?php 
    require_once '../includes/footer.php';
?>
  