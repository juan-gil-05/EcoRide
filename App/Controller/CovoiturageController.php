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
                    case 'showAll':
                        // On appel l'action pour afficehr tous les covoiturages
                        $this->allCovoiturages();
                        break;
                    case 'showOne':
                        // On appel l'action pour afficher un covoiturage specifique
                        $this->oneCovoiturage();
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
        } catch (Exception $e) {
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


}
