<?php
// HEADER
require_once BASE_PATH . '/Templates/header.php';

use App\Security\Security;
?>

<!-- main -->
<?php if (Security::isLogged()) { ?>
  <h4>bienvenue <?= $_SESSION['user']['pseudo'] ?></h4>
  <?php if (Security::isPassager()) { ?>
    <h4>Vous êtes passager<br></h4>
  <?php } elseif (Security::isChauffeur()) { ?>
    <h4>Vous êtes chauffeur<br></h4>
  <?php } elseif (Security::isEmploye()) { ?>
    <h4>Vous êtes Employé<br></h4>
  <?php } elseif (Security::isAdmin()) { ?>
    <h4>Vous êtes Administrateur<br></h4>
  <?php } ?>
<?php } ?>

<!-- Section qui contient le slogan et la barre de recherche des covoiturages -->
<section>
  <div class="slogan" id="slogan">
    <!-- Slogan du site -->
    <h2 class="subtitle-text text-white">
      Voyagez avec EcoRide <br />
      le covoiturage écologique à votre portée.
    </h2>
    <!-- Bar de recherche des covoiturages -->
    <div class="search-bar container" id="searchBar">
      <!-- Formulaire pour réaliser la recherche -->
      <form method="get">
        <!-- les adresses de départ et d'arrivée -->
        <div class="d-flex">
          <!-- adresses de départ -->
          <div>
            <!-- Icon -->
            <i class="bi bi-record-circle"></i>
            <input type="text" name="adresse_depart" id="" placeholder="Adresse de départ"
              value="<?= $adresseDepart ?>"
              class="form-control content-text <?= (isset($errors['adresseDepartEmpty'])) ? "is-invalid" : "" ?>" />
            <!-- Si il y a des erreurs on affiche le message d'erreur -->
            <?php if (isset($errors['adresseDepartEmpty'])) { ?>
              <div class="invalid-tooltip position-static small-text"><?= $errors['adresseDepartEmpty'] ?></div>
            <?php } ?>
          </div>
          <!-- adresses d'arrivée -->
          <div>
            <!-- Icon -->
            <i class="bi bi-geo-alt-fill"></i>
            <input type="text" name="adresse_arrivee" id="" placeholder="Adresse d’arrivée"
              value="<?= $adresseArrivee ?>"
              class="form-control content-text <?= (isset($errors['adresseArriveeEmpty'])) ? "is-invalid" : "" ?>" />
            <?php if (isset($errors['adresseArriveeEmpty'])) { ?>
              <div class="invalid-tooltip position-static small-text"><?= $errors['adresseArriveeEmpty'] ?></div>
            <?php } ?>
          </div>
        </div>
        <!-- La date -->
        <div class="d-flex">
          <!-- La date -->
          <div class="date">
            <!-- Icon -->
            <i class="bi bi-calendar2-week-fill"></i>
            <input type="date" name="date_heure_depart" id="" value="<?= $dateDepart ?>"
              class="form-control content-text <?= (isset($errors['dateDepartEmpty'])) ? "is-invalid" : "" ?>" />
            <!-- Si il y a des erreurs on affiche le message d'erreur -->
            <?php if (isset($errors['dateDepartEmpty'])) { ?>
              <div class="invalid-tooltip position-static small-text"><?= $errors['dateDepartEmpty'] ?></div>
            <?php } ?>
          </div>
        </div>
        <!-- Si la variable covoiturageCloser n'est pas vide, c'est à dire qu'on n'a pas trouvé un covoiturage 
        dans la date indiquée par l'utilisateur, alors, on affiche le message pour proposer au visiteur de modifier 
        sa date de voyage à la date du premier itinéraire le plus proche. -->
        <?php if (!empty($covoiturageCloser)) { ?>
          <div class="alert alert-warning p-2 m-0 border border-dark" id="covoiturageNotFound">
            <!-- Affichage du message avec la date du covoiturage plus proche -->
            <p class="small-text mb-0">Désolé, aucun covoiturage n'est disponible à cette date.
              <br> Cependant, nous avons trouvé une alternative proche : <?= $newDateDepart->format("d-m-Y") ?>. Souhaitez-vous la consulter ?
            </p>
          </div>
          <!-- Si la variable noCovoiturageFoundMsg n'est pas vide, c'est à dire qu'on n'a pas trouvé un covoiturage 
        avec les données indiquée par l'utilisateur, alors, on affiche le message pour informer qu'il n'existe pas des
        covoiturages avec ces adresses. -->
        <?php } elseif (!empty($noCovoiturageFoundMsg)) { ?>
          <div class="alert alert-danger p-2 m-0 border border-dark" id="covoiturageNotFound">
            <!-- Affichage du message -->
            <p class="small-text mb-0"><?= $noCovoiturageFoundMsg ?></p>
          </div>
        <?php } ?>
        <!-- Boutton de recherche -->
        <div class="d-flex">
          <!-- Le boutton -->
          <div class="search-btn">
            <button class="btn btn-primary primary-btn" type="submit" name="search">Rechercher</button>
          </div>
      </form>
    </div>
  </div>
</section>
<!-- Sections des descriptions de l'entreprise -->
<!-- Première description-->
<section class="shadow-section">
  <div class="description description-1">
    <div class="container">
      <!--Image de la description-->
      <div class="img-description">
        <img
          src="../Assets/Img_page-accueil/description-1.webp"
          alt=""
          class="img-1" />
      </div>
      <!--Text de la description-->
      <div class="text-description content-text">
        <p>
          EcoRide est une plateforme de covoiturage innovante et engagée, dédiée
          à réduire l’impact environnemental des déplacements. Fondée en France,
          notre mission est de connecter les voyageurs soucieux de l’écologie et
          de l’économie pour des trajets plus responsables.
        </p>
      </div>
    </div>
  </div>
</section>
<!-- Deuxième description-->
<section class="shadow-section">
  <div class="description description-2">
    <div class="container">
      <!--Text de la description-->
      <div class="text-description content-text text-white">
        <p>
          En privilégiant les véhicules électriques et en optimisant les trajets
          partagés, EcoRide contribue à un avenir plus durable, tout en offrant
          des solutions économiques et conviviales. Ensemble, faisons rimer
          mobilité avec écologie!
        </p>
      </div>
      <!--Image de la description-->
      <div class="img-description">
        <img
          src="../Assets/Img_page-accueil/description-2.webp"
          alt=""
          class="img-2" />
      </div>
    </div>
  </div>
</section>

<!-- On appel le script ici car après faire un récherche s'il y a des erreurs, on n'a plus l'action dans l'url
    et donc, le footer n'appel pas le script -->
<script src="../Scripts/searchCovoiturage.js"></script>

<?php
// FOOTER
require_once BASE_PATH . '/Templates/footer.php';
?>