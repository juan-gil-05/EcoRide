<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';

?>

<!-- main -->

<section class="container bg-light shadow-lg rounded-4 p-4 p-md-5 my-5">
    <!-- Formulaire pour créer enregistrez une voiture -->
    <form method="post" class="d-flex flex-column chauffeur">
        <!-- titre -->
        <h1 class="text-primary fw-bold mb-4 text-center headline-text">Enregistrez votre voiture</h1>
        <!-- Si l'utilisateur a un role chauffeur, alors, formulaire pour enregistrer la voiture -->
        <!-- Enregistrez une voiture -->
        <div class="row">
            <!-- Immatriculation -->
            <div class="col-md-6">
                <div class="card shadow-sm rounded-3 p-4 mb-4">
                    <label for="immatriculation" class="form-label content-text fw-semibold">
                        Plaque d’immatriculation:
                    </label>
                    <input type="text" name="immatriculation" value="<?= htmlspecialchars($immatriculation) ?>"
                        class="form-control small-text form-control-lg 
                        shadow-sm <?= (isset($errors['immatriculationEmpty'])) ||
                                        (isset($errors['immatriculationExists'])) ||
                                        (isset($errors['immatriculationIncorrect']))
                                        ? "is-invalid"
                                        : "" ?>" id="immatriculation"
                        placeholder="Ex: AB-123-CD">
                    <!-- Si il y a des erreurs on affiche le message d'erreur -->
                    <?php if (isset($errors['immatriculationEmpty'])) { ?>
                        <div class="invalid-feedback position-static small-text">
                            <?= $errors['immatriculationEmpty'] ?>
                        </div>
                        <!-- Si l'immatriculation de la voiture est dèjà utilisée -->
                    <?php } elseif (isset($errors['immatriculationExists'])) { ?>
                        <div class="invalid-feedback position-static small-text">
                            <?= $errors['immatriculationExists'] ?>
                        </div>
                        <!-- Si l'immatriculation ne respecte pas le bon format -->
                    <?php } elseif (isset($errors['immatriculationIncorrect'])) { ?>
                        <div class="invalid-feedback position-static small-text">
                            <?= $errors['immatriculationIncorrect'] ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!-- Date d'immatriculation -->
            <div class="col-md-6">
                <div class="card shadow-sm rounded-3 p-4 mb-4">
                    <label for="immatriculationDate" class="form-label content-text fw-semibold">
                        Date de première immatriculation:
                    </label>
                    <!-- On lui passe en value la valeur de la date choisi par l'utilisateur, 
                         mais, d'abord on verfie s'il y a une date, pour eviter des erreurs de formattage des dattes -->
                    <input type="date" name="date_premiere_immatriculation"
                        value="<?= (!empty($dateImmatriculation))
                                    ? $dateImmatriculation->format("Y-m-d")
                                    : "" ?>"
                        class="form-control small-text form-control-lg shadow-sm 
                        text-dark <?= (isset($errors['dateImmatriculationEmpty']))
                                        ? "is-invalid"
                                        : "" ?>"
                        id="immatriculationDate"
                        placeholder="JJ/MM/AAAA">
                    <small class="form-text text-muted small-text">
                        Indiquez la date exacte de la première immatriculation.
                    </small>
                    <!-- Si il y a des erreurs on affiche le message d'erreur -->
                    <?php if (isset($errors['dateImmatriculationEmpty'])) { ?>
                        <div class="invalid-feedback position-static small-text">
                            <?= $errors['dateImmatriculationEmpty'] ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Marque -->
            <div class="col-md-6">
                <div class="card shadow-sm rounded-3 p-4 mb-4">
                    <label for="marque" class="form-label content-text fw-semibold">Marque:</label>
                    <input type="text" name="marque" value="<?= htmlspecialchars($marque) ?>"
                        class="form-control small-text form-control-lg shadow-sm <?= (isset($errors['marqueEmpty']))
                                                                                        ? "is-invalid"
                                                                                        : "" ?>"
                        id="marque"
                        placeholder="Ex: Peugeot">
                    <!-- Si il y a des erreurs on affiche le message d'erreur -->
                    <?php if (isset($errors['marqueEmpty'])) { ?>
                        <div class="invalid-feedback position-static small-text"><?= $errors['marqueEmpty'] ?></div>
                    <?php } ?>
                </div>
            </div>
            <!-- Modèle -->
            <div class="col-md-6">
                <div class="card shadow-sm rounded-3 p-4 mb-4">
                    <label for="modele" class="form-label content-text fw-semibold">Modèle:</label>
                    <input type="text" name="modele" value="<?= htmlspecialchars($modele) ?>"
                        class="form-control small-text form-control-lg shadow-sm <?= (isset($errors['modeleEmpty']))
                                                                                        ? "is-invalid"
                                                                                        : "" ?>"
                        id="modele"
                        placeholder="Ex: 208">
                    <!-- Si il y a des erreurs on affiche le message d'erreur -->
                    <?php if (isset($errors['modeleEmpty'])) { ?>
                        <div class="invalid-feedback position-static small-text"><?= $errors['modeleEmpty'] ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- couleur -->
            <div class="col-md-6">
                <div class="card shadow-sm rounded-3 p-4 mb-4">
                    <label for="couleur" class="form-label content-text fw-semibold">Couleur:</label>
                    <input type="text" name="couleur" value="<?= htmlspecialchars($couleur) ?>"
                        class="form-control small-text form-control-lg shadow-sm <?= (isset($errors['couleurEmpty']))
                                                                                        ? "is-invalid"
                                                                                        : "" ?>"
                        id="couleur"
                        placeholder="Ex: Rouge">
                    <!-- Si il y a des erreurs on affiche le message d'erreur -->
                    <?php if (isset($errors['couleurEmpty'])) { ?>
                        <div class="invalid-feedback position-static small-text"><?= $errors['couleurEmpty'] ?></div>
                    <?php } ?>
                </div>
            </div>
            <!-- Sélecctioner l'energie utilisé par la voiture -->
            <div class="col-md-6">
                <div class="card shadow-sm rounded-3 p-4 mb-4">
                    <label for="energy" class="form-label content-text fw-semibold mb-2">Énergie: </label>
                    <select class="form-select small-text form-control-lg shadow-sm <?= (isset($errors['energieEmpty']))
                                                                                        ? "is-invalid"
                                                                                        : "" ?>"
                        name="energie_id" id="energy">
                        <option value="0">-- Sélectionnez une type d'energie --</option>
                        <option value="1">Électrique</option>
                        <option value="2">Hybride</option>
                        <option value="3">Diesel - Gazole</option>
                        <option value="3">Essence</option>
                        <option value="3">GPL</option>
                    </select>
                    <small class="form-text text-muted small-text">Choisissez le type d'énergie du véhicule.</small>
                    <!-- Si il y a des erreurs on affiche le message d'erreur -->
                    <?php if (isset($errors['energieEmpty'])) { ?>
                        <div class="invalid-feedback position-static small-text"><?= $errors['energieEmpty'] ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Button pour enregistrez la voiture -->
        <div class="d-flex justify-content-center my-4">
            <button class="btn btn-warning btn-lg fw-semibold w-50 py-3 content-text"
                name="carInscription" type="submit">
                Continuer
            </button>
        </div>

    </form>
</section>

<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>