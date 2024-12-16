import Route from "./Route.js";

//Définir ici vos routes
export const allRoutes = [
    new Route("/", "Accueil", "/pages/page-accueil.html"), // Page d'accueil
    new Route("/index.html", "Accueil", "/pages/page-accueil.html"), // Page d'accueil
    new Route("/covoiturages", "Covoiturages", "/pages/page-vue-covoiturages.html") // Page de la vue des covoiturages
];

//Le titre s'affiche comme ceci : Route.titre - websitename
export const websiteName = "EcoRide";