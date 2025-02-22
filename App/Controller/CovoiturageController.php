<?php

namespace App\Controller;

use App\Entity\Covoiturage;
use App\Repository\CovoiturageRepository;
use App\Repository\PreferenceUserRepository;
use App\Repository\VoitureRepository;
use App\Security\CovoiturageValidator;
use DateTime;
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
    // Fonction pour afficher tous les covoiturages
    protected function allCovoiturages()
    {
        // On récupére les données envoyées dans la session depuis la page d'accueil 
        // S'il n'y a pas, on laisse un tableau vide
        $covoiturages = $_SESSION['covoiturages'] ?? [];
        $covoiturageRepository = new CovoiturageRepository;

        // Variables que l'on va utiliser dans la vue
        $covoiturage = "";
        $dayName = "";
        $dayNumber = "";
        $monthName = "";
        $adresseDepart = "";
        $adresseArrivee = "";
        $driversByCovoiturageId = [];
        $energieByCovoiturageId = [];


        // Si on a des covoiturages dans la session
        if (!empty($covoiturages)) {
            // On parcourt le tableau pour trouver chaque covoiturage
            foreach ($covoiturages as $covoiturage) {
                // On récupére l'adresse et l'heure de départ du covoiturage
                $dateTimeDepart = $covoiturage['date_heure_depart'];
                // On crée un objet DateTime pour l'adresse et l'heure de départ du covoiturage
                $dateTimeDepart = new DateTime();
                // Tableau avec les noms des jours de la semaine en francais
                $weekDayFrench =
                    [
                        'Monday' => 'Lundi',
                        'Tuesday' => 'Mardi',
                        'Wednesday' => 'Mercredi',
                        'Thursday' => 'Jeudi',
                        'Friday' => 'Vendredi',
                        'Saturday' => 'Samedi',
                        'Sunday' => 'Dimanche',
                    ];
                // Tableau avec les noms des mois de l'année en francais
                $monthNameFrench =
                    [
                        'January' => 'Janvier',
                        'February' => 'Février',
                        'March' => 'Mars',
                        'April' => 'Avril',
                        'May' => 'Mai',
                        'June' => 'Juin',
                        'July' => 'Juillet',
                        'August' => 'Août',
                        'September' => 'Septembre',
                        'October' => 'Octobre',
                        'November' => 'Novembre',
                        'December' => 'Décembre',
                    ];
                // Pour récupérer le nom du jour en francais
                $dayName = $weekDayFrench[$dateTimeDepart->format('l')];
                // Pour récupérer le nombre du jour 
                $dayNumber = $dateTimeDepart->format('d');
                // Pour récupérer le nom du mois en francais
                $monthName = $monthNameFrench[$dateTimeDepart->format('F')];
                // Pour récupérer l'adresse du départ
                $adresseDepart = $covoiturage['adresse_depart'];
                // Pour récupérer l'adresse d'arrivée'
                $adresseArrivee = $covoiturage['adresse_arrivee'];
                // Pour récupérer l'id de chaque covoiturage
                $covoiturageId = $covoiturage['id'];


                // Fonction du repository pour récupérer les covoiturages avec ses énergies utilisées, (Électrique, Diesel, .....)
                $energies = $covoiturageRepository->searchCovoiturageWithEnergieId($covoiturageId);
                // foreach pour parcourir les résultats 
                foreach ($energies as $energie) {
                    // Array qui contient pour l'id de chaque covoiturage les données trouvées 
                    $energieByCovoiturageId[$covoiturage['id']] = $energie;
                }

                // Fonction du repository pour récupérer les covoiturages avec ses chauffeurs
                $driversInfo = $covoiturageRepository->searchCovoiturageWithAllDrivers($covoiturageId);
                // foreach pour parcourir les résultats 
                foreach ($driversInfo as $driverInfo) {
                    // Array qui contient pour l'id de chaque covoiturage les données trouvées 
                    $driversByCovoiturageId[$covoiturage['id']] = $driverInfo;
                }
            }
        }

        $this->render(
            "Covoiturage/all-covoiturages",
            [
                "covoiturages" => $covoiturages,
                "covoiturage" => $covoiturage,
                "dayName" => $dayName,
                "dayNumber" => $dayNumber,
                "monthName" => $monthName,
                "adresseDepart" => $adresseDepart,
                "adresseArrivee" => $adresseArrivee,
                "driversByCovoiturageId" => $driversByCovoiturageId,
                "energieByCovoiturageId" => $energieByCovoiturageId
            ]
        );
    }


    /*
    Exemple d'appel depuis l'url
        ?controller=covoiturages&action=showOne
    */
    // Fonction pour afficher les détails du covoiturage
    protected function oneCovoiturage()
    {
        // On récupére l'id du covoiturage passée dans l'url
        $covoiturageId = $_GET['id'];

        // Appel des repositories
        $covoiturageRepository = new CovoiturageRepository;
        $preferenceUserRepository = new PreferenceUserRepository;

        // Pour récupérer les détailles du covoiturage
        $covoiturageDetail = $covoiturageRepository->searchCovoiturageDetailById($covoiturageId);
        // Pour récupérer les détailles du chauffeur
        $driver = $covoiturageRepository->searchCovoiturageWithDriver($covoiturageId);

        // On récupére l'adresse et l'heure de départ du covoiturage
        $dateTimeDepart = $covoiturageDetail['date_heure_depart'];
        // On crée un objet DateTime pour l'adresse et l'heure de départ du covoiturage
        $dateTimeDepart = new DateTime();
        // Tableau avec les noms des jours de la semaine en francais
        $weekDayFrench =
            [
                'Monday' => 'Lundi',
                'Tuesday' => 'Mardi',
                'Wednesday' => 'Mercredi',
                'Thursday' => 'Jeudi',
                'Friday' => 'Vendredi',
                'Saturday' => 'Samedi',
                'Sunday' => 'Dimanche',
            ];
        // Tableau avec les noms des mois de l'année en francais
        $monthNameFrench =
            [
                'January' => 'Janvier',
                'February' => 'Février',
                'March' => 'Mars',
                'April' => 'Avril',
                'May' => 'Mai',
                'June' => 'Juin',
                'July' => 'Juillet',
                'August' => 'Août',
                'September' => 'Septembre',
                'October' => 'Octobre',
                'November' => 'Novembre',
                'December' => 'Décembre',
            ];
        // Pour récupérer le nom du jour en francais
        $dayName = $weekDayFrench[$dateTimeDepart->format('l')];
        // Pour récupérer le nombre du jour 
        $dayNumber = $dateTimeDepart->format('d');
        // Pour récupérer le nom du mois en francais
        $monthName = $monthNameFrench[$dateTimeDepart->format('F')];
        // Pour récupérer l'adresse du départ
        $adresseDepart = $covoiturageDetail['adresse_depart'];
        // Pour récupérer l'adresse d'arrivée'
        $adresseArrivee = $covoiturageDetail['adresse_arrivee'];

        // On utilise la fonction substr pour afficher juste les heures et les minutes
        // L'heure de départ
        $heureDepart = substr($covoiturageDetail['date_heure_depart'], 11, 5);
        // L'heure d'arrivée
        $heureArrivee = substr($covoiturageDetail['date_heure_arrivee'], 11, 5);

        // Pour convertir les heures en Objets DateTime et en suit
        $heure1 = new DateTime($heureDepart);
        $heure2 = new DateTime($heureArrivee);
        // Pour calculer la durée cu covoiturage, utilise la fonction diff de l'objet DateTime
        $dureeCovoiturage = $heure1->diff($heure2);

        // L'id du chauffeur
        $driverId = $driver['id'];

        // Pour récupérer les préférences du chauffeur
        $driverPreferences = $preferenceUserRepository->searchPreferencesByDriverId($driverId);

        // Fonction array_map pour récupérer uniquement les values des libelles dans un nouveau array
        $preferences = array_map(fn($pref) => $pref['libelle'],$driverPreferences);      
        // Fonction array_map pour récupérer uniquement les values des préférences personnelles dans un nouveau array
        $preferencesPersonnelles = array_map(fn($pref) => $pref['personnelle'],$driverPreferences);            
        
        // Pour récupérer les détailles de la voiture du covoiturage
        $carInfo = $covoiturageRepository->searchCovoiturageWithCarInfoById($covoiturageId);


        $this->render(
            "Covoiturage/one-covoiturage",
            [
                'covoiturageDetail' => $covoiturageDetail,
                "dayName" => $dayName,
                "dayNumber" => $dayNumber,
                "monthName" => $monthName,
                "adresseDepart" => $adresseDepart,
                "adresseArrivee" => $adresseArrivee,
                "heureDepart" => $heureDepart,
                "heureArrivee" => $heureArrivee,
                "dureeCovoiturage" => $dureeCovoiturage,
                "driver" => $driver,
                "preferences" => $preferences,
                "preferencesPersonnelles" => $preferencesPersonnelles,
                "carInfo" => $carInfo
            ]
        );
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
            // Si on evoi le formulaire, alors, on hydrate l'objet Covoiturage avec les données passées 
            if (isset($_POST['createCovoiturage'])) {
                $covoiturage->hydrate($_POST);
                // On récupere les données passées dans le formulaire
                $dateTimeDepart = $covoiturage->getDateHeureDepart();
                $dateTimeArrivee = $covoiturage->getDateHeureArrivee();
                $adresseDepart = $covoiturage->getAdresseDepart();
                $adresseArrivee = $covoiturage->getAdresseArrivee();
                $nbPlaceDisponibles = $covoiturage->getNbPlaceDisponible();
                $prix = $covoiturage->getPrix();
                // Pour valider les erreurs du formulaire
                $errors = $covoiturageValidator->createCovoiturageValidate($covoiturage);
                // S'il n'y a pas des erreurs, on crée le covoiturage dans la base des données
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
