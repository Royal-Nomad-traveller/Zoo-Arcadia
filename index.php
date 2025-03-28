
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
                <button class="btn btn-success btn-habitat mb-3">Voir tous les habitats</button>
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
            <a href="animaux.php" class="btn btn-success btn-animaux mt-3">Voir plus</a>
        </section>


    </main>

<?php 
require_once 'includes/footer.php';
?>
