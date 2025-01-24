<?php
// HEADER
require_once './Templates/header.php';
?>

<!-- main -->

<section class="container mt-5 connection-form">
  <!-- Formulaire pour créer un compte utilisateur -->
  <form method="post" class="d-flex flex-column">
    <!-- titre -->
    <h1 class="h3 mb-4 text-center text-white headline-text">Créer un compte</h1>
    <!-- Tous les champs du formulaire -->
    <div class="d-flex flex-column align-items-center content-text gap-3">
      <!-- Pseudo -->
      <div class="form-floating">
        <input type="text" name="pseudo" class="form-control
                <?= (isset($errors['pseudoEmpty'])) ? "is-invalid" : "" ?>"
          id="floatingInput" placeholder="juanes" value="<?= $pseudo ?>">
        <label for="floatingPseudo">Pseudo</label>
        <!-- Si il y a des erreurs on affiche le message d'erreur -->
        <?php if (isset($errors['pseudoEmpty'])) { ?>
          <div class="invalid-tooltip position-static "><?= $errors['pseudoEmpty'] ?></div>
        <?php } ?>
      </div>
      <!-- E-mail -->
      <div class="form-floating">
        <input type="email" class="form-control <?= (isset($errors['mailEmpty'])) || (isset($errors['mailUsed'])) ? "is-invalid" : "" ?>"
          id="floatingMail" name="mail" placeholder="name@example.com" value="<?= $mail ?>">
        <label for="floatingMail">Email address</label>
        <!-- Si il y a des erreurs on affiche le message d'erreur -->
        <?php if (isset($errors['mailEmpty'])) { ?>
          <div class="invalid-tooltip position-static "><?= $errors['mailEmpty'] ?></div>
          <!-- Si le mail est déjà utilisé -->
        <?php } elseif (isset($errors['mailUsed'])) { ?>
          <div class="invalid-tooltip position-static "><?= $errors['mailUsed'] ?></div>
        <?php } ?>
      </div>
      <!-- Mot de passe -->
      <div class="form-floating">
        <input type="password" class="form-control <?= (isset($errors['passwordEmpty'])) || (isset($errors['passwordLen'])) || (isset($errors['passwordInfo'])) ? "is-invalid" : "" ?>"
          id="floatingPassword" name="password" placeholder="Password" value="<?= $password ?>">
        <label for="floatingPassword">Mot de passe</label>
        <!-- message et button pour afficher le mot de passe -->
        <div class="show-password">
          <span class="text-white small-text" id="showPasswordText">Afficher le mot de passe</span>
          <i class="bi bi-square" id="showPasswordIcon"></i>
        </div>
        <!-- Si il y a des erreurs on affiche le message d'erreur -->
        <?php if (isset($errors['passwordEmpty'])) { ?>
          <div class="invalid-tooltip position-static"><?= $errors['passwordEmpty'] ?></div>
          <!-- Si le mot de passe a moins de 12 caractères   -->
        <?php } elseif (isset($errors['passwordLen'])) { ?>
          <div class="invalid-tooltip position-static"><?= $errors['passwordLen'] ?></div>
          <!-- si le mot de passe ne respecte pas les requis d'une mot de passe secure -->
        <?php } elseif (isset($errors['passwordInfo'])) { ?>
          <div class="invalid-tooltip position-static"><?= $errors['passwordInfo'] ?></div>
        <?php } ?>

      </div>
    </div>
    <!-- Button pour créer le compte -->
    <div class="d-flex justify-content-center mt-4">
      <button class="btn btn-warning text-dark w-50 py-3 mt-3 content-text fw-medium" name="singUp" type="submit">Se registrer</button>
    </div>
    <!-- Lien si l'utilisateru a déjà un compte -->
    <div class="d-flex justify-content-center mt-5">
      <a href="?controller=auth&action=logIn" class="text-light">J'ai dèjà un compte</a>
    </div>

  </form>
</section>

<?php
// FOOTER
require_once './Templates/footer.php';
?>