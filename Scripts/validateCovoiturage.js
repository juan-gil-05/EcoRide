// Script pour afficher ou masquer et afficher les champ du formulaire du validation du covoiturage
// en fonction de la sélection de l'utilisateur
const yesCheckedRadio = document.getElementById("yesCheckedRadio");
const noCheckedRadio = document.getElementById("noCheckedRadio");
const commentAboutTravel = document.getElementById("commentAboutTravel");
const driverNote = document.getElementById("driverNote");
const driverComment = document.getElementById("driverComment");

yesCheckedRadio.addEventListener("click", function () {
    commentAboutTravel.classList.remove("show");
    driverNote.classList.remove("hidden");
    driverComment.classList.remove("hidden")
})

noCheckedRadio.addEventListener("click", function () {
    commentAboutTravel.classList.add("show");
    driverNote.classList.add("hidden");
    driverComment.classList.add("hidden")
})

