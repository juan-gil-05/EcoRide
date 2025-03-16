<?php
// HEADER
use App\Security\Security;

require_once './Templates/header.php';
?>

<!-- Main -->
<!-- Section avec le hero, et le bouton pour créer un nouveau covoiturage si l'user est chauffer -->
<section class="text-center mes-covoiturages">
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
<!-- Pour afficher le message de succès quand l'user participe dans un covoiturage -->
<section>
    <?php if (isset($_SESSION['successParticipation'])) { ?>
        <div class="alert alert-success alert-dismissible fade show content-text" role="alert">
            Votre participation au covoiturage a été enregistrée avec succès !
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php 
    // Après d'avoir afficher le message, on supprime la session
    unset($_SESSION['successParticipation']);
    } ?>
</section>

<?php
// FOOTER
require_once './Templates/footer.php';
?>