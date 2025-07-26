<?php

// HEADER
use App\Security\Security;

require_once  BASE_PATH . '/Templates/header.php';
?>

<!-- Section avec l'information de l'utilisateur -->
<section class="profil-section">
    <!-- Photo de l'utilisateur -->
    <div class="">
        <?php
        $defaultImage = "/Assets/Img_page-vue-covoiturages/driver-default.png";
        $driverImagePath = (!empty($photoUniqueId)) ? "/Uploads/User/" . $photoUniqueId : $defaultImage;
        ?>
        <img src="<?= $driverImagePath ?>"
            alt="Photo de l'utilisateur" class="user-image">
    </div>
    <!-- Le pseudo, le mail et le nombre des crédits de l'utilisateur -->
    <div class="d-flex content-text">
        <ul class="mb-0 d-flex flex-column gap-2">
            <li> <span class="fw-medium">Pseudo = </span><?= $pseudo ?></li>
            <li><span class="fw-medium">E-mail = </span><?= $mail ?></li>
            <li><span class="fw-medium">Vos crédits = </span><?= $credits ?></li>
        </ul>
    </div>
</section>

<!-- Section pour les chauffeurs avec les préférences et les voitures -->
<?php if (Security::isChauffeur()) { ?>
    <section class="driver-info-profil container content-text pt-2">
        <!-- Les préférences -->
        <div class="accordion" id="preferenceAccordion">
            <div class="accordion-item">
                <!-- Header -->
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed content-text fw-semibold text-capitalize"
                        type="button" data-bs-toggle="collapse" data-bs-target="#collapsePreferences"
                        aria-expanded="false" aria-controls="collapsePreferences">
                        Mes préférences
                    </button>
                </h2>
                <!-- body -->
                <div id="collapsePreferences" class="accordion-collapse collapse" data-bs-parent="#preferenceAccordion">
                    <div class="accordion-body">
                        <!-- Liste des préférences -->
                        <ul>
                            <!-- Bouton pour ajouter une nouvelle préférence -->
                            <li class="add-icon" id="newPrefIcon">
                                <!-- Icon avec le lien vers la page pour ajouter une préférence -->
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-plus-circle-fill"></i>
                                    <!-- Placeholder -->
                                    <p class="small-text mb-0">Ajouter une préférence</p>
                                </div>
                            </li>
                            <!-- Formulaire pour enregistrer une nouvelle préférence -->
                            <!-- à la base il est caché -->
                            <li id="personalPreference" class="hidden d-flex justify-content-center">
                                <!-- L'action c'est le controller Preference -->
                                <form action="/preference/creer-personnelle"
                                    method="post" class="d-flex flex-column gap-2 w-100">
                                    <!-- L'input text -->
                                    <textarea name="preference" class="form-control" required></textarea>
                                    <!-- bouton pour envoyer le fomulaire -->
                                    <button type="submit" class="btn btn-secondary"
                                        name="newPersonalPreference">Ajouter
                                    </button>
                                </form>
                            </li>
                            <!-- Accepte ou pas les fumeurs? -->
                            <li>
                                <!-- Si dans l'array existe la préférence fumeur, 
                                 alors le chauffeur accepte les fumeurs -->
                                <!-- Si dans l'array existe la préférence non_fumeur, 
                                 alors le chauffeur n'accepte pas les fumeurs  -->
                                <?php if (in_array("Fumeur", $preferencesLibelle)) {
                                    echo 'J\'accepte les fumeurs';
                                } elseif (in_array("Non_fumeur", $preferencesLibelle)) {
                                    echo 'Je n\'accepte pas les fumeurs';
                                } ?>
                            </li>
                            <!-- Accepte ou pas les animaux? -->
                            <li>
                                <!-- Si dans l'array existe la préférence animal, 
                                 alors le chauffeur accepte les animaux -->
                                <!-- Si dans l'array existe la préférence non_animal, 
                                 alors le chauffeur n'accepte pas les animaux -->
                                <?php if (in_array("Animal", $preferencesLibelle)) {
                                    echo 'J\'accepte les animaux';
                                } elseif (in_array("Non_animal", $preferencesLibelle)) {
                                    echo 'Je n\'accepte pas les animaux';
                                } ?>
                            </li>
                            <!-- Préférences Personnelles -->
                            <?php foreach ($allPersoPref as $pref) { ?>
                                <!-- on parcours le tableau pour récupérer chaque préférence, -->
                                <!-- on fait une liste pour chaque préférence, si n'est pas vide -->
                                <?php if (!empty($pref)) { ?>
                                    <li>
                                        <p class="mb-0"><?= ucfirst($pref['personnelle']) ?></p>
                                        <!-- Action buttons -->
                                        <div class="d-flex gap-1">
                                            <!-- Bouton pour pour ouvrir la modal de confirmation de suppresion -->
                                            <button class="btn btn-outline-dark secondary-btn content-text
                                                           bi bi-trash danger-btn me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deletePreferenceModal<?= $pref['id'] ?>">
                                            </button>
                                            <!-- Bouton pour éditer une préférence -->
                                            <button
                                                class="btn btn-outline-dark secondary-btn 
                                                    bi bi-pencil-square content-text editPrefIcon"
                                                data-index="<?= $pref['id'] ?>">
                                            </button>
                                        </div>
                                        <!-- Modal pour confirmer l'annulation de la préférence -->
                                        <!-- Ajout de l'id de la pref à l'id de la modal, 
                                         afin d'eviter des id en double, car la modal est dans un boucle -->
                                        <div class="modal fade" id="deletePreferenceModal<?= $pref['id'] ?>"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="deletePreferenceModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <!-- Le contenu de la modal -->
                                                <div class="modal-content">
                                                    <!-- Bouton pour fermer la modal -->
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                    </button>
                                                    <!-- Formulaire pour confirmer l'annulation du pref  -->
                                                    <form method="post" class="w-100 d-flex align-items-center 
                                                                              flex-column gap-4 p-5 mb-0 bg-light form">
                                                        <!-- input invisible pour envoyer l'id
                                                         de la préférence dans le formulaire-->
                                                        <input type="hidden" name="prefId"
                                                            value="<?= $pref['id'] ?>">
                                                        <label class="content-text text-center fw-medium">
                                                            Voulez-vous vraiment supprimer cette préférence?
                                                        </label>
                                                        <!-- Bouton pour confirmer -->
                                                        <div class="d-flex gap-3 justify-content-center">
                                                            <input type="submit" class="btn btn-danger shadow-section 
                                                                text-white content-text secondary-btn" value="Confirmer"
                                                                name="deletePreference">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Formulaire pour éditer une préférence -->
                                    <!-- à la base il est caché -->
                                    <li class="hidden d-flex justify-content-center editPersonalPreference"
                                        data-index="<?= $pref['id'] ?>">
                                        <form method="post" class="d-flex flex-column gap-2 w-100">
                                            <!-- L'input text -->
                                            <textarea name="preference_personnelle"
                                                class="form-control"
                                                required><?=
                                                            htmlspecialchars(ucfirst(trim($pref['personnelle'])))
                                                            ?></textarea>
                                            <!-- input invisble avec l'id de la préférence -->
                                            <input type="text" name="preference_id" value="<?= $pref['id'] ?>" hidden>
                                            <!-- bouton pour envoyer le fomulaire -->
                                            <button type="submit" class="btn btn-secondary"
                                                name="editPersonalPreference">Modifier
                                            </button>
                                        </form>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Les voitures -->
        <div class="accordion" id="carAccordion">
            <div class="accordion-item">
                <!-- Header -->
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed content-text fw-semibold text-capitalize"
                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseCars"
                        aria-expanded="false" aria-controls="collapseCars">
                        Mes voitures
                    </button>
                </h2>
                <!-- Body -->
                <div id="collapseCars" class="accordion-collapse collapse" data-bs-parent="#carAccordion">
                    <div class="accordion-body">
                        <!-- liste avec tous les voitures -->
                        <ul>
                            <!-- Bouton pour ajouter une nouvelle voiture -->
                            <li class="add-icon">
                                <!-- Icon avec le lien vers la page pour ajouter une voiture -->
                                <a href="/voiture/inscription"
                                    class="d-flex align-items-center gap-2">
                                    <i class="bi bi-plus-circle-fill"></i>
                                    <!-- Placeholder -->
                                    <p class="small-text mb-0">Ajouter une voiture</p>
                                </a>
                            </li>
                            <?php foreach ($allCars as $car) { ?>
                                <li><span class="fw-semibold">Marque = </span><?= $car['marque'] ?><br>
                                    <span class="fw-semibold">Modèle = </span><?= $car['modele'] ?><br>
                                    <span class="fw-semibold">Immatriculation = </span><?= $car['immatriculation'] ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<!-- Section pour acceder à l'espace employé -->
<?php if (Security::isEmploye()) { ?>
    <section class="employe-section content-text pt-2">
        <!-- Bouton pour acceder à l'espace employé -->
        <a class="btn btn-warning secondary-btn mt-2" href="/employe/avisCommentaires">
            Mon espace
        </a>
    </section>
<?php } ?>

<!-- Section pour l'administrateur -->
<?php if (Security::isAdmin()) { ?>
    <section class="admin-section content-text pt-2">
        <!--Bouton pour visualiser les graphiques de : 
            1. nombre des covoiturages par jour
            2. combien la plateforme gagne de crédit en fonction des jours -->
        <a class="btn btn-secondary text-white secondary-btn mt-2 small-text"
            href="/admin/graphique">
            Visualiser les graphiques
        </a>
        <!-- Bouton pour voir la table de tous les utilisateurs -->
        <a class="btn btn-warning text-dark secondary-btn mt-2 small-text" href="/admin/espace">
            Tous les comptes utilisateur
        </a>
    </section>
<?php } ?>

<!-- Boutton pour se deconnecter -->
<div class="d-flex justify-content-center mt-5 mb-5">
    <a href="/auth/deconnexion"
        class="btn btn-danger text-light secondary-btn content-text">
        Se deconnecter
    </a>
</div>

<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>