<?php

namespace App\Controller;

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

}
