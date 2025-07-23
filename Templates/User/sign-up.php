<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';

?>

<!-- main -->

<section class="container my-5 bg-light shadow-lg rounded-4 p-4 p-md-5 connection-form">
  <!-- Formulaire pour créer un compte utilisateur -->
  <form method="post" class="d-flex flex-column" enctype="multipart/form-data">
    <!-- titre -->
    <h2 class="text-primary fw-bold mb-4 text-center headline-text">Créer un compte</h2>

    <!-- Tous les champs du formulaire de l'utilisateur -->
    <div class="d-flex flex-column align-items-center content-text gap-3">
      <!-- Pseudo -->
      <div class="form-floating">
        <input type="text" name="pseudo" class="form-control form-control-lg shadow-sm content-text
                <?= (isset($errors['pseudoEmpty'])) ? "is-invalid" : "" ?>"
          id="floatingInput" placeholder="Ex: Juanes" value="<?= htmlspecialchars($pseudo) ?>">
          <label for="floatingInput" class="content-text">Pseudo</label>
        <!-- Si il y a des erreurs on affiche le message d'erreur -->
        <?php if (isset($errors['pseudoEmpty'])) { ?>
          <div class="invalid-feedback position-static small-text"><?= $errors['pseudoEmpty'] ?></div>
        <?php } ?>
      </div>
      <!-- E-mail -->
      <div class="form-floating">
        <input type="email" class="form-control form-control-lg shadow-sm content-text
            <?= (isset($errors['mailEmpty'])) || (isset($errors['mailUsed'])) ? "is-invalid" : "" ?>"
          id="floatingMail" name="mail" placeholder="Ex: Junito@gmail.com" value="<?= htmlspecialchars($mail) ?>">
        <label for="floatingInput" class="content-text">Adresse e-mail</label>
        <!-- Si il y a des erreurs on affiche le message d'erreur -->
        <?php if (isset($errors['mailEmpty'])) { ?>
          <div class="invalid-feedback position-static small-text"><?= $errors['mailEmpty'] ?></div>
          <!-- Si le mail est déjà utilisé -->
        <?php } elseif (isset($errors['mailUsed'])) { ?>
          <div class="invalid-feedback position-static small-text"><?= $errors['mailUsed'] ?></div>
        <?php } ?>
      </div>
      <!-- Mot de passe -->
      <div class="form-floating">
        <input type="password" class="form-control form-control-lg shadow-sm content-text
        <?=
        (isset($errors['passwordEmpty'])) || (isset($errors['passwordLen'])) || (isset($errors['passwordInfo']))
          ? "is-invalid"
          : ""
        ?>"
          id="floatingPassword" name="password" placeholder="Password" value="<?= htmlspecialchars($password) ?>">
        <label for="floatingPassword" class="content-text">Mot de passe</label>
        <!-- message et button pour afficher le mot de passe -->
        <div class="show-password">
          <span class="text-dark small-text" id="showPasswordText">Afficher le mot de passe</span>
          <i class="bi bi-square" id="showPasswordIcon"></i>
        </div>
        <!-- Si il y a des erreurs on affiche le message d'erreur -->
        <?php if (isset($errors['passwordEmpty'])) { ?>
          <div class="invalid-feedback position-static invalid-tooltip-mdp small-text">
            <?= $errors['passwordEmpty'] ?>
          </div>
          <!-- Si le mot de passe a moins de 12 caractères   -->
        <?php } elseif (isset($errors['passwordLen'])) { ?>
          <div class="invalid-feedback position-static invalid-tooltip-mdp small-text">
            <?= $errors['passwordLen'] ?>
          </div>
          <!-- si le mot de passe ne respecte pas les requis d'une mot de passe secure -->
        <?php } elseif (isset($errors['passwordInfo'])) { ?>
          <div class="invalid-feedback position-static invalid-tooltip-mdp small-text">
            <?= $errors['passwordInfo'] ?>
          </div>
        <?php } ?>
      </div>

      <!-- Sélectionner le role -->
      <div class="mt-3">
        <label for="roleSelect" class="text-center text-dark content-text mb-1">Sélectionnez votre rôle : </label>
        <select class="form-select content-text 
        <?= (isset($errors['roleEmpty'])) ? "is-invalid" : "" ?>" name="role_id" id="roleSelect">
          <option value="<?= ($roleId) ? $roleId : "" ?>"><?= $roleName ?></option>
          <option value="1">Passager</option>
          <option value="2" class="driverRole">Chauffeur</option>
          <option value="3" class="driverRole">Chauffeur et passager</option>
        </select>
        <!-- Si il y a des erreurs on affiche le message d'erreur -->
        <?php if (isset($errors['roleEmpty'])) { ?>
          <div class="invalid-feedback position-static small-text"><?= $errors['roleEmpty'] ?></div>
        <?php } ?>
      </div>
      <!-- Si l'utilisateur a un role chauffeur, alors, formulaire pour enregistrer la photo -->
      <div class="mt-1 d-flex if-chauffeur non-chauffeur content-text" id="driverForm">
        <!-- la photo du chauffeur -->
        <div class="d-flex flex-column gap-3 driver-form">
          <!-- Ajouter la photo -->
          <div>
            <label for="driverImage" class="form-label text-dark">Ajoutez votre photo du profil</label>
            <input type="file" name="photo" class="form-control content-text" id="driverImage">
            <!-- Si il y a des erreurs on affiche le message d'erreur -->
            <?php if (isset($errors['fileEmpty'])) { ?>
              <div class="invalid-feedback d-block position-static small-text"><?= $errors['fileEmpty'] ?></div>
              <!-- S'il y a une erreur au moment de charger l'image -->
            <?php } elseif (isset($errors['fileError'])) { ?>
              <div class="invalid-feedback d-block position-static small-text"><?= $errors['fileError'] ?></div>
              <!-- Si l'extention n'est pas valide -->
            <?php } elseif (isset($errors['fileExtError'])) { ?>
              <div class="invalid-feedback d-block position-static small-text"><?= $errors['fileExtError'] ?></div>
              <!-- Si la taille est superieure à 2 Mo -->
            <?php } elseif (isset($errors['fileSizeError'])) { ?>
              <div class="invalid-feedback d-block position-static small-text"><?= $errors['fileSizeError'] ?></div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Button pour créer le compte -->
    <div class="d-flex justify-content-center mt-5 content-text">
      <button class="btn btn-warning btn-lg fw-semibold text-dark w-50"
        name="signUp" type="submit">Se registrer
      </button>
    </div>
    <!-- Lien si l'utilisateur a déjà un compte -->
    <div class="d-flex justify-content-center mt-5 small-text lien">
      <a href="?controller=auth&action=logIn" class="text-dark fw-semibold">J'ai dèjà un compte</a>
    </div>

  </form>
</section>

<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>