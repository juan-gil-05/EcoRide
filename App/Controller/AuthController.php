<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use App\Security\UserValidator;
use Exception;

class AuthController extends Controller
{
    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'logIn':
                        // On appel l'action pour Se connecter
                        $this->logIn();
                        break;
                    case 'logOut':
                        // On appel l'action pour Se deconnecter
                        $this->logOut();
                        break;
                        // Si l'action passée dans l'url n'existe pas
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
        ?controller=auth&action=logIn
    */
    protected function logIn()
    {
        $errors = [];

        try {
            if (isset($_POST['logIn'])) {
                $userRepository = new UserRepository;
                $userValidator = new UserValidator;
                $user = $userRepository->findOneByMail($_POST['mail']);
                var_dump($user->getPassword());
                var_dump($_POST['password']);
                // var_dump($user);

                if ($user && $_POST['password'] === $user->getPassword()) {
                    session_regenerate_id(true);
                    $_SESSION['user'] = [
                        "id" => $user->getId(),
                        "pseudo" => $user->getPseudo(),
                        "mail" => $user->getMail(),
                        "password" => $user->getPassword(),
                    ];
                    header('location: ?controller=page&action=accueil');
                } else {
                    $errors[] = "Mail ou mot de passe incorrect";
                }
            }
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }
        $this->render("Auth/log-in");
    }

    protected function logOut()
    {
        //Prévient les attaques de fixation de session
        session_regenerate_id(true);
        //Supprime les données de session du serveur
        session_destroy();
        //Supprime les données du tableau $_SESSION
        unset($_SESSION);
        header('location: index.php?controller=auth&action=logIn');
    }
}
