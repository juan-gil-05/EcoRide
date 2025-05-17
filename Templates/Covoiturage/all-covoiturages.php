<?php
// HEADER

use App\Security\Security;

require_once  BASE_PATH . '/Templates/header.php';
?>


<!-- main -->
<section class="covoiturages container">
  <!-- Section des filtres du covoiturages -->
  <div class="filter">
    <!-- Le header de la section de filtres -->
    <div class="filter-header shadow-section">
      <!--Titre-->
      <h3 class="subtitle-text">Filtrer</h3>
      <!--Icon de filtre-->
      <i class="bi bi-filter"></i>
    </div>
    <!-- Le corp de la section de filtres -->
    <div class="filter-body content-text shadow-section">
      <!-- Formulaire pour les filtres de la section des covoiturages -->
      <form method="post">
        <!-- Filtre du Voyage Écologique -->
        <div>
          <!-- Icon du filtre -->
          <i class="bi bi-tree"></i>
          <!-- Nom du filtre -->
          <label for="">Voyage Écologique</label>
          <!-- Le filtre -->
          <input class="form-check-input" type="checkbox" name="ecologique" <?= (!empty($_POST['ecologique'])) ? "checked" : "" ?> />
        </div>
        <!-- Filtre du Prix maximum -->
        <div>
          <!-- Icon du filtre -->
          <i class="bi bi-c-circle"></i>
          <!-- Nom du filtre -->
          <label for="price">Prix maximum</label>
          <!-- Filtre -->
          <input type="number" class="small-text form-control d-inline" name="maxPrice" id="price" value="<?= $maxPrice ?>" />
        </div>
        <!-- Filtre de la Durée maximum -->
        <div>
          <!-- Icon du filtre -->
          <i class="bi bi-clock"></i>
          <!-- Nom du filtre -->
          <label for="Duration">Durée maximale</label>
          <!-- Filtre -->
          <input type="number" class="small-text form-control d-inline" name="maxDuration" id="Duration" value="<?= $maxDuration ?>" />
        </div>
        <!-- Filtre de la Note minimal -->
        <div class="note-filter mb-1">
          <!-- Icon du filtre -->
          <i class="bi bi-star"></i>
          <!-- Nom du filtre -->
          <label for="">Note minimale</label>
          <!-- Étoiles pour filtrer la note minimal -->
          <div class="note-stars">
            <!-- Input caché pour envoyer la valeur de la note du chauffeur, selon la quantité des étoiles séléctionées -->
            <input type="hidden" name="note" id="inputNote" value=""></input>
            <?php for ($i = 1; $i <= 5; $i++) { ?>
              <i class="bi bi-star-fill star <?= (in_array($i, $driverFilterNoteArray)) ? "active-star" : "" ?>" data-value="<?= $i ?>"></i>
            <?php } ?>
          </div>
        </div>
        <!-- Bouton pour filtrer -->
        <div class="w-100 d-flex justify-content-center small-text">
          <button class="btn btn-secondary text-white secondary-btn" type="submit" name="filter">Appliquer</button>
        </div>
      </form>
    </div>
    <!-- Bouton pour visualiser les covoiturages de l'utilisateur en mode desktop -->
    <?php if (Security::isLogged()) { ?>
      <div class="mt-5 text-center mes-covoiturages-btn content-text">
        <a href="?controller=covoiturages&action=mesCovoiturages" class="btn btn-warning primary-btn shadow-section">Mes covoiturages</a>
      </div>
    <?php } ?>
  </div>

  <!-- Section de les résultats de la récherche des covoiturages -->
  <div class="covoiturage-results">
    <!-- Barre de recherche des covoiturages -->
    <div class="search-bar-covoiturage subtitle-text">
      <!-- Icon de recherche -->
      <i class="bi bi-search"></i>
      <!-- Input avec le l'adresse de départ et d'arrivée comme placeholder -->
      <input
        type="text"
        placeholder="<?= $adresseDepart . ' -> ' . $adresseArrivee ?>"
        class="shadow-section search-input text-capitalize" />
      <!-- Bouton pour afficher les filtres quand on est en mobile ou tablet -->
      <button
        class="btn btn-secondary filter-btn small-text"
        data-bs-toggle="modal"
        data-bs-target="#filterModal">
        <i class="bi bi-filter"></i>Filtrer
      </button>
    </div>
    <!-- Modal des filtres en mode mobile et tablet-->
    <div
      class="modal fade"
      id="filterModal"
      tabindex="-1"
      aria-labelledby="filterModalLabel"
      aria-hidden="true">
      <!-- Contenu de la modal -->
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Header de la modal -->
          <div class="modal-header">
            <h1 class="modal-title fs-5 subtitle-text" id="filterModalLabel">
              Filtrer
            </h1>
          </div>
          <!-- Body de la modal -->
          <div class="modal-body">
            <!-- Formulaire pour les filtres de la section des covoiturages -->
            <form method="post" class="filter-body content-text">
              <!-- Filtre du Voyage Écologique -->
              <div>
                <!-- Icon du filtre -->
                <i class="bi bi-tree"></i>
                <!-- Nom du filtre -->
                <label for="">Voyage Écologique</label>
                <!-- Filtre -->
                <input class="form-check-input" type="checkbox" <?= (!empty($_POST['ecologique'])) ? "checked" : "" ?> name="ecologique" />
              </div>
              <!-- Filtre du Prix maximum -->
              <div>
                <!-- Icon du filtre -->
                <i class="bi bi-c-circle"></i>
                <!-- Nom du filtre -->
                <label for="price">Prix maximum</label>
                <!-- Filtre -->
                <input type="number" name="maxPrice" id="price" value="<?= $maxPrice ?>" />
              </div>
              <!-- Filtre de la Durée maximum -->
              <div>
                <!-- Icon du filtre -->
                <i class="bi bi-clock"></i>
                <!-- Nom du filtre -->
                <label for="">Durée maximum</label>
                <!-- Filtre -->
                <input type="time" class="small-text" />
              </div>
              <!-- Filtre de la Note minimal -->
              <div class="note-filter">
                <!-- Icon du filtre -->
                <i class="bi bi-star"></i>
                <!-- Nom du filtre -->
                <label for="">Note minimale</label>
                <!-- Étoiles pour filtrer la note minimal -->
                <div class="note-stars">
                  <i class="bi bi-star-fill star"></i>
                  <i class="bi bi-star-fill star"></i>
                  <i class="bi bi-star-fill star"></i>
                  <i class="bi bi-star-fill star"></i>
                  <i class="bi bi-star-fill star"></i>
                </div>
              </div>
              <!-- Footer de la modal -->
              <div class="modal-footer mb-0">
                <!-- Bouton pour annuler l'ajout des filtres -->
                <button
                  type="button"
                  class="btn btn-danger content-text text-white"
                  data-bs-dismiss="modal">
                  Annuler
                </button>
                <!-- Bouton pour appliquer des filtres -->
                <button
                  type="submit"
                  class="btn btn-secondary content-text text-white" name="filter">
                  Appliquer
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Le jour et la date du covoiturage, et le bouton pour visualiser les covoiturages de l'utilisateur -->
    <div class="d-flex align-items-center mt-3 mb-3 justify-content-between">
      <!-- Le jour et la date du covoiturage -->
      <h2 class="subtitle-text"><?= $dayName . ", " . $dayNumber . " " . $monthName ?></h2>

      <!-- Bouton pour visualiser les covoiturages de l'utilisateur en mode mobile -->
      <div class="text-center mes-covoiturages-btn-mobile content-text">
        <a href="?controller=covoiturages&action=mesCovoiturages" class="btn btn-warning shadow-section">Mes covoiturages</a>
      </div>
    </div>

    <!-- Les cartes avec les résultats de tous les covoiturages -->
    <?php
    if (!empty($covoiturages)) {
      foreach ($covoiturages as $covoiturage) { ?>
        <div class="travel-card">
          <!-- Le contenu du covoiturage -->
          <div class="travel-content">
            <!-- Heure de départ et d'arrivée -->
            <div class="travel-time content-text">
              <!-- Heure de départ -->
              <!-- On utilise la fonction substr pour afficher juste les heures et les minutes -->
              <p><?= substr($covoiturage['date_heure_depart'], 11, 5) ?></p>
              <!-- Icon d'une fleche  -->
              <i class="bi bi-arrow-down"></i>
              <!-- Heure d'arrivée -->
              <!-- On utilise la fonction substr pour afficher juste les heures et les minutes -->
              <p><?= substr($covoiturage['date_heure_arrivee'], 11, 5) ?></p>
            </div>
            <!-- déscriptions -->
            <div class="travel-description content-text">
              <!-- Lieu de départ -->
              <div class="text-capitalize"><?= $covoiturage['adresse_depart'] ?></div>
              <!-- Places disponibles -->
              <div>
                <!-- Icon -->
                <i class="bi bi-car-front-fill"></i>
                <p>Places disponibles : <span><?= $covoiturage['nb_place_disponible'] ?></span></p>
              </div>
              <!-- Voyage Écologique -->
              <div>
                <!-- Icon -->
                <i class="bi bi-tree-fill"></i>
                <p>Voyage Écologique : <span>
                    <!-- Si l'énergie id est égal à 1 : (Électrique), alor le voyage est écologique -->
                    <?= ($energieByCovoiturageId[$covoiturage['id']]['energie_id'] == 1) ? "Oui" : "Non" ?>
                  </span></p>
              </div>
              <!-- Lieu d'arrivée -->
              <div class="text-capitalize"><?= $covoiturage['adresse_arrivee'] ?></div>
            </div>
            <!-- Prix -->
            <div class="travel-price subtitle-text">
              <!-- Euros -->
              <p class="headline-text"><?= $covoiturage['prix'] ?></p>
              <!-- Icon du crédit-->
              <i class="bi bi-c-circle"></i>
            </div>
          </div>

          <!-- Profil du chauffeur et bouton de détail-->
          <div class="driver-profile">
            <!-- Photo et prenom/nom -->
            <div class="driver-img">
              <!-- Photo, s'il n'y a pas, on affiche l'image par defaut-->
              <img
                src="../../Uploads/User/<?=
                                        (!empty($driversByCovoiturageId[$covoiturage['id']]['photo_uniqId']))
                                          ? $driversByCovoiturageId[$covoiturage['id']]['photo_uniqId']
                                          : "../../Assets/Img_page-vue-covoiturages/driver-default.png"
                                        ?>"
                alt="Image du chauffeur" />
              <!-- Nom, prenom -->
              <p class="content-text"><?= $driversByCovoiturageId[$covoiturage['id']]['pseudo'] ?></p>
            </div>
            <!-- Note -->
            <div class="content-text driver-note">
              <!-- Icon -->
              <i class="bi bi-star-fill"></i>
              <!-- La note -->
              <p><?= (!is_null($driverNote[$covoiturage['id']]['note'])) ? $driverNote[$covoiturage['id']]['note'] : "-" ?> / 5</p>
            </div>
            <!-- Bouton pour voir plus en détail le covoiturage -->
            <div class="content-text">
              <a href="?controller=covoiturages&action=showOne&id=<?= $covoiturageEncryptId[$covoiturage['id']] ?>" class="btn btn-warning secondary-btn">
                Détail
              </a>
            </div>
          </div>
        </div>
      <?php  }
    } else { ?>
      <h3 class="text-center headline-text">
        <a class="text-white" href="?controller=page&action=accueil">Pas de covoiturages</a>
      </h3>
    <?php }
    ?>

  </div>
</section>

<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>