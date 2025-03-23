<?php
// HEADER
use App\Security\Security;

require_once './Templates/header.php';
?>

<!-- Main -->
<!-- Section avec le hero, et le bouton pour créer un nouveau covoiturage si l'user est chauffer -->
<section class="text-center mes-covoiturages-hero">
    <!-- Contient le titre et le bouton -->
    <div class="container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <!-- titre -->
                <h1 class="headline-text text-white">Mes covoiturages</h1>
                <!-- Si l'utilsateur est connecté et a le rôle du chauffeur, alors, 
                on affiche le bouton vers la page pour saisir un nouveau covoiturage -->
                <?php if (Security::isLogged() && Security::isChauffeur()) { ?>
                    <a href="?controller=covoiturages&action=createCovoiturage"
                        class="btn btn-light mt-3 text-black content-text fw-medium">Créer un nouveau covoiturage</a>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<!-- Pour afficher les message de succès quand l'user participe dans un covoiturage, ou annule sa participation -->
<?php if (!empty($_SESSION['successParticipation'])) { ?>
    <div class="alert alert-success alert-dismissible fade show content-text container" role="alert">
        Votre participation au covoiturage a été enregistrée avec succès !
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
    // Après d'avoir afficher le message, on supprime la session
    unset($_SESSION['successParticipation']);
} ?>

<!-- Section avec la liste des covoiturages auxquels l'user participe, et auxquels l'user conduit -->
<section class="container mt-4 mb-5">
    <!-- Les covoiturages auxquels l'user participe -->
    <div class="accordion mb-3" id="preferenceAccordion">
        <div class="accordion-item">
            <!-- Header -->
            <h2 class="accordion-header">
                <button class="accordion-button collapsed content-text fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseParticipe" aria-expanded="false" aria-controls="collapseParticipe">
                    Mes covoiturages en tant que passager
                </button>
            </h2>
            <!-- body -->
            <div id="collapseParticipe" class="accordion-collapse collapse" data-bs-parent="#preferenceAccordion">
                <div class="accordion-body">
                    <?php if ($covoiturageaAsPassager) { ?>
                        <!-- Liste avec les covoiturages -->
                        <ul>
                            <?php foreach ($covoiturageaAsPassager as $covoiturage) { ?>
                                <li class="content-text">
                                    <!-- Le jour et le mois du covoiturage -->
                                    <div class="fw-medium covoiturage-day-month mb-4">
                                        <p class="mb-0 text-center"><?= $dayName[$covoiturage['id']] . ", " . $dayNumber[$covoiturage['id']] . " " . $monthName[$covoiturage['id']] ?></p>
                                    </div>
                                    <!-- Les heures et adresses de départ et d'arrivée-->
                                    <div class="covoiturage-info-list">
                                        <!-- Les heures -->
                                        <div class="covoiturage-date-time">
                                            <p class="fw-semibold">Départ</p>
                                            <p><?= $covoiturage['adresse_depart'] ?></p>
                                            <p><?= substr($covoiturage['date_heure_depart'], 11, 5) ?></p>
                                        </div>
                                        <i class="bi bi-arrow-right"></i>
                                        <!-- Les adresses -->
                                        <div class="covoiturage-date-time">
                                            <p class="fw-semibold">Arrivée</p>
                                            <p><?= $covoiturage['adresse_arrivee'] ?></p>
                                            <p><?= substr($covoiturage['date_heure_arrivee'], 11, 5) ?></p>
                                        </div>
                                    </div>
                                    <!-- Bouton pour voir plus en détail le covoiturage et pour le quitter -->
                                    <div class="detail-btn-div content-text mt-4 d-flex justify-content-evenly">
                                        <!-- Formulaire pour quitter le covoiturage -->
                                        <form method="post" class="mb-0">
                                            <!-- input invisible pour envoyer l'id du covoiturage, de l'user dans le formulaire et le prix-->
                                            <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?>">
                                            <input type="hidden" name="covoiturage_id" value="<?= $covoiturage['id'] ?>">
                                            <input type="hidden" name="covoiturage_price" value="<?= $covoiturage['prix'] ?>">
                                            <!-- Bouton pour envoyer le formulaire -->
                                            <button type="submit" name="quitCovoiturage" class="btn btn-danger secondary-btn text-light">Quitter</button>
                                        </form>
                                        <!-- Bouton pour voir les détails du covoiturage -->
                                        <a href="?controller=covoiturages&action=showOne&id=<?= $covoiturageEncryptId[$covoiturage['id']] ?>" class="btn btn-warning secondary-btn">Détail</a>
                                    </div>
                                </li>

                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p class="mb-0 fw-medium">Aucun covoiturage pour le moment</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Si l'utilisateur est chauffeur, alors on affiche les covoiturages auxquels il conduit -->
    <?php if (Security::isChauffeur()) { ?>
        <!-- Les covoiturages auxquels l'user conduit -->
        <div class="accordion" id="carAccordion">
            <div class="accordion-item">
                <!-- Header -->
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed content-text fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDrive" aria-expanded="false" aria-controls="collapseDrive">
                        Mes covoiturages en tant que chauffeur
                    </button>
                </h2>
                <!-- Body -->
                <div id="collapseDrive" class="accordion-collapse collapse" data-bs-parent="#carAccordion">
                    <div class="accordion-body">
                        <!-- Liste avec les covoiturages -->
                        <ul>
                            <?php foreach ($covoituragesAsDriver as $covoiturage) { ?>
                                <li class="content-text">
                                    <!-- Le jour et le mois du covoiturage -->
                                    <div class="fw-medium covoiturage-day-month mb-4">
                                        <p class="mb-0 text-center"><?= $dayName[$covoiturage['id']] . ", " . $dayNumber[$covoiturage['id']] . " " . $monthName[$covoiturage['id']] ?></p>
                                    </div>
                                    <!-- Les heures et adresses de départ et d'arrivée-->
                                    <div class="covoiturage-info-list">
                                        <!-- Les heures -->
                                        <div class="covoiturage-date-time">
                                            <p class="fw-semibold">Départ</p>
                                            <p><?= $covoiturage['adresse_depart'] ?></p>
                                            <p><?= substr($covoiturage['date_heure_depart'], 11, 5) ?></p>
                                        </div>
                                        <i class="bi bi-arrow-right"></i>
                                        <!-- Les adresses -->
                                        <div class="covoiturage-date-time">
                                            <p class="fw-semibold">Arrivée</p>
                                            <p><?= $covoiturage['adresse_arrivee'] ?></p>
                                            <p><?= substr($covoiturage['date_heure_arrivee'], 11, 5) ?></p>
                                        </div>
                                    </div>
                                    <!-- Bouton pour voir plus en détail le covoiturage -->
                                    <div class="detail-btn-div content-text mt-4 d-flex justify-content-center">
                                        <a href="?controller=covoiturages&action=showOne&id=<?= $covoiturageEncryptId[$covoiturage['id']] ?>" class="btn btn-warning detail-btn secondary-btn">Détail</a>
                                    </div>
                                </li>

                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</section>


<?php
// FOOTER
require_once './Templates/footer.php';
?>