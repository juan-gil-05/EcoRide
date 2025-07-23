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
                            <li class="add-icon" id="newPrefIcon" >
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
                                <!-- L'action c'est le controller PreferenceUser -->
                                <form action="?controller=preferences&action=preferencesInscriptionPersonal"
                                    method="post" class="d-flex flex-column gap-2">
                                    <!-- L'input text -->
                                    <textarea name="preference_personnelle" class="form-control" required></textarea>
                                    <!-- Input invisible pour envoyer un param fictif à la base de données
                                     à fin de pouvoir réaliser la requête sql -->
                                    <input type="text" name="preference_id" value="1" hidden>
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
                                <?php if (in_array("Fumeur", $preferences)) {
                                    echo 'J\'accepte les fumeurs';
                                } elseif (in_array("Non_fumeur", $preferences)) {
                                    echo 'Je n\'accepte pas les fumeurs';
                                } ?>
                            </li>
                            <!-- Accepte ou pas les animaux? -->
                            <li>
                                <!-- Si dans l'array existe la préférence animal, 
                                 alors le chauffeur accepte les animaux -->
                                <!-- Si dans l'array existe la préférence non_animal, 
                                 alors le chauffeur n'accepte pas les animaux -->
                                <?php if (in_array("Animal", $preferences)) {
                                    echo 'J\'accepte les animaux';
                                } elseif (in_array("Non_animal", $preferences)) {
                                    echo 'Je n\'accepte pas les animaux';
                                } ?>
                            </li>
                            <!-- Préférences Personnelles -->
                            <?php foreach ($preferencesPersonnelles as $personnelle) { ?>
                                <!-- on parcours le tableau pour récupérer chaque préférence, -->
                                <!-- on fait une liste pour chaque préférence, si n'est pas vide -->
                                <?php if (!empty($personnelle)) { ?>
                                    <li>
                                        <p class="mb-0"><?= ucfirst($personnelle) ?></p>
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
                                <a href="?controller=voiture&action=carInscription"
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
        <a class="btn btn-warning secondary-btn mt-2" href="?controller=employe&action=validateAvisAndComments">
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
            href="?controller=admin&action=adminGraphs">
            Visualiser les graphiques
        </a>
        <!-- Bouton pour voir la table de tous les utilisateurs -->
        <a class="btn btn-warning text-dark secondary-btn mt-2 small-text" href="?controller=admin&action=adminEspace">
            Tous les comptes utilisateur
        </a>
    </section>
<?php } ?>

<!-- Boutton pour se deconnecter -->
<div class="d-flex justify-content-center mt-5 mb-5">
    <a href="?controller=auth&action=logOut"
        class="btn btn-danger text-light secondary-btn content-text">
        Se deconnecter
    </a>
</div>

<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>