<?php
//HEADER
require_once './Templates/header.php';
?>

<!-- main -->
<section class="container covoiturage-info">
  <!-- Infomation du voyage -->
  <div class="trip-info">
    <!-- Header -->
    <div class="trip-header shadow-section">
      <!-- Le jour et la date du covoiturage -->
      <h3 class="subtitle-text"><?= $dayName . ", " . $dayNumber . " " . $monthName ?></h3>
      <!-- Prix -->
      <div class="trip-price">
        <!-- Crédits -->
        <p class="headline-text"><?= $covoiturageDetail['prix'] ?></p>
        <!-- Icon -->
        <i class="bi bi-c-circle headline-text"></i>
      </div>
    </div>
    <!-- Body -->
    <div class="trip-body shadow-section">
      <!--Les descriptions des heures du covoiturage, les lieus de départ et d'arrivée et la durée du trajet-->
      <div class="time-description">
        <!--Les hueres-->
        <div class="time content-text">
          <!-- Heure de départ -->
          <p><?= $heureDepart ?></p>
          <!-- Icon d'une fleche  -->
          <i class="bi bi-arrow-down"></i>
          <!-- Heure d'arrivée -->
          <p><?= $heureArrivee ?></p>
        </div>
        <!--Les lieus et la durée-->
        <div class="places small-text">
          <!-- Lieu de départ -->
          <p class="text-capitalize"><?= $covoiturageDetail['adresse_depart'] ?></p>
          <!-- Durée du trajet -->
          <div>Durée:
            <span>
              <?= $dureeCovoiturage->format('%Hh%I') ?>
            </span>
          </div>
          <?php if ($jours != 0) { ?>
            <div>
              <span class="fw-normal">
                <?= "+ " . $jours . " Jours" ?>
              </span>
            </div>
          <?php } ?>
          <!-- Lieu d'arrivée -->
          <p class="text-capitalize"><?= $covoiturageDetail['adresse_arrivee'] ?></p>
        </div>
      </div>
      <!--Les descriptions du covoiturage-->
      <div class="trip-description">
        <div class="descriptions content-text">
          <!-- Places disponibles -->
          <div>
            <!-- Icon -->
            <i class="bi bi-car-front-fill"></i>
            <p>Places disponibles : <span><?= $covoiturageDetail['nb_place_disponible'] ?></span></p>
          </div>
          <!-- Voyage Écologique -->
          <div>
            <!-- Icon -->
            <i class="bi bi-tree-fill"></i>
            <p>Voyage Écologique : <span><?= ($carInfo['energie'] == "Électrique") ? "Oui" : "Non" ?></span></p>
          </div>
          <!-- Énergie utilisée -->
          <div>
            <!-- Icon -->
            <i class="bi bi-lightning-charge-fill"></i>
            <p>Énergie utilisée : <span class="text-capitalize"><?= $carInfo['energie'] ?></span></p>
          </div>
          <!-- Marque du véhicule -->
          <div>
            <!-- Icon -->
            <i class="fa-solid fa-car-side"></i>
            <p>Marque du véhicule : <span class="text-capitalize"><?= $carInfo['marque'] ?></span></p>
          </div>
          <!-- Modèle du véhicule -->
          <div>
            <!-- Icon -->
            <i class="fa-solid fa-car-on"></i>
            <p>Modèle du véhicule : <span class="text-capitalize"><?= $carInfo['modele'] ?></span></p>
          </div>
        </div>
      </div>
    </div>
    <!-- Bouton pour participer au covoiturage, le bouton ouvre la modale -->
    <div class="participation-btn content-text">
      <button class="btn btn-warning shadow-section primary-btn" id="participationBtn" data-bs-toggle="modal" data-bs-target="#participateConfirmation">
        Participer
      </button>
    </div>
    <!-- Modal avec les messages d'erreur ou la confirmation pour participer au covoiturage -->
    <div class="modal fade" id="participateConfirmation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="participateConfirmationLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <!-- Le contenu de la modal -->
        <div class="modal-content">
          <!-- Bouton pour fermer la modal -->
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <!-- Si l'utilisateur n'est pas connecté, alors, on affiche un message 
            et on propose de se connecter ou créer un compte -->
          <?php if (!isset($_SESSION['user'])) { ?>
            <div class="alert alert-danger mb-0 p-5 text-center content-text" role="alert">
              <p class="mb-4"><strong>Attention :</strong> Vous devez être connecté pour participer à ce trajet.</p>
              <!-- Liens pour se connecter ou créer un compte  -->
              <div class="d-flex gap-3 justify-content-center align-items-center text-white">
                <a href="?controller=auth&action=logIn" class="btn btn-light content-text ">Se connecter</a>
                <p class="mb-0"> | </p>
                <a href="?controller=user&action=singUp" class="btn btn-light content-text ">S'inscrire</a>
              </div>
            </div>
            <!-- Si l'utilisateur participe déjà au covoiturage -->
          <?php } elseif ($isUserParticipant) { ?>
            <div class="alert alert-danger mb-0 p-5 text-center content-text" role="alert">
              <strong>Vous participez déjà à ce covoiturage.</strong><br>
              Il n’est pas possible de s’inscrire plusieurs fois au même trajet.
            </div>
            <!-- Si l'utilisateur est le chauffeur du covoiturage -->
          <?php } elseif ($isDriverInCovoiturage) { ?>
            <div class="alert alert-danger mb-0 p-5 text-center content-text" role="alert">
              <strong>Vous êtes le conducteur de ce covoiturage.</strong><br>
              En tant que chauffeur, vous ne pouvez pas vous inscrire comme passager à votre propre trajet.
            </div>
            <!-- Si le covoiturage n'a plus des places disponibles-->
          <?php } elseif ($noDisponiblePlaces) { ?>
            <div class="alert alert-danger mb-0 p-5 text-center content-text" role="alert">
              <strong>🚫 Trajet complet !</strong> Il n'y a plus de places disponibles.
            </div>
            <!-- Si l'utilisateur ne possède pas assez des crédits pour participer au covoiturage-->
          <?php } elseif ($noEnoughCredits) { ?>
            <div class="alert alert-danger mb-0 p-5 text-center content-text" role="alert">
              <strong>💰 Crédits insuffisants !</strong>
              Vous avez besoin de <?= $covoituragePrice ?> crédits pour participer, mais vous n'avez que <?= $userCredits ?> crédits.
            </div>
            <!-- Pour afficher la modale de double confimation -->
          <?php } elseif ($doubleConfirmation) { ?>
            <!-- Formulaire pour participer au covoiturage  -->
            <form method="post" class="w-100 d-flex align-items-center flex-column gap-4 p-5 text-center mb-0 bg-light form" id="participateForm">
              <!-- Input cache pour passer les donnes dans la requête sql -->
              <input type="text" name="user_id" hidden value="<?= (isset($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : "" ?>">
              <!-- Input cache pour passer les donnes dans la requête sql -->
              <input type="text" name="covoiturage_id" hidden value="<?= $covoiturageDetail['id'] ?>">
              <label class="content-text text-center fw-medium">Voulez-vous confirmer votre participation et l’utilisation de <?= $covoituragePrice ?> crédits ?</label>
              <!-- Boutons pour confirmer ou annuler -->
              <div class="d-flex gap-3 justify-content-center">
                <button type="button" value="" class="btn btn-danger shadow-section text-light content-text secondary-btn" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                <input type="submit" class="btn btn-primary shadow-section text-white content-text secondary-btn" value="Confirmer" name="participate">
              </div>
            </form>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <!-- Information du chauffeur -->
  <div class="driver-info shadow-section">
    <!-- La photo, le prenom/nom et la note du chauffuer -->
    <div class="driver-header">
      <!-- Photo, s'il n'y a pas, on affiche l'image par defaut-->
      <img
        src="../../Uploads/User/<?=
                                (!empty($driver['photo_uniqId']))
                                  ? $driver['photo_uniqId']
                                  : "../../Assets/Img_page-vue-covoiturages/driver-default.png"
                                ?>"
        alt="Image du chauffeur" />
      <!-- Nom, prenom -->
      <p class="subtitle-text text-capitalize"><?= $driver['pseudo'] ?></p>
      <!-- Note -->
      <div class="content-text driver-note">
        <!-- Icon -->
        <i class="bi bi-star-fill"></i>
        <!-- La note -->
        <p><?= (!is_null($driverNote['note'])) ? $driverNote['note'] : "-" ?> / 5</p>
      </div>
    </div>
    <!-- Section des préférences au chauffeur -->
    <div class="preferences">
      <!-- Titre -->
      <h2 class="subtitle-text">Mes préférences</h2>
      <!-- List des préférences -->
      <ul class="small-text">
        <!-- Accepte ou pas les fumeurs? -->
        <li><span>Fumeur / non-fumeur :</span>
          <!-- Si dans l'array existe la préférence fumeur, alors le chauffeur accepte les fumeurs -->
          <!-- Si dans l'array existe la préférence non_fumeur, alors le chauffeur n'accepte pas les fumeurs  -->
          <?php if (in_array("Fumeur", $preferences)) {
            echo 'J\'accepte les fumeurs';
          } elseif (in_array("Non_fumeur", $preferences)) {
            echo 'Je n\'accepte les fumeurs';
          } ?>
        </li>
        <!-- Accepte ou pas les animaux? -->
        <li><span>Animal / pas d’animal :</span>
          <!-- Si dans l'array existe la préférence animal, alors le chauffeur accepte les animaux -->
          <!-- Si dans l'array existe la préférence non_animal, alors le chauffeur n'accepte pas les animaux -->
          <?php if (in_array("Animal", $preferences)) {
            echo 'J\'accepte les animaux';
          } elseif (in_array("Non_animal", $preferences)) {
            echo 'Je n\'accepte pas les animaux';
          } ?>
        </li>
        <!-- Préférences Personnelles -->
        <?php foreach ($preferencesPersonnelles as $personnelle) { ?>
          <!-- on parcours le tableau pour récupérer chaque préférence, -->
          <!-- on fait une liste pour chaque préférence, si n'est pas vide -->
          <?php if (!empty($personnelle)) { ?>
            <li>
              <p><?= ucfirst($personnelle) ?></p>
            </li>
          <?php } ?>
        <?php } ?>
      </ul>
    </div>
    <!-- Les avis du chauffeur -->
    <div class="comments">
      <!-- Titre -->
      <h2 class="subtitle-text">Avis</h2>
      <!-- List des avis -->
      <ul>
        <!--Première avis-->
        <li>
          <div class="user-comment">
            <!-- Prenom de la personne qui laisse l'avis -->
            <p class="small-text">Pierre</p>
            <!-- Titre et note de l'avis -->
            <div class="small-text comment-title">
              <!-- Titre de l'avis -->
              <p>Super expérience !</p>
              <!-- La note de l'avis -->
              <div class="note-stars">
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
              </div>
            </div>
            <!-- L'avis -->
            <p class="small-text">
              “Très ponctuel et professionnel, le trajet s’est déroulé dans une
              ambiance agréable et détendue. La voiture était propre et
              confortable.”
            </p>
          </div>
        </li>
        <!-- Deuxième avis-->
        <li>
          <div class="user-comment">
            <!-- Prenom de la personne qui laisse l'avis -->
            <p class="small-text">Yuli</p>
            <!-- Titre et note de l'avis -->
            <div class="small-text comment-title">
              <!-- Titre de l'avis -->
              <p>Bon trajet dans l’ensemble.</p>
              <!-- La note de l'avis -->
              <div class="note-stars">
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
              </div>
            </div>
            <!-- L'avis -->
            <p class="small-text">
              “Chauffeuse sympathique et respectueuse des horaires. La conduite
              était sécurisante, mais il y avait un peu trop de musique à mon
              goût, même si cela n’a pas empêché de passer un bon moment.”
            </p>
          </div>
        </li>
        <!-- Troisième avis-->
        <li>
          <div class="user-comment">
            <!-- Prenom de la personne qui laisse l'avis -->
            <p class="small-text">Julian</p>
            <!-- Titre et note de l'avis -->
            <div class="small-text comment-title">
              <!-- Titre de l'avis -->
              <p>Au top !</p>
              <!-- La note de l'avis -->
              <div class="note-stars">
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
              </div>
            </div>
            <!-- L'avis -->
            <p class="small-text">
              “Conduite fluide et excellente communication avant le trajet. La
              chauffeuse est très amical, et sa voiture électrique rend le
              trajet encore plus agréable en sachant qu’on fait un geste pour la
              planète. Je suis entièrement satisfait !”
            </p>
          </div>
        </li>
      </ul>
    </div>
  </div>
</section>

<?php
// FOOTER
require_once './Templates/footer.php';
?>