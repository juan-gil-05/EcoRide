<?php
// HEADER
require_once './Templates/header.php';
var_dump($_POST);

?>

<!-- main -->

<section class="container mt-5 connection-form d-flex flex-column align-items-center">
    <!-- Formulaire pour créer un compte utilisateur -->
    <form method="post" class="d-flex flex-column chauffeur">
        <!-- titre -->
        <h1 class="mb-5 text-center text-white headline-text">Enregistrez vos préférences</h1>
        <!-- Si l'utilisateur a un role chauffeur, alors, formulaire pour enregistrer ses préférences -->
        <div class="mt-1 d-flex gap-5 preferences-form content-text">
            <!-- Accepte des fumeurs ? -->
            <div class="d-flex gap-2">
                <label for="smokerCheck" class="form-check-label content-text">J'accepte les fumeurs: </label>
                <input type="radio" class="form-check-input" name="preference_id" id="smokerCheck" value="1"> <span class="text-white small-text">Oui</span>
                <input type="radio" class="form-check-input" name="preference_id" id="smokerCheck" value="3"> <span class="text-white small-text">Non</span>
            </div>
        </div>
        <!-- Button pour continuer -->
        <div class="d-flex justify-content-center mt-4 mb-5">
            <button class="btn btn-warning text-dark w-50 py-3 mt-3 content-text fw-medium" id="btnPreferences"
                name="prefInscription1" type="submit">Continuer</button>
        </div>
    </form>

    <?php if (isset($_POST['prefInscription1'])) {
        require_once './Templates/PreferencesUser/preferences-inscription2.php';
    }
    ?>

</section>

<?php
// FOOTER
require_once './Templates/footer.php';

?>