// script pour masquer le bouton "Démarrer" et afficher le bouton "Arrivée à destination" lors du clic sur le bouton "Démarrer"
// tout en utilisant une requête fetch pour mettre à jour l'état du covoiturage dans la base de données
function startCovoiturage(id) {
    fetch("", {
        method: "POST",
        headers: {
            "content-type": "application/x-www-form-urlencoded",
        },
        // Envoi de l'id du covoiturage et l'action startCovoiturage
        body: `covoiturage_id=${id}&startCovoiturage=1`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cacher le bouton "Démarrer"
                const startBtn = document.getElementById("startBtn" + id);
                if (startBtn) startBtn.classList.add("hidden");

                // Afficher le bouton "Arrivée à destination"
                const arriveBtn = document.getElementById("arriveBtn" + id);
                if (arriveBtn) arriveBtn.classList.remove("hidden");

            }
        })
        .catch(error => {
            console.error("Erreur lors de la requête :", error);
        });
}

// script pour masquer le bouton "Arrivée à destination" et afficher le bouton "Clôturé" lors du clic sur le bouton "Arrivée à destination"
// tout en utilisant une requête fetch pour mettre à jour l'état du covoiturage dans la base de données
function arriveCovoiturage(id) {
    fetch("", {
        method: "POST",
        headers: {
            "content-type": "application/x-www-form-urlencoded",
        },
        // Envoi de l'id du covoiturage et l'action arriveCovoiturage
        body: `covoiturage_id=${id}&arriveCovoiturage=1`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cacher le bouton "Arrivée à destination"
                const arriveBtn = document.getElementById("arriveBtn" + id);
                if (arriveBtn) arriveBtn.classList.add("hidden");

                // Afficher le bouton "Clôturé"
                const finishBtn = document.getElementById("finishBtn" + id);
                if (finishBtn) finishBtn.classList.remove("hidden");
                console.log("Covoiturage terminé avec succès !");
                
            }
        })
        .catch(error => {
            console.error("Erreur lors de la requête :", error);
        });
}
