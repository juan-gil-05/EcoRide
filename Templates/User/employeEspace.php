<?php
// HEADER
use App\Security\Security;

require_once './Templates/header.php';
?>
<!-- Navbar pour afficher les avis ou les covoiturages signalés -->
<nav class="navbar bg-body-primary employe-navbar content-text fw-bold">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <!-- Avis à valider -->
            <li class="nav-item" id="showAvis">
                <a class="nav-link active" href="#" id="showAvisBtn">Avis à valider</a>
            </li>
            <!-- Trajets signalés -->
            <li class="nav-item" id="showComments">
                <a class="nav-link" href="#" id="showCommentsBtn">Trajets signalés</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Section avec tous les avis -->
<section class="container mb-5 mt-3" id="avisSection">
    <!-- Titre de la page -->
    <div class="">
        <h2 class="subtitle-text text-center text-white text-capitalize-">Tous les avis</h2>
    </div>
    <!-- La list des avis -->
    <ul class="mt-4 ps-0 avis-list-container">
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
                <div class="mt-4">
                    <form method="post" class="avis-btn">
                        <!-- Input chaché pour envoyer l'id de l'avis dans le form -->
                        <input type="hidden" name="avis_id" value="<?= $avisAndNote['avis_id'] ?>">
                        <!-- Refuser -->
                        <button class="btn btn-danger secondary-btn text-white small-text"
                            name="avisRefused"
                            value="0"
                            type="submit">
                            Refuser
                        </button>
                        <!-- Valider -->
                        <button class="btn btn-primary secondary-btn text-white small-text"
                            name="avisValidated"
                            value="1"
                            type="submit"
                            <?= ($avisAndNote['statut'] == 1) ? 'disabled' : '' ?>>
                            <?= ($avisAndNote['statut'] == 1) ? 'Déjà validé' : 'Valider' ?>
                        </button>
                    </form>
                </div>
            </li>
        <?php } ?>
    </ul>
</section>

<!-- Section avec les covoiturages signalés -->
<section class="container mb-5 mt-3 hidden" id="commentsSection">   
</section>

<?php
// FOOTER
require_once './Templates/footer.php';
?>