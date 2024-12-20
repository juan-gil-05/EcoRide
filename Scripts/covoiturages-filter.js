// Event pour remplir le circle du filtre du voyage écologique quand on le clique
// Ajout de la classe "bi-circle-fill" au clique
const circleCheck = document.querySelectorAll(".bi-circle");
circleCheck.forEach((circle) =>
  circle.addEventListener("click", function () {
    this.classList.toggle("bi-circle");
    this.classList.toggle("bi-circle-fill");
  })
);

//-------------------------------------------------------------------------------------------------------------------

// On récupere tous les étoiles du filtre de la note du chauffeur
const allStar = document.querySelectorAll(".star");
// Event pour rémplir les étoiles au clique
allStar.forEach((star, index) => {
  star.addEventListener("click", () => {
    // Verification si l'étoile cliqué a déjà la class "active-star"
    const isLastActive =
      index + 1 === document.querySelectorAll(".active-star").length;

    // Si oui, on démarque tous les étoiles
    if (isLastActive) {
      allStar.forEach((s) => s.classList.remove("active-star"));
    }
    // Sinon,
    else {
      // on active les étoiles jusqu'à l'étoile sélectionnée
      for (let i = 0; i <= index; i++) {
        allStar[i].classList.add("active-star");
      }
      // Et on désactive les étoiles suivantes
      for (let i = index + 1; i < allStar.length; i++) {
        allStar[i].classList.remove("active-star");
      }
    }
  });
});
