<?php

namespace App\Controller;

use App\Entity\Covoiturage;
use App\Repository\CovoiturageRepository;
use App\Repository\PreferenceUserRepository;
use App\Repository\UserRepository;
use App\Repository\VoitureRepository;
use App\Security\CovoiturageValidator;
use App\Security\Security;
use App\Tools\SendMail;
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
        $adresseDepart = "";
        $adresseArrivee = "";
        $driversByCovoiturageId = [];
        $energieByCovoiturageId = [];
        $ecologique = null;
        $maxPrice = null;
        $maxDuration = null;
        $dateTimeCovoiturage = [null, null, null, null, null];
        $covoiturageEncryptId = null;


        // Si on a des covoiturages dans la session
        if (!empty($covoiturages)) {
            // On parcourt le tableau pour trouver chaque covoiturage
            foreach ($covoiturages as $covoiturage) {

                // on appel la fonction qui formate les dates des covoiturages
                $dateTimeCovoiturage = $this->dateTimeCovoiturage($covoiturage);

                // Pour récupérer l'id de chaque covoiturage
                $covoiturageId = $covoiturage['id'];
                // Pour crypter l'id du covoiturage avant de l'envoyer dans l'url pour afficher les détails de chaque covoiturage 
                $covoiturageEncryptId[$covoiturage['id']] =  $this->encryptUrlParameter($covoiturage['id']);

                // Fonction du repository pour récupérer les covoiturages avec ses énergies utilisées, (Électrique, Diesel, .....)
                $energies = $covoiturageRepository->searchCovoiturageDetailsbyId($covoiturageId);
                // foreach pour parcourir les résultats 
                foreach ($energies as $energie) {
                    // Array qui contient pour l'id de chaque covoiturage les données trouvées 
                    $energieByCovoiturageId[$covoiturage['id']] = $energie;
                }

                // Fonction du repository pour récupérer les covoiturages avec ses chauffeurs
                $driversInfo = $covoiturageRepository->searchCovoiturageDetailsbyId($covoiturageId);
                // foreach pour parcourir les résultats 
                foreach ($driversInfo as $driverInfo) {
                    // Array qui contient pour l'id de chaque covoiturage les données trouvées 
                    $driversByCovoiturageId[$covoiturage['id']] = $driverInfo;
                }
            }

            // Si l'utilisateur applique des filtres à la recherche 
            if (isset($_POST['filter'])) {
                // Pour convertir la date en objet DateTime
                $dateDepart = new DateTime($covoiturage['date_heure_depart']);
                // Pour formater la date
                $dateDepartFormated = $dateDepart->format("Y-m-d");
                // Le prix maximal donné
                $maxPrice = ($_POST['maxPrice']) ? $_POST['maxPrice'] : null;
                // Si c'est écologique ou pas. 1 puisque les covoiturages écologiques utilisent des voitures avec l'énergie id 1 = éléctrique
                $ecologique = (isset($_POST['ecologique'])) ? 1 : null;
                // Pour la durée maximum du voyage
                $maxDuration = (!empty($_POST['maxDuration'])) ? $_POST['maxDuration'] : null;

                // On appel la fonction du repository et on le passe les params du filtre
                $covoituragesMaxPrice = $covoiturageRepository->filterSearchCovoiturage(
                    $dateDepartFormated,
                    $adresseDepart,
                    $adresseArrivee,
                    $ecologique,
                    $maxPrice,
                    $maxDuration
                );

                // Le nouveaux valeurs de la varible $covoiturage seront les covoiturages trouvés après appliqué les filtres
                $covoiturages = $covoituragesMaxPrice;
                // On parcourt le tableau pour récuperer chaque covoiturage trouvé
                foreach ($covoituragesMaxPrice as $covoiturageMaxPrice) {
                    $covoiturage = $covoiturageMaxPrice;
                }
            }
        }

        $this->render(
            "Covoiturage/all-covoiturages",
            [
                "covoiturages" => $covoiturages,
                "covoiturage" => $covoiturage,
                "dayName" => $dateTimeCovoiturage[0],
                "dayNumber" => $dateTimeCovoiturage[1],
                "monthName" => $dateTimeCovoiturage[2],
                "adresseDepart" => $dateTimeCovoiturage[3],
                "adresseArrivee" => $dateTimeCovoiturage[4],
                "driversByCovoiturageId" => $driversByCovoiturageId,
                "energieByCovoiturageId" => $energieByCovoiturageId,
                "maxPrice" => $maxPrice,
                "maxDuration" => $maxDuration,
                "covoiturageEncryptId" => $covoiturageEncryptId
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
        // Appel des repositories
        $covoiturageRepository = new CovoiturageRepository;
        $preferenceUserRepository = new PreferenceUserRepository;
        $userRepository = new UserRepository;

        // On récupére l'id du covoiturage passée dans l'url et on le décrypte 
        $covoiturageId = $this->decryptUrlParameter($_GET['id']);

        // Pour récupérer les détailles du covoiturage
        $covoiturageDetail = $covoiturageRepository->searchCovoiturageDetailsById($covoiturageId);
        $covoiturageDetail = $covoiturageDetail[0];

        // Pour récupérer les détailles du chauffeur
        $driver = $covoiturageRepository->searchCovoiturageDetailsById($covoiturageId);
        $driver = $driver[0];

        // Pour récupérer les détailles de la voiture du covoiturage
        $carInfo = $covoiturageRepository->searchCovoiturageDetailsById($covoiturageId);
        $carInfo = $carInfo[0];

        // L'id du chauffeur
        $driverId = $covoiturageDetail['user_id'];

        // on appel la fonction qui formate les dates et les heures des covoiturages
        $dateTimeCovoiturage = $this->dateTimeCovoiturage($covoiturageDetail);

        // Pour récupérer les préférences du chauffeur
        $driverPreferences = $preferenceUserRepository->searchPreferencesByDriverId($driverId);

        // Fonction array_map pour récupérer uniquement les values des libelles dans un nouveau array
        $preferences = array_map(fn($pref) => $pref['libelle'], $driverPreferences);
        // Fonction array_map pour récupérer uniquement les values des préférences personnelles dans un nouveau array
        $preferencesPersonnelles = array_map(fn($pref) => $pref['personnelle'], $driverPreferences);

        // Fonction pour participer au covoiturage
        $participateToCovoiturage = $this->participateToCovoiturage($covoiturageDetail, $covoiturageRepository, $userRepository);


        $this->render(
            "Covoiturage/one-covoiturage",
            [
                'covoiturageDetail' => $covoiturageDetail,
                "dayName" => $dateTimeCovoiturage[0],
                "dayNumber" => $dateTimeCovoiturage[1],
                "monthName" => $dateTimeCovoiturage[2],
                "adresseDepart" => $dateTimeCovoiturage[3],
                "adresseArrivee" => $dateTimeCovoiturage[4],
                "heureDepart" => $dateTimeCovoiturage[5],
                "heureArrivee" => $dateTimeCovoiturage[6],
                "dureeCovoiturage" => $dateTimeCovoiturage[7],
                "jours" => $dateTimeCovoiturage[8],
                "driver" => $driver,
                "preferences" => $preferences,
                "preferencesPersonnelles" => $preferencesPersonnelles,
                "carInfo" => $carInfo,
                "isNotLogged" => $participateToCovoiturage[0],
                "noDisponiblePlaces" => $participateToCovoiturage[1],
                "noEnoughCredits" => $participateToCovoiturage[2],
                "covoituragePrice" => $participateToCovoiturage[3],
                "userCredits" => $participateToCovoiturage[4],
                "doubleConfirmation" => $participateToCovoiturage[5],
                "isUserParticipant" => $participateToCovoiturage[6],
            ]
        );
    }

    /*
    Exemple d'appel depuis l'url
        ?controller=covoiturages&action=mesCovoiturages
    */
    protected function mesCovoiturages()
    {
        // Appel du repository
        $covoiturageRepository = new CovoiturageRepository;

        // Initialisation des variables
        $covoiturageEncryptId = null;
        $dayName = null;
        $dayNumber = null;
        $monthName = null;

        $userId = ($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
        // Pour chercher les covoiturages du chauffeur
        $covoituragesAsDriver = $covoiturageRepository->searchCovoiturageDetailsByUserId($userId);

        // Pour parcourir les covoiturages du chauffeur
        foreach ($covoituragesAsDriver as $covoiturage) {
            // Pour récupérer l'id de chaque covoiturage
            $covoiturageId = $covoiturage['id'];
            // Pour crypter l'id du covoiturage avant de l'envoyer dans l'url pour afficher les détails de chaque covoiturage 
            $covoiturageEncryptId[$covoiturageId] =  $this->encryptUrlParameter($covoiturageId);
            // on appel la fonction qui formate les dates des covoiturages
            $dateTimeCovoiturage = $this->dateTimeCovoiturage($covoiturage);
            $dayName[$covoiturageId] = $dateTimeCovoiturage[0];
            $dayNumber[$covoiturageId] = $dateTimeCovoiturage[1];
            $monthName[$covoiturageId] = $dateTimeCovoiturage[2];
        }

        // Pour chercher les covoiturages du passager
        $covoiturageaAsPassager = $covoiturageRepository->searchCovoiturageParticipateByUserId($userId);

        // Pour parcourir les covoiturages du passager
        foreach ($covoiturageaAsPassager as $covoiturage) {
            // Pour récupérer l'id de chaque covoiturage
            $covoiturageId = $covoiturage['id'];
            // Pour crypter l'id du covoiturage avant de l'envoyer dans l'url pour afficher les détails de chaque covoiturage 
            $covoiturageEncryptId[$covoiturageId] =  $this->encryptUrlParameter($covoiturageId);
            // on appel la fonction qui formate les dates des covoiturages
            $dateTimeCovoiturage = $this->dateTimeCovoiturage($covoiturage);
            $dayName[$covoiturageId] = $dateTimeCovoiturage[0];
            $dayNumber[$covoiturageId] = $dateTimeCovoiturage[1];
            $monthName[$covoiturageId] = $dateTimeCovoiturage[2];
        }

        // Si l'utilisateur quitte le covoiturage
        $this->leaveCovoiturage();

        // Si le chauffeur supprime le covoiturage
        $this->cancelCovoiturage();

        $this->render(
            "Covoiturage/mes-covoiturages",
            [
                "covoituragesAsDriver" => $covoituragesAsDriver,
                "covoiturageaAsPassager" => $covoiturageaAsPassager,
                "covoiturageEncryptId" => $covoiturageEncryptId,
                "dayName" => $dayName,
                "dayNumber" => $dayNumber,
                "monthName" => $monthName,
            ]
        );
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


    // Fonction pour formater les dates des covoiturages
    protected function dateTimeCovoiturage(array $covoiturageDetail)
    {
        // On récupére l'adresse et l'heure de départ du covoiturage et
        // On crée un objet DateTime
        $dateTimeDepart = new DateTime($covoiturageDetail['date_heure_depart']);

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
        $depart = new DateTime($covoiturageDetail['date_heure_depart']);
        $arrivee = new DateTime($covoiturageDetail['date_heure_arrivee']);

        // Pour calculer la durée du covoiturage, on utilise la fonction diff de l'objet DateTime
        $dureeCovoiturage = $depart->diff($arrivee);
        // Variable qui contient le jours de différence entre chaque date
        $jours = $dureeCovoiturage->days;

        // Si le jours est égal a 0, mais les deux date sont differentes, alors,
        // C'est un jour de différence
        if ($jours == 0 && $depart->format("Y-m-d") != $arrivee->format("Y-m-d")) {
            $jours = 1;
        }

        return [
            $dayName,
            $dayNumber,
            $monthName,
            $adresseDepart,
            $adresseArrivee,
            $heureDepart,
            $heureArrivee,
            $dureeCovoiturage,
            $jours
        ];
    }

    // Fonction pour crypter un paramètre passé dans l'url avec l'algorithme ASE (Advanced Encryption Standard)
    protected function encryptUrlParameter($id)
    {
        // Clé pour crypter et décrypter 
        $key = "JkgDDiB3KTxGiDBPBYGObdzFPzyiVJ8g";
        // Parce qu'on utilise le CBC (Cipher Block Chaining) qui a besoin d'un 'Initialization Vector'
        $IV = random_bytes(16); // 16 bytes car on utilise 128 bites
        // On crypte avec la fonction openssl
        $encrypted = openssl_encrypt($id, "AES-128-CBC", $key, 0, $IV);
        // Variable qui joint le 'Initialization Vector' avec le paramètre crypté et fait un encode 
        $base64Encoded = base64_encode($IV . $encrypted);
        // finallement, on change les symbole '+' et '/' pour éviter des erreurs au moment de décripter le IV
        return strtr($base64Encoded, '+/', '-_');
    }

    // Fonction pour décryper un paramètre passé dans l'url avec l'algorithme ASE (Advanced Encryption Standard)
    protected function decryptUrlParameter($encryptedParam)
    {
        // Clé pour crypter et décrypter 
        $key = "JkgDDiB3KTxGiDBPBYGObdzFPzyiVJ8g";
        // on change les symbole '-' et '_' pour éviter les erreurs
        $base64Decoded = strtr($encryptedParam, '-_', '+/');
        // fonction pour decoder le param
        $decodedParam = base64_decode($base64Decoded);
        // Pour séparer le IV du param, (les 16 premières chiffres)
        $IV = substr($decodedParam, 0, 16);
        // Pour récuperer le param, (les chiffres après la 16ème chiffre)
        $encrypted = substr($decodedParam, 16);
        // On décripte avec la fonction openssl
        $decrypted = openssl_decrypt($encrypted, "AES-128-CBC", $key, 0, $IV);
        return $decrypted;
    }

    // Fonction pour participer au covoiturage
    protected function participateToCovoiturage(array $covoiturageDetail, CovoiturageRepository $covoiturageRepository, UserRepository $userRepository): array
    {
        // Variable pour savoir si l'utilisateur est connecté ou pas
        $isNotLogged = false;
        // Variable pour savoir si le covoiturage a des places disponibles
        $noDisponiblePlaces = false;
        // Variable pour savoir si l'utilisateur possède assez des crédits pour participer au covoiturage
        $noEnoughCredits = false;
        // Variable pour afficher le modal avec la confirmation de participation au covoiturage
        $doubleConfirmation = false;

        // Les places disponibles dans le covoiturage
        $disponiblePlaces = $covoiturageDetail['nb_place_disponible'];
        // le prix du covoiturage
        $covoituragePrice = $covoiturageDetail['prix'];
        // L'id de l'utilisateur
        $userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
        // Le mail de l'utilisateur
        $userMail = isset($_SESSION['user']['mail']) ? $_SESSION['user']['mail'] : null;
        // On cherche l'utilisateur par son mail
        $user = $userRepository->findOneByMail($userMail);
        // Les crédits de l'utilisateur
        $userCredits = $user->getNbCredits();
        // L'id du covoiturage
        $covoiturageId = $covoiturageDetail['id'];
        // On cherche si l'utilisateur participe déjà au covoiturage
        $isUserParticipant = $covoiturageRepository->isUserParticipant($userId, $covoiturageId);

        // Si l'user n'est pas connecté, on change la variable pour passer l'info à la vue
        if (!Security::isLogged()) {
            $isNotLogged = true;
        } // S'il n'y a pas des places disponibles, on change la variable pour passer l'info à la vue
        elseif ($disponiblePlaces == 0) {
            $noDisponiblePlaces = true;
        } // S'il n'y a pas des places disponibles, on change la variable pour passer l'info à la vue  
        elseif ($disponiblePlaces == 0) {
            $noDisponiblePlaces = true;
        } // Si l'utilisateur ne possède pas assez des crédits pour participer au covoiturage  
        elseif ($userCredits < $covoituragePrice) {
            $noEnoughCredits = true;
        } 

        // Si tous ces params sont faux, l'utilisateur peut participer au covoiturage
        if ($isNotLogged == false && $noDisponiblePlaces == false && $noEnoughCredits == false && $isUserParticipant == false) {
            // On affiche la modal avec la confirmation de participation au covoiturage
            $doubleConfirmation = true;
            // Si l'utilisateur confirme sa participation au covoiturage
            if (isset($_POST['participate'])) {
                // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
                $_SESSION['message_to_User'] = ' Votre participation au covoiturage a été enregistrée avec succès !';
                $_SESSION['message_code'] = "success";

                // On appele la fonction du repository pour enregistrer les données dans la BDD
                $covoiturageRepository->participateToCovoiturage($userId, $covoiturageId);

                // On appele la fonction pour mettre à jour les crédits de l'utilisateur
                $covoiturageRepository->updateUserCredits($covoituragePrice, $userId, false);

                // On appele la fonction pour mettre à jour les nombres de places disponibles du covoiturage
                $covoiturageRepository->updatePlacesDisponibles($covoiturageId, false);
            }
        }
        return
            [
                $isNotLogged,
                $noDisponiblePlaces,
                $noEnoughCredits,
                $covoituragePrice,
                $userCredits,
                $doubleConfirmation,
                $isUserParticipant
            ];
    }


    // Fonction si l'utilisateur quitte le covoiturage
    public function leaveCovoiturage()
    {
        // Appel du repository
        $covoiturageRepository = new CovoiturageRepository;

        if (isset($_POST['quitCovoiturageAsPassager'])) {
            // L'id du covoiturage et de l'utilisateur
            $covoiturageId = $_POST['covoiturage_id'];
            $userId = $_POST['user_id'];
            // Pour récupérer le prix de chaque covoiturage
            $covoituragePrice = $_POST['covoiturage_price'];
            // Fonction pour quitter le covoiturage
            $covoiturageRepository->quitCovoiturageAsPassager($userId, $covoiturageId);

            // Pour mettre à jour les places disponibles du covoiturage
            $covoiturageRepository->updatePlacesDisponibles($covoiturageId, true);

            // Pour mettre à jour les crédits de l'utilisateur
            $covoiturageRepository->updateUserCredits($covoituragePrice, $userId, true);

            // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
            $_SESSION['message_to_User'] = "Votre participation à ce covoiturage a été annulée.";
            $_SESSION['message_code'] = "success";
        }
    }


    // Fonction pour annuler le covoiturage
    public function cancelCovoiturage()
    {
        // Appel du repository
        $covoiturageRepository = new CovoiturageRepository;

        // Le sujet et le modèle du mail
        $mailSubject = 'Annulation de votre covoiturage';
        $mailBody = 'covoiturage-deleted.php';

        // Si le chauffeur supprime le covoiturage
        if (isset($_POST['deleteCovoiturageAsDriver'])) {
            // L'id du covoiturage et de l'utilisateur
            $covoiturageId = $_POST['covoiturage_id'];
            // Pour récupérer le prix de chaque covoiturage
            $covoituragePrice = $_POST['covoiturage_price'];

            // Pour récupérer les détailles du covoiturage
            $covoiturageDetail = $covoiturageRepository->searchCovoiturageDetailsById($covoiturageId);
            foreach ($covoiturageDetail as $covoiturage) {
                // Les date et les adresses du covoiturage
                $covoiturageDepart = ucfirst($covoiturage['adresse_depart']);
                $covoiturageArrivee = ucfirst($covoiturage['adresse_arrivee']);
                $covoiturageDateDepart = new DateTime($covoiturage['date_heure_depart']);
            }

            // Pour récupérer tous les participants du covoiturage et le pseudo du chauffeur
            $participants = $covoiturageRepository->searchCovoiturageParticipantsByCovoiturageId($covoiturageId);
            foreach ($participants as $passager) {
                // Id et mail des passagers
                $passagerId = $passager['user_id'];
                $passagerMail = $passager['passager_mail'];
                $driverPseudo = ucfirst($passager['driver_pseudo']); // Pseudo du chauffeur

                // Les paramètres pour envoyer le mail
                $mailParams = [
                    "covoiturageDepart" => $covoiturageDepart,
                    "covoiturageArrivee" => $covoiturageArrivee,
                    "covoiturageDateDepart" => $covoiturageDateDepart->format('d-m-Y'), // Pour formater la date
                    "driverPseudo" => $driverPseudo
                ];

                // Pour mettre à jour les crédits de chaque passager
                // $covoiturageRepository->updateUserCredits($covoituragePrice, $passagerId, true);

                // On appele la fonction pour envoyer un mail à chaque passager
                SendMail::sendMailToPassagers($passagerMail, $mailSubject, $mailBody, $mailParams);
            }

            // Fonction pour supprimer le covoiturage dans la base des données
            // $covoiturageRepository->deleteCovoiturageAsDriver($covoiturageId);

            // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
            $_SESSION['message_to_User'] = "Covoiturage annulé. Les participants ont été informés par e-mail.";
            $_SESSION['message_code'] = "info";
        }
    }
}
