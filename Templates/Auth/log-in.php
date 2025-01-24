<?php
// HEADER
require_once './Templates/header.php';
?>

<!-- main -->

<section class="container mt-5 connection-form">
    <!-- Formulaire pour se connecter -->
    <form method="post">
        <!-- titre -->
        <h2 class="h3 mb-4 text-center text-white headline-text">Se connecter à EcoRide</h2>
        <!-- Tous les champs du formulaire -->
        <div class="d-flex flex-column align-items-center content-text">
            <!-- E-mail -->
            <div class="form-floating mb-3 ">
                <input type="email" name="mail" class="form-control
                <?= (isset($errors['mail'])) || (isset($errors['invalidUser'])) ? "is-invalid" : "" ?>"
                    id="floatingInput" placeholder="name@example.com" value="<?= $mail ?>">
                <label for="floatingInput">Adresse e-mail</label>
                <!-- Si il y a des erreurs on affiche le message d'erreur -->
                <?php if (isset($errors['mail'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['mail'] ?></div>
                <?php } ?>
            </div>
            <!-- Mot de passe -->
            <div class="form-floating mb-5">
                <input type="password" name="password" class="form-control <?= (isset($errors['invalidUser'])) ? "is-invalid" : "" ?>" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Mot de passe</label>
                <!-- message et button pour afficher le mot de passe -->
                <div class="show-password">
                    <span class="text-white small-text" id="showPasswordText">Afficher le mot de passe</span>
                    <i class="bi bi-square" id="showPasswordIcon"></i>
                </div>
            </div>
        </div>
        <!-- Erreur si le mail ou le mot de passe sont incorrect -->
        <?php if (isset($errors['invalidUser'])) { ?>
            <div class="if-form-error d-flex justify-content-center content-text">
                <div class="alert alert-danger mt-3 content-text text-center"><?= $errors['invalidUser'] ?></div>
            </div>
        <?php } ?>
        <!-- Button de connection -->
        <div class="d-flex justify-content-center">
            <button class="btn btn-warning text-dark w-50 py-3 mt-3 content-text fw-medium" name="logIn" type="submit">Se connecter</button>
        </div>
        <!-- Lien si l'utilisateru n'a pas un compte, pour s'en créer un -->
        <div class="d-flex justify-content-center mt-5 content-text lien">
            <a href="?controller=user&action=singUp" class="text-light">Créer un compte</a>
        </div>
    </form>
</section>


<?php
// FOOTER
require_once './Templates/footer.php';
?>