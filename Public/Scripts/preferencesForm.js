// Script pour afficher le formulaire pour enregistrer une nouvelle préférence dans la page du profile

// L'icon d'ajouter
const newPrefIcon = document.getElementById("newPrefIcon") ?? null
// L'icon d'editer
const editPrefIcon = document.querySelectorAll(".editPrefIcon") ?? null
// Le formulaire pour créer une nouvelle préférence
const personalPreference = document.getElementById("personalPreference") ?? null

// Si on clique dans l'icon d'ajouter, alors on affiche le formualaire pour créer une nouvelle préférence
if (newPrefIcon) {
    newPrefIcon.addEventListener("click", () => {
        personalPreference.classList.toggle("hidden")
    })
}

// Si on clique dans l'icon d'editer, alors on affiche le formulaire pour éditer préférence
if (editPrefIcon) {
    editPrefIcon.forEach((button) => {
        button.addEventListener("click", () => {
            // Pour récuperer le data-index du bouton, afin d'ouvrir
            // le formulaire correct 
            const btnIndex = button.dataset.index
            const formToShow = document.querySelector(`.editPersonalPreference[data-index="${btnIndex}"]`)
            if (formToShow) {
                formToShow.classList.toggle("hidden")
            }
        })
    })
}