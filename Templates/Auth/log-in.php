<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>

<!-- main -->

<section class="container my-5 bg-light shadow-lg rounded-4 p-4 p-md-5 connection-form">
    <!-- Formulaire pour se connecter -->
    <form method="post">
        <!-- titre -->
        <h2 class="text-primary fw-bold mb-4 text-center headline-text">Se connecter à EcoRide</h2>
        <!-- Tous les champs du formulaire -->
        <div class="d-flex flex-column align-items-center content-text">
            <!-- E-mail -->
            <div class="form-floating mb-3 ">
                <input type="email" name="mail" class="form-control form-control-lg shadow-sm content-text
                <?= (isset($errors['mail'])) || (isset($errors['invalidUser'])) ? "is-invalid" : "" ?>"
                    id="floatingInput" placeholder="name@example.com" value="<?= htmlspecialchars($mail) ?>">
                <label for="floatingInput" class="content-text">Adresse e-mail</label>
                <!-- Si il y a des erreurs on affiche le message d'erreur -->
                <?php if (isset($errors['mail'])) { ?>
                    <div class="invalid-feedback small-text"><?= $errors['mail'] ?></div>
                <?php } ?>
            </div>
            <!-- Mot de passe -->
            <div class="form-floating mb-4">
                <input type="password" name="password" class="form-control form-control-lg shadow-sm content-text
                <?= (isset($errors['invalidUser']))
                    ? "is-invalid invalid-mdp"
                    : "" ?>" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword" class="content-text">Mot de passe</label>
                <!-- button pour afficher le mot de passe -->
                <div class="show-password">
                    <span class="text-dark small-text" id="showPasswordText"></span>
                    <i class="bi bi-eye" id="showPasswordIcon"></i>
                </div>
            </div>
        </div>
        <!-- Erreur si le mail ou le mot de passe sont incorrect -->
        <?php if (isset($errors['invalidUser'])) { ?>
            <div class="if-form-error d-flex justify-content-center content-text">
                <div class="alert alert-danger mt-3 content-text text-center"><?= $errors['invalidUser'] ?></div>
            </div>
        <?php } ?>
        <!-- Erreur si le compte est suspendu -->
        <?php if (isset($errors['inactiveUser'])) { ?>
            <div class="if-form-error d-flex justify-content-center content-text">
                <div class="alert alert-danger mt-3 content-text text-center"><?= $errors['inactiveUser'] ?></div>
            </div>
        <?php } ?>
        <!-- Button de connexion -->
        <div class="d-flex justify-content-center mt-5">
            <button class="btn btn-warning btn-lg fw-semibold w-50 content-text"
                name="logIn" type="submit">Se connecter</button>
        </div>
        <!-- Lien si l'utilisateru n'a pas un compte, pour s'en créer un -->
        <div class="d-flex justify-content-center mt-5 content-text lien">
            <a href="/user/inscription" class="text-dark fw-semibold">Créer un compte</a>
        </div>
    </form>
</section>


<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>