<?php
require_once __DIR__ . '/../config/Database.php';

$pdo = Database::getInstance()->getConnection();
$stmt = $pdo->query("SELECT * FROM avis WHERE statut = 'validé' ORDER BY date_creation DESC");
$avisList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Section avis -->
<section class="section-avis">
    <h2 class="mb-2 text-center mt-4">Les avis de nos visiteurs</h2>

    <div id="carousel-avis" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($avisList as $index => $avis): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="card text-start p-4">
                                    <h5 class="text-center"><strong><?= htmlspecialchars($avis['pseudo']) ?></strong></h5>
                                    <h6 class="fw-bold">Avis du <?= date('d/m/Y', strtotime($avis['date_creation'])) ?></h6>
                                    <p><?= nl2br(html_entity_decode($avis['commentaire'], ENT_QUOTES, 'UTF-8')) ?></p>
                                    <?php
                                        $note = (int) $avis['note'];
                                        for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $note ? '★' : '☆';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-avis" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel-avis" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</section>
