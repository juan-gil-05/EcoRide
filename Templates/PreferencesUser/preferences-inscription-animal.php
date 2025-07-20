<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>

<!-- main -->

<section class="container mt-5 connection-form d-flex flex-column align-items-center">
    <!-- titre -->
    <h1 class="mb-5 text-center text-white headline-text">Enregistrez vos préférences</h1>
    <!-- Deuxième partie du formulaire pour enregistrer les préférences utilisateur -->
    <form method="post" class="d-flex flex-column chauffeur">
        <div class="mt-1 d-flex gap-2 preferences-form content-text">
            <!-- Accepte des animaux ? -->
            <div class="d-flex gap-2 align-items-center">
                <label for="animalCheck" class="form-check-label content-text">J'accepte les animaux: </label>
                <input type="radio" class="form-check-input" name="preference_id" id="animalCheck" value="2" role="button"> <span class="text-white small-text">Oui</span>
                <input type="radio" class="form-check-input" name="preference_id" id="animalCheck" value="4" role="button"> <span class="text-white small-text">Non</span>
            </div>
            <!-- S'il y a une erreur, on l'affiche à l'utilisateur -->
            <?php if (isset($errors2['preferenceIdEmpty'])) { ?>
                <div class="invalid-tooltip position-static small-text "><?= $errors2['preferenceIdEmpty'] ?></div>
            <?php } ?>
        </div>
        <!-- Button pour continuer -->
        <div class="d-flex justify-content-center mt-4 mb-5">
            <button class="btn btn-warning text-dark w-50 py-3 mt-3 content-text fw-medium"
                name="prefInscriptionAnimal" type="submit">Continuer</button>
        </div>
    </form>

</section>

<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>