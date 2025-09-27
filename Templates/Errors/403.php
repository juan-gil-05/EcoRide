<?php

// HEADER

require_once BASE_PATH . '/Templates/header.php';
?>

<!-- main -->
<div class="text-light bg-primary p-5">
    <div class="d-flex align-items-start justify-content-center m-5">
        <div class="text-center">
            <h1 class="display-1 fw-bold">403</h1>
            <p class="fs-2 fw-medium mt-4">Forbidden</p>
            <p class="mt-4 mb-5">Erreur : <?= $error[0] ?></p>
            <a href="/page/accueil" class="btn btn-light fw-semibold rounded-pill px-4 py-2 custom-btn">
                Retour vers la page d'accueil
            </a>
        </div>
    </div>
</div>

<?php
// FOOTER
require_once BASE_PATH . '/Templates/footer.php';
?>