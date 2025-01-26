<?php
// HEADER
require_once './Templates/header.php';
?>

<!-- main -->

<section class="container mt-5 connection-form">
  <!-- Formulaire pour créer un compte utilisateur -->
  <form method="post" class="d-flex flex-column" enctype="multipart/form-data">
    <!-- titre -->
    <h1 class="mb-4 text-center text-white headline-text">Créer un compte</h1>


    <!-- Tous les champs du formulaire de l'utilisateur -->
    <div class="d-flex flex-column align-items-center content-text gap-3">
      <!-- Pseudo -->
      <div class="form-floating">
        <input type="text" name="pseudo" class="form-control
                <?= (isset($errors['pseudoEmpty'])) ? "is-invalid" : "" ?>"
          id="floatingInput" placeholder="juanes" value="<?= $pseudo ?>">
        <label for="floatingPseudo">Pseudo</label>
        <!-- Si il y a des erreurs on affiche le message d'erreur -->
        <?php if (isset($errors['pseudoEmpty'])) { ?>
          <div class="invalid-tooltip position-static small-text"><?= $errors['pseudoEmpty'] ?></div>
        <?php } ?>
      </div>
      <!-- E-mail -->
      <div class="form-floating">
        <input type="email" class="form-control <?= (isset($errors['mailEmpty'])) || (isset($errors['mailUsed'])) ? "is-invalid" : "" ?>"
          id="floatingMail" name="mail" placeholder="name@example.com" value="<?= $mail ?>">
        <label for="floatingMail">Email address</label>
        <!-- Si il y a des erreurs on affiche le message d'erreur -->
        <?php if (isset($errors['mailEmpty'])) { ?>
          <div class="invalid-tooltip position-static small-text"><?= $errors['mailEmpty'] ?></div>
          <!-- Si le mail est déjà utilisé -->
        <?php } elseif (isset($errors['mailUsed'])) { ?>
          <div class="invalid-tooltip position-static small-text"><?= $errors['mailUsed'] ?></div>
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
          <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text"><?= $errors['passwordEmpty'] ?></div>
          <!-- Si le mot de passe a moins de 12 caractères   -->
        <?php } elseif (isset($errors['passwordLen'])) { ?>
          <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text"><?= $errors['passwordLen'] ?></div>
          <!-- si le mot de passe ne respecte pas les requis d'une mot de passe secure -->
        <?php } elseif (isset($errors['passwordInfo'])) { ?>
          <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text"><?= $errors['passwordInfo'] ?></div>
        <?php } ?>

      </div>
      <!-- Sélectionner le role -->
      <div class="mt-2">
        <label for="roleSelect" class="text-center text-white content-text">Je suis : </label>
        <select class="form-select <?= (isset($errors['roleEmpty'])) ? "is-invalid" : "" ?>" name="role_id" id="roleSelect">
          <option value="<?= ($roleId) ? $roleId : "" ?>"><?= $roleName ?></option>
          <option value="1">Passager</option>
          <option value="2" class="driverRole">Chauffeur</option>
          <option value="3" class="driverRole">Chauffeur et passageur</option>
        </select>
        <!-- Si il y a des erreurs on affiche le message d'erreur -->
        <?php if (isset($errors['roleEmpty'])) { ?>
          <div class="invalid-tooltip position-static small-text"><?= $errors['roleEmpty'] ?></div>
        <?php } ?>
      </div>
    </div>

    <!-- Si l'utilisateur a un role chauffeur, alors, formulaire pour enregistrer la voiture et ses préférences -->
    <div class="mt-5 d-flex justify-content-between if-chauffeur non-chauffeur" id="driverForm">
      <!-- Enregistrez une voiture -->
      <div class="d-flex flex-column gap-3 car-form">
        <!-- Titre -->
        <h2 class="text-center text-white headline-text">Enregistrez votre voiture</h2>
        <!-- Nombre d'immatriculation -->
        <div class="car-form-div">
          <label for="immatriculation" class="form-label content-text">Plaque d’immatriculation</label>
          <input type="text" name="immatriculation" class="form-control" id="immatriculation">
        </div>
        <!-- Date d'immatriculation -->
        <div class="car-form-div">
          <label for="immatriculationDate" class="form-label content-text">Date de première immatriculation</label>
          <input type="date" name="date_premiere_immatriculation" class="form-control text-dark" id="immatriculationDate">
        </div>
        <!-- Modèle -->
        <div class="car-form-div">
          <label for="modele" class="form-label content-text">Modèle</label>
          <input type="text" name="modele" class="form-control" id="modele">
        </div>
        <!-- Marque -->
        <div class="car-form-div">
          <label for="marque" class="form-label content-text">Marque</label>
          <input type="text" name="marque" class="form-control" id="marque">
        </div>
        <!-- couleur -->
        <div class="car-form-div">
          <label for="couleur" class="form-label content-text">Couleur</label>
          <input type="text" name="couleur" class="form-control" id="couleur">
        </div>
        <!-- Sélecctioner l'energie utilisé par la voiture -->
        <div class="car-form-div">
          <label for="energy" class="text-center content-text">Énergie: </label>
          <select class="form-select " name="energie_id" id="energy">
            <option value=""></option>
            <option value="1">Électrique</option>
            <option value="2">Hybride</option>
            <option value="3">Diesel - Gazole</option>
            <option value="3">Essence</option>
            <option value="3">GPL</option>
          </select>
        </div>
      </div>
      <!-- la photo et les préférences du chauffeur -->
      <div class="d-flex flex-column gap-3 driver-form">
        <!-- Titre du profil -->
        <h2 class="text-center text-white headline-text">Votre profil</h2>
        <!-- Ajouter la photo -->
        <div>
          <label for="driverImage" class="form-label">Ajoutez votre photo du profil</label>
          <input type="file" name="photo" class="form-control" id="driverImage">
        </div>
        <!-- Ajouter les préférences -->
        <h3 class=" text-white subtitle-text">Vos préférences</h3>
        <!-- Accepte des fumeurs ? -->
        <div>
          <label for="smokerCheck" class="form-check-label content-text">J'accepte les fumeurs: </label>
          <input type="radio" class="form-check-input" name="statut" id="smokerCheck" value="1"> <span class="text-white small-text">Oui</span>
          <input type="radio" class="form-check-input" name="statut" id="smokerCheck" value="0"> <span class="text-white small-text">Non</span>
        </div>
        <!-- Accepte des animaux ? -->
        <div>
          <label for="animalCheck" class="form-check-label content-text">J'accepte les animaux: </label>
          <input type="radio" class="form-check-input" name="statut" id="animalCheck" value="1"> <span class="text-white small-text">Oui</span>
          <input type="radio" class="form-check-input" name="statut" id="animalCheck" value="0"> <span class="text-white small-text">Non</span>
        </div>

      </div>
    </div>


    <!-- Button pour créer le compte -->
    <div class="d-flex justify-content-center mt-4">
      <button class="btn btn-warning text-dark w-50 py-3 mt-3 content-text fw-medium" name="singUp" type="submit">Se registrer</button>
    </div>
    <!-- Lien si l'utilisateru a déjà un compte -->
    <div class="d-flex justify-content-center mt-5 lien content-text mb-5">
      <a href="?controller=auth&action=logIn" class="text-light">J'ai dèjà un compte</a>
    </div>

  </form>
</section>

<?php
// FOOTER
require_once './Templates/footer.php';
?>