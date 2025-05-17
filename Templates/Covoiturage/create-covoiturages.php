<?php
//HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>

<section class="container mt-4 connection-form">
    <!-- Formulaire pour créer un un nouveau covoiturage -->
    <form method="post" class="d-flex flex-column ">
        <!-- titre -->
        <h1 class="mb-4 text-center text-white headline-text">Créer un nouveau covoiturage</h1>

        <!-- Tous les champs du formulaire de l'utilisateur -->
        <div class="d-flex flex-column gap-4 align-items-center covoiturage-form">
            <!-- Date et heure de départ et d'arrivée -->
            <div class="d-flex covoiturage-form-div">
                <!-- Date et heure de départ -->
                <div>
                    <label for="dateTimeDepart" class="form-label content-text">Date et heure de départ:</label>
                    <input type="datetime-local" name="date_heure_depart" id="dateTimeDepart"
                        value="<?= (!empty($dateTimeDepart)) ? $dateTimeDepart->format("Y-m-d H:i") : ''; ?>"
                        class="form-control content-text <?= (isset($errors['dateTimeDepartEmpty'])) ? "is-invalid" : "" ?>">
                    <!-- Si il y a des erreurs on affiche le message d'erreur -->
                    <?php if (isset($errors['dateTimeDepartEmpty'])) { ?>
                        <div class="invalid-tooltip position-static small-text"><?= $errors['dateTimeDepartEmpty'] ?></div>
                    <?php } ?>
                </div>
                <!-- Date et heure d'arrivée -->
                <div>
                    <label for="dateTimeArrivee" class="form-label content-text">Date et heure d'arrivée:</label>
                    <input type="datetime-local" name="date_heure_arrivee" id="dateTimeArrivee"
                        value="<?= (!empty($dateTimeArrivee)) ? $dateTimeArrivee->format("Y-m-d H:i") : ''; ?>"
                        class="form-control content-text <?= (isset($errors['dateTimeArriveeEmpty'])) ? "is-invalid" : "" ?>">
                    <!-- Si il y a des erreurs on affiche le message d'erreur -->
                    <?php if (isset($errors['dateTimeArriveeEmpty'])) { ?>
                        <div class="invalid-tooltip position-static small-text"><?= $errors['dateTimeArriveeEmpty'] ?></div>
                    <?php } ?>
                </div>
            </div>
            <!-- Adresse de départ et d'arrivée -->
            <div class="d-flex covoiturage-form-div">
                <!-- Adresse de départ -->
                <div>
                    <label for="adresseDepart" class="form-label content-text">Adresse de départ:</label>
                    <input type="text" name="adresse_depart" id="adresseDepart"
                        value="<?= $adresseDepart ?>"
                        class="form-control content-text <?= (isset($errors['adresseDepartEmpty'])) ? "is-invalid" : "" ?>">
                    <!-- Si il y a des erreurs on affiche le message d'erreur -->
                    <?php if (isset($errors['adresseDepartEmpty'])) { ?>
                        <div class="invalid-tooltip position-static small-text"><?= $errors['adresseDepartEmpty'] ?></div>
                    <?php } ?>
                </div>
                <!-- Adresse d'arrivée -->
                <div>
                    <label for="adresseArrivee" class="form-label content-text">Adresse d'arrivée:</label>
                    <input type="text" name="adresse_arrivee" id="adresseArrivee"
                        value="<?= $adresseArrivee ?>"
                        class="form-control content-text <?= (isset($errors['adresseArriveeEmpty'])) ? "is-invalid" : "" ?>">
                    <!-- Si il y a des erreurs on affiche le message d'erreur -->
                    <?php if (isset($errors['adresseArriveeEmpty'])) { ?>
                        <div class="invalid-tooltip position-static small-text"><?= $errors['adresseArriveeEmpty'] ?></div>
                    <?php } ?>
                </div>
            </div>
            <!-- Nombre des places disponibles et prix -->
            <div class="d-flex covoiturage-form-div">
                <!-- Nombre des places disponibles -->
                <div>
                    <label for="nbPlaceDisponible" class="form-label content-text">Nombre des places disponibles:</label>
                    <input type="number" name="nb_place_disponible" id="nbPlaceDisponible"
                        value="<?= (!empty($nbPlaceDisponibles)) ? $nbPlaceDisponibles : '0'; ?>"
                        class="form-control content-text <?= (isset($errors['nbPlaceEmpty'])) ? "is-invalid" : "" ?>">
                    <!-- Si il y a des erreurs on affiche le message d'erreur -->
                    <?php if (isset($errors['nbPlaceEmpty'])) { ?>
                        <div class="invalid-tooltip position-static small-text"><?= $errors['nbPlaceEmpty'] ?></div>
                    <?php } ?>
                </div>
                <!-- Prix -->
                <div>
                    <label for="prix" class="form-label content-text">Prix:</label>
                    <input type="number" name="prix" id="prix"
                        value="<?= (!empty($prix)) ? $prix : '0'; ?>"
                        class="form-control content-text<?= (isset($errors['prixEmpty'])) ? "is-invalid" : "" ?>">
                    <!-- Si il y a des erreurs on affiche le message d'erreur -->
                    <?php if (isset($errors['prixEmpty'])) { ?>
                        <div class="invalid-tooltip position-static small-text"><?= $errors['prixEmpty'] ?></div>
                    <?php } ?>
                    <!-- Text pour donner info à l'utilisateur -->
                    <span class="form-text small-text text-dark">2 crédits sont déduits pour le bon fonctionnement de la plateforme</span>
                </div>
            </div>
            <!-- Sélecctioner la voiture du covoiturage ou bouton pour créer en enregistrer une nouvelle -->
            <div class="d-flex covoiturage-form-div">
                <!-- Sélecctioner la voiture du covoiturage -->
                <div class="car-selector">
                    <label for="voitureId" class="text-center content-text">Sélecctioner la voiture utilisée: </label>
                    <select class="form-select content-text text-dark bg-light" name="voiture_id" id="voitureId">
                        <option value="0"></option>
                        <!-- Boucle qui affiche les option avec toutes les voitures de l'utilisateur
                         et le value c'est l'id de chaque voiture -->
                        <?php foreach ($cars as $car) { ?>
                            <option value="<?= $car['id'] ?>">
                                <?=
                                "Marque: " . $car['marque'] . ", " .
                                    "Modèle: " . $car['modele'] . ", " .
                                    "Immatriculation: " . $car['immatriculation']
                                ?>
                            </option>
                        <?php } ?>
                    </select>
                    <!-- Si il y a des erreurs on affiche le message d'erreur -->
                    <?php if (isset($errors['voitureEmpty'])) { ?>
                        <div class="invalid-tooltip position-static small-text"><?= $errors['voitureEmpty'] ?></div>
                    <?php } ?>
                    <!-- Lien pour enregistrer une nouvelle voiture -->
                    <a class="mt-2 small-text text-light" href="?controller=voiture&action=carInscription">Cliquez ici pour enregistrer une nouvelle voiture</a>
                </div>
            </div>
        </div>

        <!-- Button pour créer le covoiturage -->
        <div class="d-flex justify-content-center mt-4 mb-5">
            <button class="btn btn-warning text-dark w-50 py-3 mt-5 content-text fw-medium" name="createCovoiturage" type="submit">Créer</button>
        </div>

    </form>
</section>


<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>