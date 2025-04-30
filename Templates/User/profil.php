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
                    <button class="accordion-button collapsed content-text fw-semibold text-capitalize" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePreferences" aria-expanded="false" aria-controls="collapsePreferences">
                        Mes préférences
                    </button>
                </h2>
                <!-- body -->
                <div id="collapsePreferences" class="accordion-collapse collapse" data-bs-parent="#preferenceAccordion">
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
                    <button class="accordion-button collapsed content-text fw-semibold text-capitalize" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCars" aria-expanded="false" aria-controls="collapseCars">
                        Mes voitures
                    </button>
                </h2>
                <!-- Body -->
                <div id="collapseCars" class="accordion-collapse collapse" data-bs-parent="#carAccordion">
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

        <!-- Bouton pour concevoir des comptes employés -->
        <button class="btn btn-warning secondary-btn mt-2 small-text" data-bs-toggle="modal" data-bs-target="#createEmployeAccountModal">
            Créer un compte employé
        </button>
        <!-- Modal pour concevoir un compte employé-->
        <div class="modal fade create-employe-account-modal" id="createEmployeAccountModal" tabindex="-1" aria-labelledby="createEmployeAccountModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createEmployeAccountModalLabel">Créer un compte employé</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulaire pour créer un compte employé -->
                        <form method="post" class="d-flex flex-column create-employe-account-form" id="createEmployeAccountForm">
                            <!-- Tous les champs du formulaire de l'utilisateur -->
                            <div class="create-employe-account-body">
                                <!-- Pseudo -->
                                <div class="form-floating">
                                    <input type="text" name="pseudo" class="form-control small-text"
                                        id="floatingInput" placeholder="juanes" value="<?= $employePseudoAccount ?>">
                                    <label for="floatingPseudo" class="small-text">Pseudo</label>
                                    <!-- S'il y a des erreurs on affiche le message d'erreur -->
                                    <!-- Les messages sont chargés dynamiquement depuis le js -->
                                    <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text hidden" id="pseudoEmpty"></div>
                                </div>
                                <!-- E-mail -->
                                <div class="form-floating">
                                    <input type="email" class="form-control small-text"
                                        id="floatingMail" name="mail" placeholder="name@example.com" value="<?= $employeMailAccount ?>">
                                    <label for="floatingMail" class="small-text">Email address</label>
                                    <!-- S'il y a des erreurs on affiche le message d'erreur -->
                                    <!-- Les messages sont chargés dynamiquement depuis le js -->
                                    <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text hidden" id="mailEmpty"></div>
                                    <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text hidden" id="mailUsed"></div>
                                </div>
                                <!-- Mot de passe -->
                                <div class="form-floating">
                                    <input type="password" class="form-control small-text"
                                        id="floatingPassword" name="password" placeholder="Password" value="<?= $employePasswordAccount ?>">
                                    <label for="floatingPassword" class="small-text">Mot de passe</label>
                                    <!-- message et button pour afficher le mot de passe -->
                                    <div class="show-password">
                                        <span class="text-dark small-text" id="showPasswordText">Afficher le mot de passe</span>
                                        <i class="bi bi-square" id="showPasswordIcon"></i>
                                    </div>
                                    <!-- S'il y a des erreurs on affiche le message d'erreur -->
                                    <!-- Les messages sont chargés dynamiquement depuis le js -->
                                    <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text hidden" id="passwordEmpty"></div>
                                    <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text hidden" id="passwordLen"></div>
                                    <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text hidden" id="passwordInfo"></div>
                                </div>
                            </div>
                            <!-- Button pour créer le compte -->
                            <div class="modal-footer justify-content-center gap-3">
                                <button type="button" class="btn btn-danger secondary-btn text-white small-text" data-bs-dismiss="modal">Annuler</button>
                                <button class="btn btn-primary secondary-btn text-white small-text" name="singUp" type="submit">
                                    Créer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Bouton pour visualiser les graphiques de : 
            1. nombre des covoiturages par jour
            2. combien la plateforme gagne de crédit en fonction des jours -->
        <a class="btn btn-secondary text-white secondary-btn mt-2 small-text" href="#">
            Visualiser les graphiques
        </a>
        <!-- Bouton pour suspendre un compte aussi bien utilisateur qu’employé -->
        <a class="btn btn-dark text-white secondary-btn mt-2 small-text" href="#">
            Suspendre un compte
        </a>
    </section>
<?php } ?>

<!-- Boutton pour se deconnecter -->
<div class="d-flex justify-content-center mt-5 mb-5">
    <a href="?controller=auth&action=logOut" class="btn btn-danger text-light secondary-btn content-text">Se deconnecter</a>
</div>

<?php
// FOOTER
require_once './Templates/footer.php';
?>