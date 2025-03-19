
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
    </main>

<?php 
require_once 'includes/footer.php';
?>
