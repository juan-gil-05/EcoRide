<?php

namespace App\Controller;

use App\Repository\AvisRepository;
use App\Repository\CovoiturageRepository;
use App\Repository\UserRepository;
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
        // Repositories
        $avisRepository = new AvisRepository;
        $userRepository = new UserRepository;

        // Tous les avis et les notes des chauffeurs 
        $allAvisAndNotes = $avisRepository->searchAllAvisAndNotes();
        // Pour parcourir le tableau 
        foreach ($allAvisAndNotes as $avisAndNote) {

            // Toute l'info de l'avis
            $avisId = $avisAndNote['avis_id']; // L'id de l'avis
            $avisTitle = $avisAndNote['titre']; // Titre de l'avis
            $avisDescription = $avisAndNote['avis']; // L'avis 
            $driverNote = $avisAndNote['note']; // la note du chauffeur
            $passagerId = $avisAndNote['user_id_auteur']; // L'id du passager
            $driverId = $avisAndNote['user_id_cible']; // L'id du chauffeur
            $passagerName[$avisId] = $userRepository->findUserById($passagerId); // Le pseudo du passager
            $driverName[$avisId] =  $userRepository->findUserById($driverId); // Le pseudo du chauffeur


            // echo ("</br>");
            // // var_dump($avisAndNote);
            // var_dump($driverNoteInt);
            // var_dump($driverNoteArray);
            // echo ("</br>");
        }


        $this->render(
            'User/employeEspace',
            [
                "allAvisAndNotes" => $allAvisAndNotes,
                "passagerName" => $passagerName,
                "driverName" => $driverName,
            ]
        );
    }
}
