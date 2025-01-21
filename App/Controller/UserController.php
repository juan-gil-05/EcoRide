<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\UserValidator;
use Exception;

class UserController extends Controller
{
    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'singUp':
                        // On appel l'action pour créer un compte utilisateur
                        $this->singUp();
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
        ?controller=user&action=singUp
    */
    protected function singUp()
    {
        $errors = [];
        $pseudo = "";
        $mail = "";
        $password = "";
        try {
            $user = new User();
            $UserValidator = new UserValidator();
            if (isset($_POST['singUp'])) {
                $user->hydrate($_POST);
                $pseudo = $user->getPseudo();
                $mail = $user->getMail();
                $password = $user->getPassword();
                $this->passwordHasher($user);
                $errors = $UserValidator->singUpValidate($user);
                if (empty($errors)) {
                    $userRepository = new UserRepository();
                    $userRepository->createUser($user);
                    header('Location: ?controller=auth&action=logIn');
                }
            }
            $this->render(
                "User/sing-up",
                ['errors' => $errors, 'pseudo' => $pseudo, 'password' => $password, 'mail' => $mail]
            );
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }
    }


    // Fonction pour hasher le mot de passe
    protected function passwordHasher(User $user)
    {
        if (! empty($_POST['password'])) {
            $passwordHashed = password_hash($user->getPassword(), PASSWORD_DEFAULT);
            return $user->setPassword($passwordHashed);
        } else {
            return false;
        }
    }
}
