<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>

<!-- main -->
<section class="container my-5 bg-light shadow-lg rounded-4 p-4 p-md-5 d-flex flex-column 
        align-items-center connection-form">
    <!-- titre -->
    <h1 class="text-primary fw-bold mb-5 headline-text text-center">Enregistrez vos préférences</h1>
    <!-- Dernière partie du formulaire pour enregistrer les préférences utilisateur -->
    <form method="post" class="w-100">
        <div class="row justify-content-center">
            <div class="card shadow-sm rounded-3 p-4 col-12 col-md-6 text-center">
                <!-- Préférence personnelle -->
                <div class="d-flex flex-column justify-content-center gap-3 align-items-center content-text">
                    <label class="form-check-label content-text fw-semibold" for="personalPreference">
                        Préférence personnelle:
                    </label>
                    <textarea name="preference_personnelle" class="form-control bg-light small-text text-dark"
                        id="personalPreference" placeholder="Ex: J'écoute pop en anglais" required></textarea>
                    <!-- Input invisible pour envoyer un param fictif à la base de données
                    à fin de pouvoir réaliser la requête sql -->
                    <input type="text" name="preference_id" value="1" hidden>
                </div>
            </div>
        </div>
        </div>
        <!-- Bouton pour finaliser -->
        <div class="row justify-content-center">
            <div class="d-flex justify-content-center mt-4 col-12 col-md-6">
                <button class="btn btn-warning btn-lg fw-semibold text-dark w-50 w-md-25 content-text"
                    name="newPersonalPreference" type="submit">Finaliser</button>
            </div>
        </div>
        <!-- Lien si l'utilisateur veut passer cette étape -->
        <div class="d-flex justify-content-center content-text lien mt-3">
            <a href="/user/profil" class="text-dark">Passer cette étape</a>
        </div>
    </form>

</section>

<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>