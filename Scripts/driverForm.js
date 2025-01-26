// Script pour afficher le formulaire d'inscription pour les chauffeurs

// Le formulaire d'inscription pour les chauffeurs
let driverForm = document.getElementById("driverForm");
// le select avec les roles des utilisateurs
let roleSelect = document.getElementById("roleSelect");

// Si l'utilisateur sélectionne le role chauffeur ou chauffeur/passager,
// alors, on affiche le formulaire
// sinon, on le masque
roleSelect.addEventListener("change", () => {
  if (roleSelect.value == "2" || roleSelect.value == "3") {
    driverForm.classList.remove("non-chauffeur");
  } else {
    driverForm.classList.add("non-chauffeur");
  }
});

