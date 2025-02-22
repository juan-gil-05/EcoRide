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
          <div>Durée: <span><?= $dureeCovoiturage->format('%HH%I') ?></span></div>
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
    <!-- Bouton pour participer au covoiturage -->
    <div class="participation-btn content-text">
      <button class="btn btn-warning shadow-section">participer</button>
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
        <p>- / 5</p>
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
              <p><?=ucfirst($personnelle)?></p>
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