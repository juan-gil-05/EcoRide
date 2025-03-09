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
            <li><span class="fw-medium">Vous avez = </span><?= $credits ?> crédits</li>
        </ul>
    </div>
</section>

<!-- Section pour les chauffeurs avec les préférences et les voitures -->
<?php if (Security::isChauffeur()) { ?>
    <section class="driver-info container content-text pt-2">
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
                        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
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
                            <li class="new-car-icon">
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
<div class="d-flex justify-content-center mt-5">
    <a href="?controller=auth&action=logOut" class="btn btn-danger text-light btn-deconnexion">Se deconnecter</a>
</div>

<?php
// FOOTER
require_once './Templates/footer.php';
?>