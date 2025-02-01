// Script pour afficher la deuxième partie du formulaire d'ajouts des préférences pour le chauffuer

let preferencesForm = document.getElementById('preferencesForm');
let button = document.getElementById('btnPreferences')

button.addEventListener('click', () => {
    preferencesForm.classList.remove('hidden')
})