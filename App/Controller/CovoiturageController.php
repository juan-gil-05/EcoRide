<?php

namespace App\Controller;

use App\Entity\Covoiturage;
use App\Repository\CovoiturageRepository;
use App\Repository\VoitureRepository;
use App\Security\CovoiturageValidator;
use Exception;

class CovoiturageController extends Controller
{
    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                        // Action pour afficher tous les covoiturages
                    case 'showAll':
                        $this->allCovoiturages();
                        break;
                        // Action pour afficher un covoiturage spécifique
                    case 'showOne':
                        $this->oneCovoiturage();
                        break;
                        // Action pour afficher tous les covoiturage de l'utilisateur
                    case 'mesCovoiturages':
                        $this->mesCovoiturages();
                        break;
                        // Action pour afficher le formulaire de création d'un covoiturage
                    case 'createCovoiturage':
                        $this->createCovoiturage();
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
        ?controller=covoiturages&action=showAll
    */
    protected function allCovoiturages()
    {
        $this->render("Covoiturage/all-covoiturages");
    }

    /*
    Exemple d'appel depuis l'url
        ?controller=covoiturages&action=showOne
    */
    protected function oneCovoiturage()
    {
        $this->render("Covoiturage/one-covoiturage");
    }

    /*
    Exemple d'appel depuis l'url
        ?controller=covoiturages&action=mesCovoiturages
    */
    protected function mesCovoiturages()
    {
        $this->render("Covoiturage/mes-covoiturages");
    }

    /*
    Exemple d'appel depuis l'url
        ?controller=covoiturages&action=createCovoiturage
    */
    // Function pour créer un nouveau covoiturage
    protected function createCovoiturage()
    {
        // Tableau des erreurs
        $errors = [];
        $covoiturage = new Covoiturage;
        $covoiturageRepository = new CovoiturageRepository;
        $covoiturageValidator = new CovoiturageValidator;
        $voitureRepository = new VoitureRepository;

        // L'id de l'utilsateur
        $user_id = $_SESSION['user']['id'];
        // Variable qui contient toutes les voitures de l'utilisateur connecté
        $cars = $voitureRepository->findAllCarsByUserId($user_id);
        // Variables de chaque champ du formulaire
        $dateTimeDepart = "";
        $dateTimeArrivee = "";
        $adresseDepart = "";
        $adresseArrivee = "";
        $nbPlaceDisponibles = "";
        $prix = "";

        try {

            if (isset($_POST['createCovoiturage'])) {
                $covoiturage->hydrate($_POST);
                $dateTimeDepart = $covoiturage->getDateHeureDepart();
                $dateTimeArrivee = $covoiturage->getDateHeureArrivee();
                $adresseDepart = $covoiturage->getAdresseDepart();
                $adresseArrivee = $covoiturage->getAdresseArrivee();
                $nbPlaceDisponibles = $covoiturage->getNbPlaceDisponible();
                $prix = $covoiturage->getPrix();
                // Pour valider les erreurs du formulaire
                $errors = $covoiturageValidator->createCovoiturageValidate($covoiturage);
                // S'il n'y a pas des erreurs, on crée le covoiturage dans la basse des données
                if (empty($errors)) {
                    $covoiturageRepository->createCovoiturage($covoiturage);
                    // On envoi vers la page de mes covoiturages 
                    header('Location: ?controller=covoiturages&action=mesCovoiturages');
                }
            }

            $this->render(
                "Covoiturage/create-covoiturages",
                [
                    "errors" => $errors,
                    "cars" => $cars,
                    "dateTimeDepart" => $dateTimeDepart,
                    "dateTimeArrivee" => $dateTimeArrivee,
                    "adresseDepart" => $adresseDepart,
                    "adresseArrivee" => $adresseArrivee,
                    "nbPlaceDisponibles" => $nbPlaceDisponibles,
                    "prix" => $prix
                ]
            );
        } catch (Exception $e) {
            $this->render("Errors/404", ["error" => $e->getMessage()]);
        }
    }
}
