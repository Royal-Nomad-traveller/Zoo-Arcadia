
<?php 
$title = "Page d'acceuil";
$cssFile = "public/design/acceuil.css";
?>


    <!-- Contenu principal -->

    <main class="main-content">
        <!-- Contenu principal de la page -->
        <section class="hero-section">
            <?php require_once 'includes/header.php'; ?>
            <div class="hero-content text-center">
                <div class="text-box">
                    <h1>Arcadia, un zoo engagé pour la planète depuis 1960</h1>
                </div>
            </div>
            <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Message envoyé avec succès !</div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-danger">Veuillez remplir tous les champs.</div>
<?php endif; ?>
        </section>
        
        <!-- Section habitats -->
        <section class="container text-center mt-4">
            <?php

            require_once 'model/Habitat.php';
            $habitat = new Habitat();
            $habitats = $habitat->getAllHabitats();
            ?>
            <div class="container mt-4">
                <h2 class="text-center mb-4 title-habitat">Liste des Habitats</h2>
                <div class="row">
                    <?php foreach ($habitats as $habitat): ?>
                        <div class="col-md-4 mb-4">
                            <div class="habitat"> <!-- Appliquer le style ici -->
                                <img src="<?php echo htmlspecialchars($habitat['image_path']); ?>" alt="<?php echo htmlspecialchars($habitat['name']); ?>">
                                <p><?php echo htmlspecialchars($habitat['name']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="view/animauxHabitats.php" class="btn btn-success btn-habitat mb-3">Voir tous les habitats</a>
            </div>
        </section>
        
        <section class="container text-center mt-4">
            <h2 class="mb-4">Nos Animaux</h2>

            <?php 
                require_once 'model/Animal.php';
                $animal = new Animal();
                $animaux = $animal->getLimitedAnimals(10);
            ?>

            <div id="animalCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php 
                    $active = "active"; // Ajoute la classe active seulement au premier élément
                    foreach ($animaux as $index => $animal) {
                        $imageArray = json_decode($animal['image'], true);
                        $imagePath = isset($imageArray[0]) ? $imageArray[0] : $animal['image']; // Prend la première image ou l'image brute
                    ?>

                    <div class="carousel-item <?= $active ?>">
                        <div class="card">
                            <div class="position-relative">
                                <img src="<?= htmlspecialchars($imagePath) ?>" class="card-img-top w-100 h-auto rounded animal-img" alt="<?= htmlspecialchars($animal['name']) ?>">
                                <div class="position-absolute w-100 text-center bg-dark bg-opacity-75 text-white py-2 rounded" style="bottom: 0;">
                                    <h5 class="mb-1"><?= htmlspecialchars($animal['name']) ?></h5>
                                    <p class="mb-0"><?= htmlspecialchars($animal['habitat_name']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php 
                        $active = ""; // Après le premier élément, on enlève la classe active
                    } 
                    ?>
                </div>

                <!-- Boutons de navigation -->
                <button class="carousel-control-prev" type="button" data-bs-target="#animalCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#animalCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>

            <!-- Bouton "Voir Plus" -->
            <a href="view/animauxHabitats.php" class="btn btn-success btn-animaux mt-3">Voir les animaux</a>
        </section>

        <!-- Section services -->
        <section class="container text-center mt-4">
            <?php
                require_once 'controller/AdminController.php';

                // Appeler la fonction en désactivant les boutons
                afficherServices(false);
            ?>
            <a href="view/services-visit.php" class="btn btn-success btn-habitat mt-3 mb-3">Nos services</a>

        </section>

        <!-- Section avis -->
        <section class="section-avis">
            <?php 
            require_once 'view/avis_valide.php';
            ?>
            <?php   
            // Modal pour laisser un avis
            require_once 'view/avis.php';
            ?>
            <?php if (isset($_GET['avis']) && $_GET['avis'] === 'envoye'): ?>
                <div class="alert alert-success text-center mt-3">
                    Merci pour votre avis ! Il sera affiché après validation.
                </div>
            <?php endif; ?>
        </section>
    </main>

<?php 
require_once 'includes/footer.php';
?>
