<?php

namespace App\Controller;

use App\Entity\Covoiturage;
use App\Repository\CovoiturageRepository;
use App\Repository\Repository;
use App\Security\CovoiturageValidator;
use DateTime;
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
                'errors' => $this->searchCovoiturage()[3],
                'covoiturageCloser' => $this->searchCovoiturage()[4],
                'newDateDepart' => $this->searchCovoiturage()[5],
                'noCovoiturageFoundMsg' => $this->searchCovoiturage()[6]
            ]
        );
    }

    // Fonction de la barre de recherche
    protected function searchCovoiturage()
    {
        $covoiturage = new Covoiturage;
        $covoiturageRepository = new CovoiturageRepository;
        $covoiturageValidator = new CovoiturageValidator;
        $errors = [];
        // Variables pour contenir les données du formulaire
        $dateDepart = "";
        $adresseDepart = "";
        $adresseArrivee = "";
        $covoiturageCloser = null;
        $newDateDepart = null;
        $noCovoiturageFoundMsg = "";

        // Si on envoi le formulaire de recherche, ....
        if (isset($_GET['search'])) {
            // On Hydrate l'objet de la classe Covoiturage
            $covoiturage->hydrate($_GET);
            // On enregistre les valeurs passées dans le formulaire dans nos variables
            //si le champ de la date n'est pas vide, alors on le récupére, sinon, on le laisse vide
            $dateDepart = (!empty($_GET['date_heure_depart'])) ? $covoiturage->getDateHeureDepart()->format('Y-m-d') : "";
            $adresseDepart = $covoiturage->getAdresseDepart();
            $adresseArrivee = $covoiturage->getAdresseArrivee();
            // Fonction pour chercher avec les donées passées 
            $covoiturages = $covoiturageRepository->searchCovoiturageByDateAndAdresse($adresseDepart, $adresseArrivee, $dateDepart);
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
                } // Si on ne trouve pas des covoiturages dans la date passée, alors
                else {
                    // On appel la fonction pour chercher le covoiturage le plus proche à la date donnée par l'user
                    $searchCloser = $this->searchCloserCovoiturage($dateDepart, $covoiturageRepository, $adresseDepart, $adresseArrivee);
                    // si on trouve des covoiturages proche à la date donnée
                    if(!empty($searchCloser)){
                        // On enregistre les données dans la session
                        $covoiturageCloser = $_SESSION['covoiturageCloser'];
                        // On instance un objet DateTime, pour la nouvelle date à proposer à l'utilisateur
                        $newDateDepart = new DateTime($covoiturageCloser['date_heure_depart']);
                    } // Si on ne trouve pas de covoiturages avec les données passées
                    else {
                        // On passe le message qui va s'afficher à l'utlisateur
                        $noCovoiturageFoundMsg = "Désolé, aucun covoiturage n'a été trouvé pour ces adresses.
                        <br> Essayez de modifier votre recherche ou de choisir un autre point de départ ou d'arrivée.";
                    }
                }
            }
        }
        return [$dateDepart, $adresseDepart, $adresseArrivee, $errors, $covoiturageCloser, $newDateDepart, $noCovoiturageFoundMsg];
    }

    // Fonction pour chercher le covoiturage le plus proche à la date donnée par l'user
    protected function searchCloserCovoiturage(string $dateDepart, CovoiturageRepository $covoiturageRepository, string $adresseDepart, string $adresseArrivee)
    {
        // On instance un objet DateTime pour la date donnée par l'utilisateur
        $dateSerched = new DateTime($dateDepart);
        // Pour récupérer le timestamp de cette date 
        $dateSerchedTimestamp = $dateSerched->getTimestamp();

        // Fonction pour chercher tous les covoiturages selon les adresse de départ et d'arrivée
        // $allCovoiturages = $covoiturageRepository->searchAllCovoituragesByAdresse($adresseDepart, $adresseArrivee);
        $allCovoiturages = $covoiturageRepository->searchCovoiturageByDateAndAdresse($adresseDepart, $adresseArrivee);

        // Variable qui va contenir le covoiturage plus proche trouvé
        $covoiturageCloser = null;
        // Variable qui contient le int maximum possible
        $maxDifference = PHP_INT_MAX;

        // On parcourt le tableau avec les covoiturages trouvés
        foreach ($allCovoiturages as $covoiturage) {
            // On instance un objet DateTime pour les dates de tous les covoiturages trouvés
            $dateFound = new DateTime($covoiturage['date_heure_depart']);
            // Pour récupérer le timestamp de chaque date 
            $dateDepartTimestamp = $dateFound->getTimestamp();

            // On récupere la difference en timestamp de chaque date avec la date donées par l'user
            $difference = abs($dateDepartTimestamp - $dateSerchedTimestamp);

            // Si la difference est mineur à la difference précédente, alors, on change la valeur de la même
            // et on change la valeur de le covoiturage plus proche par rapport à la date 
            if ($difference < $maxDifference) {
                $maxDifference = $difference;
                $covoiturageCloser = $covoiturage;
            }
        }
        // pour enregistrer les covoiturages trouvés dans une session, 
        // afin de pouvoir passer les donées ver une nouvelle page 
        return $_SESSION['covoiturageCloser'] = $covoiturageCloser;
    }

}
