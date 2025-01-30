
<!-- Deuxième partie du formulaire pour enregistrer les préferences -->
<form method="post" class="d-flex flex-column chauffeur" id="preferencesForm">
    <div class="mt-1 d-flex gap-5 preferences-form content-text">
        <!-- Accepte des animaux ? -->
        <div class="d-flex gap-2">
            <label for="animalCheck" class="form-check-label content-text">J'accepte les animaux: </label>
            <input type="radio" class="form-check-input" name="preference_id" id="animalCheck" value="2"> <span class="text-white small-text">Oui</span>
            <input type="radio" class="form-check-input" name="preference_id" id="animalCheck" value="4"> <span class="text-white small-text">Non</span>
        </div>
        <!-- Ajouter des préférences personnelles -->
        <div class="d-flex flex-column gap-2">
            <label for="preference_personnelle">Ajoutez une nouvelle préférence: </label>
            <input type="text" name="preference_personnelle" id="preference_personnelle">
        </div>
    </div>
    <!-- Button pour finaliser -->
    <div class="d-flex justify-content-center mt-4 mb-5">
        <button class="btn btn-warning text-dark w-50 py-3 mt-3 content-text fw-medium"
            name="prefInscription2" type="submit">Finaliser</button>
    </div>
</form>