<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>

<!-- main -->
<section class="container my-5 bg-light shadow-lg rounded-4 p-4 p-md-5 d-flex flex-column 
        align-items-center connection-form">
    <!-- titre -->
    <h1 class="text-primary fw-bold mb-5 headline-text text-center">Enregistrez vos préférences</h1>
    <!-- Deuxième partie du formulaire pour enregistrer les préférences utilisateur -->
    <form method="post" class="chauffeur w-100">
        <div class="row justify-content-center">
            <div class="card shadow-sm rounded-3 p-4 mb-4 col-12 col-md-6 text-center">
                <!-- Accepte des animaux ? -->
                <div class="d-flex justify-content-center gap-3 align-items-center">
                    <label for="animalCheck" class="form-check-label content-text">J'accepte les animaux: </label>
                    <div class="d-flex align-items-center gap-1">
                        <input class="form-check-input mt-0 shadow-sm"
                            type="radio" name="preference_id" id="animalCheck"
                            value="2" role="button">
                        <span class="text-dark small-text">Oui</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <input class="form-check-input mt-0 shadow-sm"
                            type="radio" name="preference_id" id="animalCheck"
                            value="4" role="button">
                        <span class="text-dark small-text">Non</span>
                    </div>
                </div>
                <!-- S'il y a une erreur, on l'affiche à l'utilisateur -->
                <?php if (isset($errors['preferenceIdEmpty'])) { ?>
                    <div class="invalid-feedback d-block mt-2 small-text "><?= $errors['preferenceIdEmpty'] ?></div>
                <?php } ?>
            </div>
        </div>
        <!-- Button pour continuer -->
        <div class="row justify-content-center">
            <div class="d-flex justify-content-center mt-4 col-12 col-md-6">
                <button class="btn btn-warning btn-lg fw-semibold text-dark w-50 w-md-25 content-text"
                    name="prefInscriptionAnimal" type="submit">Continuer</button>
            </div>
        </div>
    </form>

</section>
<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>