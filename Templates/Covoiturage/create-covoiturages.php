<?php
//HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>

<section class="container my-5 bg-light shadow-lg rounded-4 p-4 p-md-5 connection-form">
    <form method="post">
        <h1 class="text-primary fw-bold mb-4 text-center headline-text">Créer un nouveau covoiturage</h1>
        <!-- Tout le contenu du formulaire -->
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <!-- Informations de Départ -->
                <div class="card shadow-sm rounded-3 p-4 mb-4 covoiturage-form">
                    <h2 class="mb-4  content-text">Informations de Départ</h2>
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <label for="dateTimeDepart" class="form-label fw-semibold content-text">
                                Date et heure de départ:
                            </label>
                            <input
                                type="datetime-local"
                                name="date_heure_depart"
                                id="dateTimeDepart"
                                value="<?= (!empty($dateTimeDepart)) ? $dateTimeDepart->format("Y-m-d H:i") : ''; ?>"
                                class="form-control form-control-lg shadow-sm 
                                content-text <?= (isset($errors['dateTimeDepartEmpty']))
                                                    ? "is-invalid"
                                                    : "" ?>"
                                >
                            <?php if (isset($errors['dateTimeDepartEmpty'])) { ?>
                                <div class="invalid-feedback form-text  mt-2 small-text">
                                    <?= $errors['dateTimeDepartEmpty'] ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="adresseDepart" class="form-label fw-semibold content-text">
                                Adresse de départ:
                            </label>
                            <input
                                type="text"
                                name="adresse_depart"
                                id="adresseDepart"
                                value="<?= htmlspecialchars($adresseDepart) ?>"
                                class="form-control form-control-lg shadow-sm 
                                content-text <?= (isset($errors['adresseDepartEmpty']))
                                                    ? "is-invalid"
                                                    : "" ?>"
                                placeholder="Ex: Lyon"
                                >
                            <?php if (isset($errors['adresseDepartEmpty'])) { ?>
                                <div class="invalid-feedback form-text  mt-2 small-text">
                                    <?= $errors['adresseDepartEmpty'] ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- Informations d'Arrivée -->
                <div class="card shadow-sm rounded-3 p-4 mb-4 covoiturage-form">
                    <h2 class="mb-4  content-text">Informations d'Arrivée</h2>
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <label for="dateTimeArrivee" class="form-label fw-semibold content-text">
                                Date et heure d'arrivée:
                            </label>
                            <input
                                type="datetime-local"
                                name="date_heure_arrivee"
                                id="dateTimeArrivee"
                                value="<?= (!empty($dateTimeArrivee)) ? $dateTimeArrivee->format("Y-m-d H:i") : ''; ?>"
                                class="form-control form-control-lg shadow-sm 
                                content-text <?= (isset($errors['dateTimeArriveeEmpty']))
                                                    ? "is-invalid"
                                                    : "" ?>"
                                >
                            <?php if (isset($errors['dateTimeArriveeEmpty'])) { ?>
                                <div class="invalid-feedback form-text  mt-2 small-text">
                                    <?= $errors['dateTimeArriveeEmpty'] ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="adresseArrivee" class="form-label fw-semibold content-text">
                                Adresse d'arrivée:
                            </label>
                            <input
                                type="text"
                                name="adresse_arrivee"
                                id="adresseArrivee"
                                value="<?= htmlspecialchars($adresseArrivee) ?>"
                                class="form-control form-control-lg shadow-sm 
                                content-text <?= (isset($errors['adresseArriveeEmpty']))
                                                    ? "is-invalid"
                                                    : "" ?>"
                                placeholder="Ex: Barcelona"
                                >
                            <?php if (isset($errors['adresseArriveeEmpty'])) { ?>
                                <div class="invalid-feedback form-text  mt-2 small-text">
                                    <?= $errors['adresseArriveeEmpty'] ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- Détails du Covoiturage -->
                <div class="card shadow-sm rounded-3 p-4 mb-4 covoiturage-form">
                    <h2 class="mb-4  content-text">Détails du Covoiturage</h2>
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <label for="nbPlaceDisponible" class="form-label fw-semibold content-text">
                                Nombre de places disponibles:
                            </label>
                            <input
                                type="number"
                                name="nb_place_disponible"
                                id="nbPlaceDisponible"
                                value="<?= (!empty($nbPlaceDisponibles)) ? $nbPlaceDisponibles : '1'; ?>"
                                class="form-control form-control-lg shadow-sm 
                                content-text <?= (isset($errors['nbPlaceEmpty']))
                                                    ? "is-invalid"
                                                    : "" ?>"
                                min="1" max="8" step="1"
                                >
                            <?php if (isset($errors['nbPlaceEmpty'])) { ?>
                                <div class="invalid-feedback form-text  mt-2 small-text">
                                    <?= $errors['nbPlaceEmpty'] ?>
                                </div>
                            <?php } ?>
                            <small class="form-text  mt-2 small-text">Minimum 1 place, maximum 8.</small>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="prix" class="form-label fw-semibold content-text">Prix par passager (€):</label>
                            <div class="input-group input-group-lg ">
                                <input
                                    type="number"
                                    name="prix"
                                    id="prix"
                                    value="<?= (!empty($prix)) ? $prix : '0'; ?>"
                                    class="form-control content-text <?= (isset($errors['prixEmpty']))
                                                                            ? "is-invalid"
                                                                            : "" ?>"
                                    min="0"
                                    >
                                <span class="input-group-text content-text">€</span>
                                <?php if (isset($errors['prixEmpty'])) { ?>
                                    <div class="invalid-feedback form-text  mt-2 small-text">
                                        <?= $errors['prixEmpty'] ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <small class="form-text  mt-2 small-text">
                                2 crédits sont déduits pour le bon fonctionnement de la plateforme.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Sélection de la Voiture -->
                <div class="card shadow-sm rounded-3 p-4 mb-5 covoiturage-form car-selector">
                    <h2 class="mb-4  content-text">Sélection de la Voiture</h2>
                    <div class="form-group mb-3">
                        <label for="voitureId" class="form-label fw-semibold content-text">
                            Sélectionnez la voiture utilisée:
                        </label>
                        <select
                            class="form-select form-select-lg shadow-sm content-text  
                            bg-light <?= (isset($errors['voitureEmpty']))
                                            ? "is-invalid"
                                            : "" ?>"
                            name="voiture_id"
                            id="voitureId"
                            >
                            <option value="0">-- Sélectionnez une voiture --</option>
                            <?php foreach ($cars as $car) { ?>
                                <option
                                    value="<?= $car['id'] ?>"
                                    <?= (isset($_POST['voiture_id']) && $_POST['voiture_id'] == $car['id'])
                                        ? 'selected'
                                        : '' ?>>
                                    <?= "Marque: " . htmlspecialchars($car['marque']) .
                                        ", Modèle: " . htmlspecialchars($car['modele']) .
                                        ", Immatriculation: " . htmlspecialchars($car['immatriculation']) ?>
                                </option>
                            <?php } ?>
                        </select>
                        <?php if (isset($errors['voitureEmpty'])) { ?>
                            <div class="invalid-feedback form-text  mt-2 small-text">
                                <?= $errors['voitureEmpty'] ?>
                            </div>
                        <?php } ?>
                    </div>
                    <p class="text-center">
                        <a class="small-text " href="/voiture/inscription">
                            Cliquez ici pour enregistrer une nouvelle voiture
                        </a>
                    </p>
                </div>

                <!-- Button pour créer le covoiturage -->
                <div class="d-flex justify-content-center my-4">
                    <button class="btn btn-warning btn-lg fw-semibold text-dark w-50 py-3 content-text"
                        name="createCovoiturage" type="submit">
                        Créer
                    </button>
                </div>
            </div>
        </div>
    </form>
</section>

<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>