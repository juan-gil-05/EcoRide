// script pour masquer le bouton "Démarrer" et afficher le bouton "Arrivée à destination" lors du clic sur le bouton "Démarrer"
// tout en utilisant une requête fetch pour mettre à jour l'état du covoiturage dans la base de données
function startCovoiturage(id) {
    fetch("", {
        method: "POST",
        headers: {
            "content-type": "application/x-www-form-urlencoded",
        },
        // Envoi de l'id du covoiturage et l'action satartCovoiturage
        body: `covoiturage_id=${id}&startCovoiturage=1`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("startBtn" + id).classList.toggle("hidden");
                document.getElementById("arriveBtn" + id).classList.toggle("hidden");
                console.log("Covoiturage démarré avec succès !");
                console.log(data);
            }
        })
        .catch(error => {
            console.error("Erreur lors de la requête :", error);
        });
}
