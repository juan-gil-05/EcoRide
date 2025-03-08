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
<?php if(Security::isChauffeur()) {?>
    <section class="container driver-info">
        <div class="d-flex mt-1 gap-3 content-text">
            <a href="" class="btn btn-warning">Mes préférences</a>
            <a href="" class="btn btn-warning">Mes voitures</a>
        </div>
    </section>
<?php }?>
<!-- Boutton pour se deconnecter -->
<div class="d-flex justify-content-center mt-5">
    <a href="?controller=auth&action=logOut" class="btn btn-danger text-light btn-deconnexion">Se deconnecter</a>
</div>

<?php
// FOOTER
require_once './Templates/footer.php';
?>