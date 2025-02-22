<?php

namespace App\Controller;

use App\Entity\Covoiturage;
use App\Repository\CovoiturageRepository;
use App\Security\CovoiturageValidator;
use Exception;

class PageController extends Controller
{
    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                        // Action pour afficher la page d'accueil
                    case 'accueil':
                        $this->accueil();
                        break;
                        // Si l'action passee dans l'url n'existe pas
                    default:
                        throw new Exception("Cette action n'existe pas: " . $_GET['action']);
                        break;
                }
            }
            // Si il n'y a pas des action dans l'url 
            else {
                throw new \Exception("Aucune action détectée");
            }
        } // On return la page d'erreur s'il en existe un
        catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }
    }

    /*
    Exemple d'appel depuis l'url
        ?controller=page&action=accueil
    */
    // Fonction pour afficher la page d'accueil
    protected function accueil()
    {
        // Fonction de la barre de recherche pour chercher des covoiturages
        $this->searchCovoiturage();
        $this->render(
            "Page/accueil",
            [
                'dateDepart' => $this->searchCovoiturage()[0],
                'adresseDepart' => $this->searchCovoiturage()[1],
                'adresseArrivee' => $this->searchCovoiturage()[2],
                'errors' => $this->searchCovoiturage()[3]
            ]
        );
    }

    // Fonction de la barre de recherche
    public function searchCovoiturage()
    {
        $covoiturage = new Covoiturage;
        $covoiturageRepository = new CovoiturageRepository;
        $covoiturageValidator = new CovoiturageValidator;
        $errors = [];
        // Variables pour contenir les données du formulaire
        $dateDepart = "";
        $adresseDepart = "";
        $adresseArrivee = "";

        // Si on envoi le formulaire de recherche, ....
        if (isset($_GET['search'])) {
            // On Hydrate l'objet de la classe Covoiturage
            $covoiturage->hydrate($_GET);
            // On enregistre les valeurs passées dans le formulaire dans nos variables
            //si le champ de la date n'est pas vide, alors on le récupére, sinon, on le laisse vide
            $dateDepart = (!empty($_GET['date_heure_depart'])) ? $covoiturage->getDateHeureDepart()->format('Y-m-d') : "";
            $adresseDepart = $covoiturage->getAdresseDepart();
            $adresseArrivee = $covoiturage->getAdresseArrivee();
            // Fonction du repository pour chercher avec les donées passées 
            $covoiturages = $covoiturageRepository->searchCovoiturageByDateAndAdresse($dateDepart, $adresseDepart, $adresseArrivee);
            // Pour Vérifier les erreurs dans le formulaire
            $errors =  $covoiturageValidator->searchCovoiturageValidate($dateDepart, $adresseDepart, $adresseArrivee);
            // S'il n'y a pas des erreurs, ....
            if (empty($errors)) {
                // Si on trouve des résultats,
                // on envoi vers la page de tous les covoiturages et on affiche les résultats 
                if ($covoiturages) {
                    // pour enregistrer les covoiturages trouvés dans une session, 
                    // afin de pouvoir passer les donées ver une nouvelle page 
                    $_SESSION['covoiturages'] = $covoiturages;
                    header('location: ?controller=covoiturages&action=showAll');
                } else {
                    echo 'Rien';
                }
            }
        }

        return [$dateDepart, $adresseDepart, $adresseArrivee, $errors];
    }
}
