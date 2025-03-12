<?php
// HEADER

use App\Security\Security;

require_once './Templates/header.php';
?>

<!-- Section avec l'information de l'utilisateur -->
<section class="profil-section">
    <!-- Photo de l'utilisateur -->
    <div class="">
        <img src="../../Uploads/User/<?= (!empty($photoUniqueId)) ? $photoUniqueId :
                                            "../../Assets/Img_page-vue-covoiturages/driver-default.png"
                                        ?>"
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
                    <button class="accordion-button collapsed content-text fw-semibold text-capitalize" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Mes préférences
                    </button>
                </h2>
                <!-- body -->
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#preferenceAccordion">
                    <div class="accordion-body">
                        <!-- Liste des préférences -->
                        <ul>
                            <!-- Accepte ou pas les fumeurs? -->
                            <li>
                                <!-- Si dans l'array existe la préférence fumeur, alors le chauffeur accepte les fumeurs -->
                                <!-- Si dans l'array existe la préférence non_fumeur, alors le chauffeur n'accepte pas les fumeurs  -->
                                <?php if (in_array("Fumeur", $preferences)) {
                                    echo 'J\'accepte les fumeurs';
                                } elseif (in_array("Non_fumeur", $preferences)) {
                                    echo 'Je n\'accepte les fumeurs';
                                } ?>
                            </li>
                            <!-- Accepte ou pas les animaux? -->
                            <li>
                                <!-- Si dans l'array existe la préférence animal, alors le chauffeur accepte les animaux -->
                                <!-- Si dans l'array existe la préférence non_animal, alors le chauffeur n'accepte pas les animaux -->
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
                            <!-- Bouton pour ajouter une nouvelle préférence -->
                            <li class="add-icon">
                                <!-- Icon avec le lien vers la page pour ajouter une préférence -->
                                <a id="newPrefIcon">
                                    <i class="bi bi-plus-circle-fill"></i>
                                </a>
                                <!-- Placeholder -->
                                <p class="small-text">Ajouter une préférence</p>
                            </li>
                            <!-- Formulaire pour enregistrer une nouvelle préférence -->
                            <!-- à la base il est caché -->
                            <li id="personalPreference" class="hidden d-flex justify-content-center">
                                <!-- L'action c'est le controller PreferenceUser -->
                                <form action="?controller=preferences&action=preferencesInscription" method="post" class="d-flex flex-column gap-2">
                                    <!-- L'input text -->
                                    <textarea name="preference_personnelle" class="form-control" required></textarea>
                                    <!-- Input invisible pour envoyer un param fictif à la base de données
                                     à fin de pouvoir réaliser la requête sql -->
                                    <input type="text" name="preference_id" value="1" hidden>
                                    <!-- bouton pour envoyer le fomulaire -->
                                    <button type="submit" class="btn btn-secondary" name="newPersonalPreference">Ajouter</button>
                                </form>
                            </li>
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
                    <button class="accordion-button collapsed content-text fw-semibold text-capitalize" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Mes voitures
                    </button>
                </h2>
                <!-- Body -->
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#carAccordion">
                    <div class="accordion-body">
                        <!-- liste avec tous les voitures -->
                        <ul>
                            <?php foreach ($allCars as $car) { ?>
                                <li><span class="fw-semibold">Marque = </span><?= $car['marque'] ?><br>
                                    <span class="fw-semibold">Modèle = </span><?= $car['modele'] ?><br>
                                    <span class="fw-semibold">Immatriculation = </span><?= $car['immatriculation'] ?>
                                </li>
                            <?php } ?>
                            <!-- Bouton pour ajouter une nouvelle voiture -->
                            <li class="add-icon">
                                <!-- Icon avec le lien vers la page pour ajouter une voiture -->
                                <a href="?controller=voiture&action=carInscription">
                                    <i class="bi bi-plus-circle-fill"></i>
                                </a>
                                <!-- Placeholder -->
                                <p class="small-text">Ajouter une voiture</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<!-- Boutton pour se deconnecter -->
<div class="d-flex justify-content-center mt-5 mb-5">
    <a href="?controller=auth&action=logOut" class="btn btn-danger text-light btn-deconnexion">Se deconnecter</a>
</div>

<?php
// FOOTER
require_once './Templates/footer.php';
?>