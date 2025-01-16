<?php

namespace App\Controller;

use Exception;

class PageController extends Controller
{
    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'accueil':
                        // On appel l'action pour afficher la page d'accueil
                        $this->accueil();
                        break;
                        // Si l'action passee dans l'url n'existe pas
                    default:
                        throw new Exception("Cette action n'existe pas: ".$_GET['action']);
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
        ?controller=page&action=accueil
    */

    protected function accueil()
    {
        $this->render("Page/accueil");
    }


}
