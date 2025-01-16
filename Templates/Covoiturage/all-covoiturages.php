<?php
// HEADER
require_once './Templates/header.php';
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
      <form action="">
        <!-- Filtre du Voyage Écologique -->
        <div>
          <!-- Icon du filtre -->
          <i class="bi bi-tree"></i>
          <!-- Nom du filtre -->
          <label for="">Voyage Écologique</label>
          <!-- Filtre -->
          <i class="bi bi-circle"></i>
        </div>
        <!-- Filtre du Prix maximum -->
        <div>
          <!-- Icon du filtre -->
          <i class="bi bi-cash"></i>
          <!-- Nom du filtre -->
          <label for="">Prix maximum</label>
          <!-- Filtre -->
          <input type="number" />
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
      </form>
    </div>
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
        placeholder="Lyon -> Paris"
        class="shadow-section search-input"
      />
      <!-- Bouton pour afficher les filtres quand on est en mobile ou tablet -->
      <button
        class="btn btn-secondary filter-btn small-text"
        data-bs-toggle="modal"
        data-bs-target="#filterModal"
      >
        <i class="bi bi-filter"></i>Filtrer
      </button>
    </div>
    <!-- Modal des filtres en mode mobile et tablet-->
    <div
      class="modal fade"
      id="filterModal"
      tabindex="-1"
      aria-labelledby="filterModalLabel"
      aria-hidden="true"
    >
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
            <form action="" class="filter-body content-text">
              <!-- Filtre du Voyage Écologique -->
              <div>
                <!-- Icon du filtre -->
                <i class="bi bi-tree"></i>
                <!-- Nom du filtre -->
                <label for="">Voyage Écologique</label>
                <!-- Filtre -->
                <i class="bi bi-circle"></i>
              </div>
              <!-- Filtre du Prix maximum -->
              <div>
                <!-- Icon du filtre -->
                <i class="bi bi-cash"></i>
                <!-- Nom du filtre -->
                <label for="">Prix maximum</label>
                <!-- Filtre -->
                <input type="number" />
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
            </form>
          </div>
          <!-- Footer de la modal -->
          <div class="modal-footer">
            <!-- Bouton pour annuler l'ajout des filtres -->
            <button
              type="button"
              class="btn btn-danger content-text text-white"
              data-bs-dismiss="modal"
            >
              Annuler
            </button>
            <!-- Bouton pour appliquer des filtres -->
            <button
              type="button"
              class="btn btn-primary content-text text-white"
            >
              Appliquer
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Le jour et la date du covoiturage -->
    <h2 class="subtitle-text">Dimanche, 25 Nov.</h2>

    <!-- Les cartes avec les résultats des tous les covoiturages -->
    <div class="travel-card">
      <!-- Le contenu du covoiturage -->
      <div class="travel-content">
        <!-- Heure de départ et d'arrivée -->
        <div class="travel-time content-text">
          <!-- Heure de départ -->
          <p>06:10</p>
          <!-- Icon d'une fleche  -->
          <i class="bi bi-arrow-down"></i>
          <!-- Heure d'arrivée -->
          <p>09:50</p>
        </div>
        <!-- déscriptions -->
        <div class="travel-description content-text">
          <!-- Lieu de départ -->
          <div>Lyon, France</div>
          <!-- Places disponibles -->
          <div>
            <!-- Icon -->
            <i class="bi bi-car-front-fill"></i>
            <p>Places disponibles : <span>1</span></p>
          </div>
          <!-- Voyage Écologique -->
          <div>
            <!-- Icon -->
            <i class="bi bi-tree-fill"></i>
            <p>Voyage Écologique : <span>Oui</span></p>
          </div>
          <!-- Lieu d'arrivée -->
          <div>Paris, France</div>
        </div>
        <!-- Prix -->
        <div class="travel-price subtitle-text">
          <!-- Euros -->
          <p class="headline-text">30,</p>
          <!-- Céntimes -->
          <p class="content-text">15</p>
          <!-- Icon -->
          <i class="bi bi-currency-euro headline-text"></i>
        </div>
      </div>
      <!-- Profil du chauffeur-->
      <div class="driver-profile">
        <!-- Photo et prenom/nom -->
        <div class="driver-img">
          <!-- Photo -->
          <img
            src="../Assets/Img_page-vue-covoiturages/avatars/avatar1.webp"
            alt="Image du chauffeur"
          />
          <!-- Nom, prenom -->
          <p class="content-text">Azélie Joly</p>
        </div>
        <!-- Note -->
        <div class="content-text driver-note">
          <!-- Icon -->
          <i class="bi bi-star-fill"></i>
          <!-- La note -->
          <p>4,8</p>
        </div>
        <!-- Bouton pour voir plus en détail le covoiturage -->
        <div class="content-text">
          <a href="?controller=covoiturages&action=showOne"><button class="btn btn-warning">Détail</button></a>
        </div>
      </div>
    </div>
    <!-- Les cartes avec les résultats des tous les covoiturages -->
    <div class="travel-card">
      <!-- Le contenu du covoiturage -->
      <div class="travel-content">
        <!-- Heure de départ et d'arrivée -->
        <div class="travel-time content-text">
          <!-- Heure de départ -->
          <p>06:10</p>
          <!-- Icon d'une fleche  -->
          <i class="bi bi-arrow-down"></i>
          <!-- Heure d'arrivée -->
          <p>09:50</p>
        </div>
        <!-- déscriptions -->
        <div class="travel-description content-text">
          <!-- Lieu de départ -->
          <div>Lyon, France</div>
          <!-- Places disponibles -->
          <div>
            <!-- Icon -->
            <i class="bi bi-car-front-fill"></i>
            <p>Places disponibles : <span>1</span></p>
          </div>
          <!-- Voyage Écologique -->
          <div>
            <!-- Icon -->
            <i class="bi bi-tree-fill"></i>
            <p>Voyage Écologique : <span>Oui</span></p>
          </div>
          <!-- Lieu d'arrivée -->
          <div>Paris, France</div>
        </div>
        <!-- Prix -->
        <div class="travel-price subtitle-text">
          <!-- Euros -->
          <p class="headline-text">30,</p>
          <!-- Céntimes -->
          <p class="content-text">15</p>
          <!-- Icon -->
          <i class="bi bi-currency-euro headline-text"></i>
        </div>
      </div>
      <!-- Profil du chauffeur-->
      <div class="driver-profile">
        <!-- Photo et prenom/nom -->
        <div class="driver-img">
          <!-- Photo -->
          <img
            src="../Assets/Img_page-vue-covoiturages/avatars/avatar1.webp"
            alt="Image du chauffeur"
          />
          <!-- Nom, prenom -->
          <p class="content-text">Azélie Joly</p>
        </div>
        <!-- Note -->
        <div class="content-text driver-note">
          <!-- Icon -->
          <i class="bi bi-star-fill"></i>
          <!-- La note -->
          <p>4,8</p>
        </div>
        <!-- Bouton pour voir plus en détail le covoiturage -->
        <div class="content-text">
          <a href="?controller=covoiturages&action=showOne"><button class="btn btn-warning">Détail</button></a>
        </div>
      </div>
    </div>
    <!-- Les cartes avec les résultats des tous les covoiturages -->
    <div class="travel-card">
      <!-- Le contenu du covoiturage -->
      <div class="travel-content">
        <!-- Heure de départ et d'arrivée -->
        <div class="travel-time content-text">
          <!-- Heure de départ -->
          <p>06:10</p>
          <!-- Icon d'une fleche  -->
          <i class="bi bi-arrow-down"></i>
          <!-- Heure d'arrivée -->
          <p>09:50</p>
        </div>
        <!-- déscriptions -->
        <div class="travel-description content-text">
          <!-- Lieu de départ -->
          <div>Lyon, France</div>
          <!-- Places disponibles -->
          <div>
            <!-- Icon -->
            <i class="bi bi-car-front-fill"></i>
            <p>Places disponibles : <span>1</span></p>
          </div>
          <!-- Voyage Écologique -->
          <div>
            <!-- Icon -->
            <i class="bi bi-tree-fill"></i>
            <p>Voyage Écologique : <span>Oui</span></p>
          </div>
          <!-- Lieu d'arrivée -->
          <div>Paris, France</div>
        </div>
        <!-- Prix -->
        <div class="travel-price subtitle-text">
          <!-- Euros -->
          <p class="headline-text">30,</p>
          <!-- Céntimes -->
          <p class="content-text">15</p>
          <!-- Icon -->
          <i class="bi bi-currency-euro headline-text"></i>
        </div>
      </div>
      <!-- Profil du chauffeur-->
      <div class="driver-profile">
        <!-- Photo et prenom/nom -->
        <div class="driver-img">
          <!-- Photo -->
          <img
            src="../Assets/Img_page-vue-covoiturages/avatars/avatar1.webp"
            alt="Image du chauffeur"
          />
          <!-- Nom, prenom -->
          <p class="content-text">Azélie Joly</p>
        </div>
        <!-- Note -->
        <div class="content-text driver-note">
          <!-- Icon -->
          <i class="bi bi-star-fill"></i>
          <!-- La note -->
          <p>4,8</p>
        </div>
        <!-- Bouton pour voir plus en détail le covoiturage -->
        <div class="content-text">
          <a href="?controller=covoiturages&action=showOne"><button class="btn btn-warning">Détail</button></a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
// FOOTER
require_once './Templates/footer.php';
?>