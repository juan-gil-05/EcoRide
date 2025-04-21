<?php
// HEADER
use App\Security\Security;

require_once './Templates/header.php';
?>
<!-- Section avec tous les avis -->
<section class="container mb-5">
    <!-- Titre de la page -->
    <div class="mt-5">
        <h2 class="subtitle-text text-center text-white text-capitalize fs-4">Tous les avis</h2>
    </div>
    <!-- La list des avis -->
    <ul class="mt-4 ps-0">
        <?php foreach ($allAvisAndNotes as $avisAndNote) { ?>
            <li class="avis-list small-text mb-4">
                <!-- Le pseudo du passager et du chauffeur -->
                <div class="users-name">
                    <!-- Pseudo du passager -->
                    <div class="d-flex gap-2">
                        <p class="fw-bold">Passager: </p>
                        <span class="text-capitalize"><?= $passagerName[$avisAndNote['avis_id']]['pseudo'] ?></span>
                    </div>
                    <!-- Pseudo du chauffeur -->
                    <div class="d-flex gap-2">
                        <p class="fw-bold">Conducteur: </p>
                        <span class="text-capitalize"><?= $driverName[$avisAndNote['avis_id']]['pseudo'] ?></span>
                    </div>
                </div>
                <!-- Le titre de l'avis et la note du chauffeur -->
                <div class="avis-title-note mt-4">
                    <p class="fw-medium"><?= $avisAndNote['titre'] ?></p>
                    <!-- Étoiles pour noter le chauffeur -->
                    <div class="note-stars">
                        <!-- Pour générer les étoiles d'un facon dynamique -->
                        <?php
                        $note = (int)$avisAndNote['note'];
                        for ($i = 1; $i <= 5; $i++) {
                            $active = $i <= $note ? 'active-star' : '';
                            echo "<i class='bi bi-star-fill star $active'></i>";
                        }
                        ?>
                    </div>
                </div>
                <!-- La déscription de l'avis -->
                <div class="avis-description">
                    <p>
                        <?= $avisAndNote['avis'] ?>
                    </p>
                </div>
                <!-- Les boutons d'action : (Valider ou refuser) -->
                <div class="avis-btn mt-4">
                    <button class="btn btn-danger secondary-btn text-white small-text">
                        Refuser
                    </button>
                    <button class="btn btn-primary secondary-btn text-white small-text">
                        Valider
                    </button>
                </div>
            </li>
        <?php } ?>
    </ul>
</section>

<?php
// FOOTER
require_once './Templates/footer.php';
?>