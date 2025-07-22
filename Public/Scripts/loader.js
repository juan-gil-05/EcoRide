// Quand le DOM est chargé
document.addEventListener("DOMContentLoaded", () => {
    // Pour récuperer le loader
    const loader = document.getElementById("loader");

    // Cacher le loader quand la page a chargée
    loader.classList.add("loader--hidden");

    // Pour afficher le loader quand on clique sur un lien
    document.querySelectorAll("a").forEach(link => {
        link.addEventListener("click", (e) => {
            // Si le lien a l'attribut href, alors, on affiche le loader
            const href = link.getAttribute("href");
            if (href && href != "#") {
                loader.classList.remove("loader--hidden");
            }
        });
    });

    // Pour afficher le loader quand on envoie un formulaire
    document.querySelectorAll("form").forEach(form => {
        form.addEventListener("submit", () => {
            loader.classList.remove("loader--hidden");
        });
    });
});