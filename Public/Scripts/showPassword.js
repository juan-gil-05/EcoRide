// Script pour afficher et masquer le mot de passe

// Icon du petit carré
const icon = document.getElementById("showPasswordIcon")
// Label qui contient le mot de passe
const password = document.getElementById("floatingPassword")

icon.addEventListener("click", function () {
  // Si on clique l'icon on affiche le mot de passe
  if (password.type == "password") {
    password.type = "text"
    icon.classList.toggle("bi-eye")
    icon.classList.toggle("bi-eye-slash")
  } else {
    // Si le mot de passe est déjà visible et qu'on clique l'icon, alors, on le masque
    password.type = "password"
    icon.classList.toggle("bi-eye-slash")
    icon.classList.toggle("bi-eye")
  }
})
