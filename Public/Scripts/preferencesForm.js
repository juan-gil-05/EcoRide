// Script pour afficher le formulaire pour enregistrer une nouvelle préférence dans la page du profile

// L'icon d'ajouter
const newPrefIcon = document.getElementById("newPrefIcon") ?? null
// L'icon d'editer
const editPrefIcon = document.getElementById("editPrefIcon") ?? null
// Le formulaire pour créer une nouvelle préférence
const personalPreference = document.getElementById("personalPreference") ?? null
// Le formulaire pour éditer préférence
const editPersonalPreference = document.getElementById("editPersonalPreference") ?? null

// Si on clique dans l'icon d'ajouter, alors on affiche le formualaire pour créer une nouvelle préférence
if (newPrefIcon) {
    newPrefIcon.addEventListener("click", () => {
        personalPreference.classList.toggle("hidden")
    })
}

// Si on clique dans l'icon d'editer, alors on affiche le formualaire pour éditer préférence
if (editPrefIcon) {
    editPrefIcon.addEventListener("click", () => {
        editPersonalPreference.classList.toggle("hidden")
    })
}