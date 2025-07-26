<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>

<!-- main -->

<section class="container my-5 bg-light shadow-lg rounded-4 p-4 p-md-5 d-flex flex-column 
        align-items-center connection-form">
    <!-- titre -->
    <h1 class="text-primary fw-bold mb-5 headline-text text-center">Enregistrez vos préférences</h1>
    <!-- formulaire pour enregistrer les préférences utilisateur -->
    <form method="post" class="w-100">
        <!-- Accepte les fumeurs ? -->
        <div class="row justify-content-center">
            <div class="card shadow-sm rounded-3 p-4 mb-4 col-12 col-md-6 text-center">
                <div class="d-flex justify-content-center gap-3 align-items-center">
                    <label for="smokerCheck" class="form-check-label content-text fw-semibold">
                        J'accepte les fumeurs:
                    </label>
                    <div class="d-flex align-items-center gap-1">
                        <input class="form-check-input mt-0 shadow-sm"
                            type="radio" name="preference_smoker" id="smokerCheck"
                            value="1" role="button" <?= ($preferenceSmoker == 1) ? 'checked' : '' ?>>
                        <span class="text-dark small-text">Oui</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <input class="form-check-input mt-0 shadow-sm"
                            type="radio" name="preference_smoker" id="smokerCheck"
                            value="3" role="button" <?= ($preferenceSmoker == 3) ? 'checked' : '' ?>>
                        <span class="text-dark small-text">Non</span>
                    </div>
                </div>
                <!-- S'il y a une erreur, on l'affiche à l'utilisateur -->
                <?php if (isset($errors['preferenceSmokerEmpty'])) { ?>
                    <div class="invalid-feedback d-block mt-2 small-text "><?= $errors['preferenceSmokerEmpty'] ?></div>
                <?php } ?>
            </div>
        </div>

        <!-- Accepte des animaux ? -->
        <div class="row justify-content-center">
            <div class="card shadow-sm rounded-3 p-4 mb-4 col-12 col-md-6 text-center">
                <div class="d-flex justify-content-center gap-3 align-items-center">
                    <label for="animalCheck" class="form-check-label fw-semibold content-text">
                        J'accepte les animaux:
                    </label>
                    <div class="d-flex align-items-center gap-1">
                        <input class="form-check-input mt-0 shadow-sm"
                            type="radio" name="preference_animal" id="animalCheck"
                            value="2" role="button" <?= ($preferenceAnimal == 2) ? 'checked' : '' ?>>
                        <span class="text-dark small-text">Oui</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <input class="form-check-input mt-0 shadow-sm"
                            type="radio" name="preference_animal" id="animalCheck"
                            value="4" role="button" <?= ($preferenceAnimal == 4) ? 'checked' : '' ?>>
                        <span class="text-dark small-text">Non</span>
                    </div>
                </div>
                <!-- S'il y a une erreur, on l'affiche à l'utilisateur -->
                <?php if (isset($errors['preferenceAnimalEmpty'])) { ?>
                    <div class="invalid-feedback d-block mt-2 small-text "><?= $errors['preferenceAnimalEmpty'] ?></div>
                <?php } ?>
            </div>
        </div>

        <!-- Préférence personnelle -->
        <div class="row justify-content-center">
            <div class="card shadow-sm rounded-3 p-4 col-12 col-md-6 text-center">
                <div class="d-flex flex-column justify-content-center gap-3 align-items-center content-text">
                    <label class="form-check-label content-text fw-semibold" for="personalPreference">
                        Préférence personnelle:
                    </label>
                    <textarea name="preference" class="form-control bg-light small-text text-dark"
                        placeholder="Ex: J'écoute pop en anglais"
                        id="personalPreference"><?= $preferencePersonnelle ?></textarea>
                </div>
                <small class="text-end mt-1 text-dark"><i>(facultatif)</i></small>
            </div>
        </div>

        <!-- Bouton pour finaliser -->
        <div class="row justify-content-center">
            <div class="d-flex justify-content-center mt-4 col-12 col-md-6">
                <button class="btn btn-warning btn-lg fw-semibold text-dark w-50 w-md-25 content-text"
                    name="prefInscription" type="submit">Finaliser</button>
            </div>
        </div>
    </form>

</section>

<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>