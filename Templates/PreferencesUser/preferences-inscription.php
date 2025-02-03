<?php
// HEADER
require_once './Templates/header.php';
?>

<!-- main -->

<section class="container mt-5 connection-form d-flex flex-column align-items-center">
    <!-- titre -->
    <h1 class="mb-5 text-center text-white headline-text">Enregistrez vos préférences</h1>
    <!-- Première partie du formulaire pour enregistrer les préférences utilisateur -->
    <form method="post" class="d-flex flex-column chauffeur <?= ((isset($_POST['prefInscription1']) || isset($_POST['prefInscription2'])) && empty($errors)) ? "hidden" : "" ?>">
        <div class="mt-1 d-flex gap-2 preferences-form content-text">
            <!-- Accepte les fumeurs ? -->
            <div class="d-flex gap-2 align-items-center">
                <label for="smokerCheck" class="form-check-label content-text">J'accepte les fumeurs: </label>
                <input class="form-check-input"
                    type="radio" name="preference_id" id="smokerCheck" value="1"> <span class="text-white small-text">Oui</span>
                <input class="form-check-input"
                    type="radio" name="preference_id" id="smokerCheck" value="3"> <span class="text-white small-text">Non</span>
            </div>
            <!-- S'il y a une erreur, on l'affiche à l'utilisateur -->
            <?php if (isset($errors['preferenceIdEmpty'])) { ?>
                <div class="invalid-tooltip position-static small-text "><?= $errors['preferenceIdEmpty'] ?></div>
            <?php } ?>
        </div>
        <!-- Button pour continuer -->
        <div class="d-flex justify-content-center mt-4 mb-5 ">
            <button class="btn btn-warning text-dark w-50 py-3 mt-3 content-text fw-medium"
                id="btnPreferences"
                name="prefInscription1" type="submit">Continuer</button>
        </div>
    </form>

    <!-- Si clique sur le bouton de continuer et qu'il n'y a pas des erreurs, 
    alors, on affiche la deuxième partie du formulaire -->
    <?php if ((isset($_POST['prefInscription1']) || isset($_POST['prefInscription2'])) && empty($errors)) {
        require_once './Templates/PreferencesUser/preferences-inscription2.php';
    }
    ?>

</section>

<?php
// FOOTER
require_once './Templates/footer.php';
?>