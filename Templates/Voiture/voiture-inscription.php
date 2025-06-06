<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';

?>

<!-- main -->

<section class="container mt-4 connection-form d-flex flex-column align-items-center">
    <!-- Formulaire pour créer enregistrez une voiture -->
    <form method="post" class="d-flex flex-column chauffeur">
        <!-- titre -->
        <h1 class="mb-4 text-center text-white headline-text">Enregistrez votre voiture</h1>
        <!-- Si l'utilisateur a un role chauffeur, alors, formulaire pour enregistrer la voiture -->
        <!-- Enregistrez une voiture -->
        <div class="d-flex flex-column gap-4 car-form mt-1">
            <!-- Immatriculation -->
            <div>
                <div class="car-form-div">
                    <label for="immatriculation" class="form-label content-text">Plaque d’immatriculation:</label>
                    <input type="text" name="immatriculation" value="<?= $immatriculation ?>"
                        class="form-control content-text
                        <?= (isset($errors['immatriculationEmpty'])) || (isset($errors['immatriculationExists']))
                            || (isset($errors['immatriculationIncorrect'])) ? "is-invalid" : "" ?>" id="immatriculation">
                </div>
                <!-- Si il y a des erreurs on affiche le message d'erreur -->
                <?php if (isset($errors['immatriculationEmpty'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['immatriculationEmpty'] ?></div>
                    <!-- Si l'immatriculation de la voiture est dèjà utilisée -->
                <?php } elseif (isset($errors['immatriculationExists'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['immatriculationExists'] ?></div>
                    <!-- Si l'immatriculation ne respecte pas le bon format -->
                <?php } elseif (isset($errors['immatriculationIncorrect'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['immatriculationIncorrect'] ?></div>
                <?php } ?>
            </div>
            <!-- Date d'immatriculation -->
            <div>
                <div class="car-form-div">
                    <label for="immatriculationDate" class="form-label content-text">Date de première immatriculation:</label>
                    <!-- On lui passe en value la valeur de la date choisi par l'utilisateur, mais, d'abord on verfie s'il y a une date, pour eviter des erreurs de formattage des dattes -->
                    <input type="date" name="date_premiere_immatriculation"
                        value="<?= (!empty($dateImmatriculation)) ? $dateImmatriculation->format("Y-m-d") : var_dump('vacio'); ?>"
                        class="form-control text-dark content-text <?= (isset($errors['dateImmatriculationEmpty'])) ? "is-invalid" : "" ?>" id="immatriculationDate">
                </div>
                <!-- Si il y a des erreurs on affiche le message d'erreur -->
                <?php if (isset($errors['dateImmatriculationEmpty'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['dateImmatriculationEmpty'] ?></div>
                <?php } ?>
            </div>
            <!-- Marque -->
            <div>
                <div class="car-form-div">
                    <label for="marque" class="form-label content-text">Marque:</label>
                    <input type="text" name="marque" value="<?= $marque ?>"
                        class="form-control content-text<?= (isset($errors['marqueEmpty'])) ? "is-invalid" : "" ?>" id="marque">
                </div>
                <!-- Si il y a des erreurs on affiche le message d'erreur -->
                <?php if (isset($errors['marqueEmpty'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['marqueEmpty'] ?></div>
                <?php } ?>
            </div>
            <!-- Modèle -->
            <div>
                <div class="car-form-div">
                    <label for="modele" class="form-label content-text">Modèle:</label>
                    <input type="text" name="modele" value="<?= $modele ?>"
                        class="form-control content-text <?= (isset($errors['modeleEmpty'])) ? "is-invalid" : "" ?>" id="modele">
                </div>
                <!-- Si il y a des erreurs on affiche le message d'erreur -->
                <?php if (isset($errors['modeleEmpty'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['modeleEmpty'] ?></div>
                <?php } ?>
            </div>
            <!-- couleur -->
            <div>
                <div class="car-form-div">
                    <label for="couleur" class="form-label content-text">Couleur:</label>
                    <input type="text" name="couleur" value="<?= $couleur ?>"
                        class="form-control content-text <?= (isset($errors['couleurEmpty'])) ? "is-invalid" : "" ?>" id="couleur">
                </div>
                <!-- Si il y a des erreurs on affiche le message d'erreur -->
                <?php if (isset($errors['couleurEmpty'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['couleurEmpty'] ?></div>
                <?php } ?>
            </div>
            <!-- Sélecctioner l'energie utilisé par la voiture -->
            <div>
                <div class="car-form-div">
                    <label for="energy" class="text-center content-text">Énergie: </label>
                    <select class="form-select content-text <?= (isset($errors['energieEmpty'])) ? "is-invalid" : "" ?>" name="energie_id" id="energy">
                        <option value="0"></option>
                        <option value="1">Électrique</option>
                        <option value="2">Hybride</option>
                        <option value="3">Diesel - Gazole</option>
                        <option value="3">Essence</option>
                        <option value="3">GPL</option>
                    </select>
                </div>
                <!-- Si il y a des erreurs on affiche le message d'erreur -->
                <?php if (isset($errors['energieEmpty'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['energieEmpty'] ?></div>
                <?php } ?>
            </div>
        </div>

        <!-- Button pour enregistrez la voiture -->
        <div class="d-flex justify-content-center mt-4 mb-5">
            <button class="btn btn-warning text-dark w-50 py-3 mt-3 content-text fw-medium" name="carInscription" type="submit">Continuer</button>
        </div>

    </form>
</section>

<?php
// FOOTER
require_once  BASE_PATH .'/Templates/footer.php';
?>