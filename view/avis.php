<!-- Bouton pour ouvrir le modal -->
<div class="mt-4 text-center">
  <button class="btn btn-success btn-avis" data-bs-toggle="modal" data-bs-target="#avisModal">
    Laisser un avis
  </button>
</div>

<!-- Modal avis -->
<div class="modal fade" id="avisModal" tabindex="-1" aria-labelledby="avisModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content custom-modal">
      <div class="modal-header">
        <h5 class="modal-title" id="avisModalLabel">Laisser un avis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="controller/traiter_avis.php">
        <div class="modal-body">
          <!-- Pseudo -->
          <div class="mb-3">
            <label for="pseudo" class="form-label">Votre pseudo</label>
            <input type="text" class="form-control" name="pseudo" placeholder="Entrez votre pseudo" required>
          </div>
          <!-- Avis -->
          <div class="mb-3">
            <label for="commentaire" class="form-label">Votre avis</label>
            <textarea class="form-control" name="commentaire" rows="4" placeholder="Partagez votre expérience..." required></textarea>
          </div>
            <!-- Note -->
            <div class="mb-3">
                <label for="note" class="form-label d-block">Votre note</label>
                <div class="rating">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                    <input type="radio" id="star<?= $i ?>" name="note" value="<?= $i ?>" required>
                    <label for="star<?= $i ?>"><i class="bi bi-star-fill"></i></label>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        <div class="modal-footer text-center">
          <button type="submit" class="btn btn-success">Soumettre</button>
        </div>
      </form>
    </div>
  </div>
</div>
