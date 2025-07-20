<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>

<!-- main -->

<section class="container mt-5 connection-form d-flex flex-column align-items-center">
    <!-- titre -->
    <h1 class="mb-5 text-center text-white headline-text">Enregistrez vos préférences</h1>
    <!-- Dernière partie du formulaire pour enregistrer les préférences utilisateur -->
    <form method="post" class="d-flex flex-column chauffeur w-50">
        <div class="preferences-form content-text">
            <textarea name="preference_personnelle" class="form-control" required></textarea>
            <!-- Input invisible pour envoyer un param fictif à la base de données
                    à fin de pouvoir réaliser la requête sql -->
            <input type="text" name="preference_id" value="1" hidden>
        </div>
        <!-- Bouton pour finaliser -->
        <div class="d-flex justify-content-center mt-4 mb-4">
            <button type="submit" class="btn btn-warning text-dark w-50 py-3 mt-3 content-text fw-medium"
                name="newPersonalPreference">Finaliser</button>
        </div>
        <!-- Lien si l'utilisateur veut passer cette étape -->
        <div class="d-flex justify-content-center content-text lien">
            <a href="?controller=user&action=profil" class="text-light">Passer cette étape</a>
        </div>
    </form>

</section>

<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>