// Script pour afficher ou masquer et afficher les champ du formulaire du validation du covoiturage
// en fonction de la sélection de l'utilisateur
const yesCheckedRadio = document.getElementById("yesCheckedRadio");
const noCheckedRadio = document.getElementById("noCheckedRadio");
const commentAboutTravel = document.getElementById("commentAboutTravel");

yesCheckedRadio.addEventListener("click", function () {
    commentAboutTravel.classList.remove("show");
    driverNote.classList.add("show");
})

noCheckedRadio.addEventListener("click", function () {
    commentAboutTravel.classList.add("show");
    driverNote.classList.remove("show");
})

