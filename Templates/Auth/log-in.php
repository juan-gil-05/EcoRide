<?php
// HEADER
require_once './Templates/header.php';

?>

<!-- main -->

<section class="container mt-5 log-in-form">
    <form method="post">
        <h2 class="h3 mb-4 text-center text-white headline-text">Se connecter à EcoRide</h2>

        <div class="d-flex flex-column align-items-center form content-text">
            <div class="form-floating mb-3 ">
                <input type="email" name="mail" class="form-control
                <?= (isset($errors['mail'])) || (isset($errors['invalidUser'])) ? "is-invalid" : "" ?>" 
                id="floatingInput" placeholder="name@example.com" value="<?=$mail?>">
                <label for="floatingInput">Adresse e-mail</label>
                <?php if (isset($errors['mail'])) { ?>
                    <div class="invalid-tooltip position-static "><?= $errors['mail'] ?></div>
                <?php } ?>
            </div>
    
            <div class="form-floating">
                <input type="password" name="password" class="form-control <?= (isset($errors['invalidUser'])) ? "is-invalid" : "" ?>" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Mot de passe</label>
            </div>
        </div>
    
        <?php if (isset($errors['invalidUser'])) { ?>
            <div class="if-form-error d-flex justify-content-center content-text">
                <div class="alert alert-danger mt-3 "><?= $errors['invalidUser'] ?></div>
            </div>
        <?php } ?>

        <div class="d-flex justify-content-center">
            <button class="btn btn-warning text-dark w-50 py-3 mt-3 content-text fw-medium" name="logIn" type="submit">Se connecter</button>
        </div>

        <div class="d-flex justify-content-center mt-5">
            <a href="?controller=user&action=singUp" class="text-light">Créer un compte</a>
        </div>
    </form>
</section>


<?php
// FOOTER
require_once './Templates/footer.php';
?>