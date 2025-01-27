<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Exception;

class VoitureController extends Controller
{

    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                        // Action pour créer un compte utilisateur
                    case 'driverInscription':
                        $this->driverInscription();
                        break;
                        // Si l'action passée dans l'url n'existe pas
                    default:
                        throw new Exception("Cette action n'existe pas: " . $_GET['action']);
                        break;
                }
            }
            // Si il n'y a pas une action dans l'url 
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
        ?controller=voiture&action=driverInscription
    */

    protected function driverInscription()
    {
        // Tableau d'erreurs
        $errors = [];
        // L'id de l'utilisateur
        $user_id = $_SESSION['user']['id'];

        try {
            $voiture = new Voiture;
            $voitureRepository = new VoitureRepository;
            // Si le formulaire est envoyé, on hydrate l'objet Voiture avec les données passées
            if(isset($_POST['driverInscription'])){
                var_dump($_POST);
                $voiture->hydrate($_POST);
                $voitureRepository->createCar($voiture, $user_id);

            }
            
            $voiture->getMarque();
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }

        $this->render(
            "Voiture/chauffeur-inscription",
        );
    }

    public function createCar()
    {
        $errors = [];

        try {
            $voiture = new Voiture;
            $voiture->hydrate($_POST);
            $voiture->getMarque();
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }
    }
}
