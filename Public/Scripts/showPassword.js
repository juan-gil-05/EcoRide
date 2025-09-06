// Script pour afficher et masquer le mot de passe

// Icon du petit oeil
const showPasswordIcon = document.getElementById("showPasswordIcon")
// Label qui contient le mot de passe
const passwordLabel = document.getElementById("floatingPassword")

showPasswordIcon.addEventListener("click", function () {
  // Si on clique l'icon on affiche le mot de passe
  if (passwordLabel.type == "password") {
    passwordLabel.type = "text"
    showPasswordIcon.classList.toggle("bi-eye")
    showPasswordIcon.classList.toggle("bi-eye-slash")
  } else {
    // Si le mot de passe est déjà visible et qu'on clique l'icon, 
    // alors, on le masque
    passwordLabel.type = "password"
    showPasswordIcon.classList.toggle("bi-eye-slash")
    showPasswordIcon.classList.toggle("bi-eye")
  }
})
