<?php

namespace App\Controller;

use Exception;

class EmployeController extends Controller
{
    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    // Action pour valider ou refuser les avis des chauffeurs
                    case 'validateAvisAndNote':
                        $this->validateAvisAndNote();
                        break;
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
        ?controller=employe&action=validateAvisAndNote
    */
    // Fonction pour valider ou refuser les avis des chauffeurs
    public function validateAvisAndNote()
    {
        $this->render('User/employeEspace');
    }
}
