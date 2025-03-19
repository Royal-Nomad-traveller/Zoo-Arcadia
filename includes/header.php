    <?php require_once 'head.php'; ?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.html">
                <img src="public/images/logo.png" class="logo" alt="Logo Arcadia">
            </a>
            <button class="btn btn-success" id="btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
                Connexion
            </button>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="habitat.php">Habitats</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#contactModal">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Modal de connexion (reste inchangé) -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Connectez-vous</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Réservé aux administrateurs, employés et vétérinaires.</p>
                <?php if (isset($_SESSION['error'])) : ?>
                    <p class="text-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
                <?php endif; ?>
                <form id="loginForm" action="../controller/AuthController.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Entrez votre email professionnel" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Entrez votre mot de passe" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100" id="loginUsers">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</div>




