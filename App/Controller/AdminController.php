<?php

namespace App\Controller;

use App\Repository\UserRepository;

class AdminController extends Controller
{
    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    // Action pour afficher l'espace admin
                    case 'adminEspace':
                        $this->adminEspace();
                        break;
                    // Si l'action passée dans l'url n'existe pas
                    default:
                        throw new \Exception("Cette action n'existe pas: " . $_GET['action']);
                        break;
                }
            }
            // Si il n'y a pas une action dans l'url 
            else {
                throw new \Exception("Aucune action détectée");
            }
        } // On return la page d'erreur s'il en existe un
        catch (\Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }
    }


    /*
    Exemple d'appel depuis l'url
        ?controller=admin&action=adminEspace
    */
    // Fonction pour afficher l'espace admin
    private function adminEspace()
    {
        // repository pour la table User
        $userRepository = new UserRepository;
        // On récupère tous les utilisateurs
        $allUsers = $userRepository->findAllUsers();

        // Si il y a une action de suppression d'un utilisateur
        if(isset($_POST['deleteUser'])) {    
            $userId = $_POST['id']; // On récupère l'id de l'utilisateur à supprimer
            // On supprime l'utilisateur
            $userRepository->deleteUser($userId);
            // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
            $_SESSION['message_to_User'] = 'Le compte utilisateur a bien été supprimé.';
            $_SESSION['message_code'] = "success";
        }

        $this->render(
            "User/adminEspace",
            [
                'allUsers' => $allUsers
            ]
        );
    }
}
