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
        // Si l'employé valide l'avis, alors ....
        if (isset($_POST['avisValidated'])) {
            $avisStatut = $_POST['avisValidated']; // On récupere le statut, donc = 1 : True
            $avisId = $_POST['avis_id']; // On récupere l'id de l'avis
            $avisRepository->updateAvisStatut($avisStatut, $avisId);
            // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
            $_SESSION['message_to_User'] = 'L’avis a été validé avec succès.</br> Il est maintenant visible publiquement.';
            $_SESSION['message_code'] = "success";
            // On envoie l'user vers la page précédente
            header('Location : ' . $_SERVER['HTTP_REFERER']);
        } // Si l'employé refuse l'avis, alors ... 
        elseif (isset($_POST['avisRefused'])) {
            $avisStatut = $_POST['avisRefused']; // On récupere le statut, donc = 0 : False
            $avisId = $_POST['avis_id']; // On récupere l'id de l'avis
            $avisRepository->updateAvisStatut($avisStatut, $avisId);
            // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
            $_SESSION['message_to_User'] = 'L’avis a été refusé.</br> Il ne sera pas publié sur la plateforme.';
            $_SESSION['message_code'] = "info";
            // On envoie l'user vers la page précédente
            header('Location : ' . $_SERVER['HTTP_REFERER']);
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
