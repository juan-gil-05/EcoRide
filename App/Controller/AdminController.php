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

        $userRepository = new UserRepository;

        $allUsers = $userRepository->findAllUsers();

        // var_dump($allUsers);

        $this->render(
            "User/adminEspace",
            [
                'allUsers' => $allUsers
            ]
        );
    }
}
