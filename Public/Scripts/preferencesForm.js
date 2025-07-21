// Script pour afficher le formulaire pour enregistrer une nouvelle préférence dans la page du profile

// L'icon d'ajouter
const newPrefIcon = document.getElementById("newPrefIcon") ?? null
// Le formulaire pour créer une nouvelle préférence
const personalPreference = document.getElementById("personalPreference") ?? null

// Si on clique dans l'icon d'ajouter, alors on affiche le formualaire pour créer une nouvelle préférence
if (newPrefIcon) {
    newPrefIcon.addEventListener("click", () => {
        personalPreference.classList.toggle("hidden")
    })
}

// Script pour afficher la deuxième partie du formulaire d'ajouts des préférences pour le chauffeur

const preferencesForm = document.getElementById("preferencesForm") ?? null
const buttonToContinue = document.getElementById("btnPreferences") ?? null

if (buttonToContinue) {
    buttonToContinue.addEventListener("click", () => {
        preferencesForm.classList.remove("hidden")
    })
}