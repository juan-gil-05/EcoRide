<?php
// HEADER
require_once './Templates/header.php';
?>

<!-- main -->

<section class="container mt-5 connection-form">
  <form method="post" class="d-flex flex-column">
    <h1 class="h3 mb-4 text-center text-white headline-text">Créer un compte</h1>

    <div class="d-flex flex-column align-items-center content-text gap-3">
      <div class="form-floating">
        <input type="text" name="pseudo" class="form-control
                <?= (isset($errors['pseudoEmpty'])) ? "is-invalid" : "" ?>"
          id="floatingInput" placeholder="juanes" value="<?= $pseudo ?>">
        <label for="floatingPseudo">Pseudo</label>
        <?php if (isset($errors['pseudoEmpty'])) { ?>
          <div class="invalid-tooltip position-static "><?= $errors['pseudoEmpty'] ?></div>
        <?php } ?>
      </div>

      <div class="form-floating">
        <input type="email" class="form-control <?= (isset($errors['mailEmpty'])) || (isset($errors['mailUsed'])) ? "is-invalid" : "" ?>"
          id="floatingMail" name="mail" placeholder="name@example.com" value="<?= $mail ?>">
        <label for="floatingMail">Email address</label>
        <?php if (isset($errors['mailEmpty'])) { ?>
          <div class="invalid-tooltip position-static "><?= $errors['mailEmpty'] ?></div>
        <?php } elseif (isset($errors['mailUsed'])) { ?>
          <div class="invalid-tooltip position-static "><?= $errors['mailUsed'] ?></div>
        <?php } ?>
      </div>

      <div class="form-floating">
        <input type="password" class="form-control <?= (isset($errors['passwordEmpty'])) || (isset($errors['passwordLen'])) || (isset($errors['passwordInfo'])) ? "is-invalid" : "" ?>"
          id="floatingPassword" name="password" placeholder="Password" value="<?= $password ?>">
        <label for="floatingPassword">Mot de passe</label>
        <div class="show-password">
          <span class="text-white small-text" id="showPasswordText">Afficher le mot de passe</span>
          <i class="bi bi-square" id="showPasswordIcon"></i>
        </div>
        <?php if (isset($errors['passwordEmpty'])) { ?>
          <div class="invalid-tooltip position-static"><?= $errors['passwordEmpty'] ?></div>
        <?php } elseif (isset($errors['passwordLen'])) { ?>
          <div class="invalid-tooltip position-static"><?= $errors['passwordLen'] ?></div>
        <?php } elseif (isset($errors['passwordInfo'])) { ?>
          <div class="invalid-tooltip position-static"><?= $errors['passwordInfo'] ?></div>
        <?php } ?>

      </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
      <button class="btn btn-warning text-dark w-50 py-3 mt-3 content-text fw-medium" name="singUp" type="submit">Se registrer</button>
    </div>

    <div class="d-flex justify-content-center mt-5">
      <a href="?controller=auth&action=logIn" class="text-light">J'ai dèjà un compte</a>
    </div>

  </form>
</section>

<?php
// FOOTER
require_once './Templates/footer.php';
?>