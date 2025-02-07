<?php
//HEADER
require_once './Templates/header.php';
?>

<section class="container mt-5 connection-form">
    <!-- Formulaire pour créer un un nouveau covoiturage -->
    <form method="post" class="d-flex flex-column ">
        <!-- titre -->
        <h1 class="mb-4 text-center text-white headline-text">Créer un nouveau covoiturage</h1>

        <!-- Tous les champs du formulaire de l'utilisateur -->
        <div class="d-flex flex-column gap-4 car-form mt-1">
            <!-- Date et heure de départ -->
            <div class="car-form-div">
                <label for="dateTimeDepart" class="form-label content-text">Date et heure de départ:</label>
                <input type="datetime-local" name="date_heure_depart" value="" class="form-control content-text" id="dateTimeDepart">
                <!-- Si il y a des erreurs on affiche le message d'erreur -->
                <?php if (isset($errors['dateTimeEmpty'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['dateTimeEmpty'] ?></div>
                <?php } ?>
            </div>
            <!-- Date et heure d'arrivée -->
            <div class="car-form-div">
                <label for="dateTimeArrivee" class="form-label content-text">Date et heure d'arrivée:</label>
                <input type="datetime-local" name="date_heure_arrivee" value=""
                    class="form-control text-dark content-text" id="dateTimeArrivee">
                <!-- Si il y a des erreurs on affiche le message d'erreur -->
                <?php if (isset($errors['dateTimeEmpty'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['dateTimeEmpty'] ?></div>
                <?php } ?>
            </div>
            <!-- Adresse de départ -->
            <div class="car-form-div">
                <label for="adresseDepart" class="form-label content-text">Adresse de départ:</label>
                <input type="text" name="adresse_depart" value="" class="form-control content-text" id="adresseDepart">
                <!-- Si il y a des erreurs on affiche le message d'erreur -->
                <?php if (isset($errors['adresseEmpty'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['adresseEmpty'] ?></div>
                <?php } ?>
            </div>
            <!-- Adresse d'arrivée -->
            <div class="car-form-div">
                <label for="adresseArrivee" class="form-label content-text">Adresse d'arrivée:</label>
                <input type="text" name="adresse_arrivee" value="" class="form-control content-text" id="adresseArrivee">
                <!-- Si il y a des erreurs on affiche le message d'erreur -->
                <?php if (isset($errors['adresseEmpty'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['adresseEmpty'] ?></div>
                <?php } ?>
            </div>
            <!-- Nombre des places disponibles -->
            <div class="car-form-div">
                <label for="nbPlaceDisponible" class="form-label content-text">Nombre des places disponibles:</label>
                <input type="number" name="nb_place_disponible" value="0" class="form-control content-text" id="nbPlaceDisponible">
                <!-- Si il y a des erreurs on affiche le message d'erreur -->
                <?php if (isset($errors['nbPlaceEmpty'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['nbPlaceEmpty'] ?></div>
                <?php } ?>
            </div>
            <!-- Prix -->
            <div class="car-form-div">
                <label for="prix" class="form-label content-text">Prix:</label>
                <input type="number" name="prix" value="0" class="form-control content-text" id="prix">
                <!-- Si il y a des erreurs on affiche le message d'erreur -->
                <?php if (isset($errors['prixEmpty'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['prixEmpty'] ?></div>
                <?php } ?>
            </div>
            <!-- Sélecctioner la voiture du covoiturage -->
            <div class="car-form-div">
                <label for="voitureId" class="text-center content-text">Sélecctioner la voiture utilisée: </label>
                <select class="form-select content-text" name="voiture_id" id="voitureId">
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
            </div>
        </div>

        <!-- Button pour créer le covoiturage -->
        <div class="d-flex justify-content-center mt-4 mb-5">
            <button class="btn btn-warning text-dark w-50 py-3 mt-3 content-text fw-medium" name="createCovoiturage" type="submit">Créer</button>
        </div>

    </form>
</section>


<?php
// FOOTER
require_once './Templates/footer.php';
?>