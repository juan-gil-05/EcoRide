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
        $errors = [];
        $covoiturage = new Covoiturage;
        $covoiturageRepository = new CovoiturageRepository;
        $covoiturageValidator = new CovoiturageValidator;
        $voitureRepository = new VoitureRepository;

        // L'id de l'utilsateur
        $user_id = $_SESSION['user']['id'];
        // Variable qui contient toutes les voitures de l'utilisateur connecté
        $cars = $voitureRepository->findAllCarsByUserId($user_id);

        try {

            if (isset($_POST['createCovoiturage'])) {
                var_dump($_POST);
                $covoiturage->hydrate($_POST);
                echo '<br>';
                echo '<br>';
                var_dump($covoiturage);
                $errors = $covoiturageValidator->createCovoiturageValidate($covoiturage);


                if (empty($errors)) {
                    $covoiturageRepository->createCovoiturage($covoiturage);
                    echo 'ok';
                } else {
                    echo 'no funciono';
                }
            }

            $this->render(
                "Covoiturage/create-covoiturages",
                [
                    "errors" => $errors,
                    "cars" => $cars,
                ]
            );
        } catch (Exception $e) {
            $this->render("Errors/404", ["error" => $e->getMessage()]);
        }
    }
}
