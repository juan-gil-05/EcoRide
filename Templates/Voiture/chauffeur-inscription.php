<?php
// HEADER
require_once './Templates/header.php';
var_dump($_SESSION['user']);
var_dump($_POST)

?>

<!-- main -->

<section class="container mt-5 connection-form">
  <!-- Formulaire pour créer un compte utilisateur -->
  <form method="post" class="d-flex flex-column" enctype="multipart/form-data">
    <!-- titre -->
    <h1 class="mb-4 text-center text-white headline-text">Finalisez votre inscription</h1>

    <!-- Si l'utilisateur a un role chauffeur, alors, formulaire pour enregistrer la voiture et ses préférences -->
    <div class="mt-5 d-flex justify-content-between chauffeur" id="driverForm">
      <!-- Enregistrez une voiture -->
      <div class="d-flex flex-column gap-3 car-form">
        <!-- Titre -->
        <h2 class="text-center text-white headline-text">Ajoutez votre voiture</h2>
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
        <!-- Ajouter les préférences -->
        <h2 class=" text-white headline-text">Vos préférences</h2>
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
      <button class="btn btn-warning text-dark w-50 py-3 mt-3 content-text fw-medium" name="driverInscription" type="submit">Se registrer</button>
    </div>

  </form>
</section>

<?php
// FOOTER
require_once './Templates/footer.php';
?>