// Script pour afficher ou masquer le champ commentaire en fonction de la sélection de l'utilisateur
const yesCheckedRadio = document.getElementById("yesCheckedRadio");
const noCheckedRadio = document.getElementById("noCheckedRadio");
const commentAboutTravel = document.getElementById("commentAboutTravel");

yesCheckedRadio.addEventListener("click", function () {
    commentAboutTravel.classList.remove("show");
})

noCheckedRadio.addEventListener("click", function () {
    commentAboutTravel.classList.add("show");
})

