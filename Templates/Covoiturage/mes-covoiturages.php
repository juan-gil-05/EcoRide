<?php
// HEADER

use App\Security\Security;

require_once './Templates/header.php';
?>

<!-- Main -->
<section class="text-center mes-covoiturages">
    <!-- Contient le titre et le bouton -->
    <div class="container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <!-- titre -->
                <h1 class="headline-text text-white">Mes covoiturages</h1>
                <!-- Si l'utilsateur est chauffeur, alors, 
                on affiche le bouton vers la page pour saisir un nouveau covoiturage -->
                <?php if (Security::isChauffeur()) { ?>
                    <a href="?controller=covoiturages&action=createCovoiturage" class="btn btn-light mt-3 text-black">Créer un nouveau covoiturage</a>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<?php
// FOOTER
require_once './Templates/footer.php';
?>