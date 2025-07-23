<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use App\Repository\VoitureRepository;
use App\Security\UserValidator;
use Exception;

class AuthController extends Controller
{
    /*
    Exemple d'appel depuis l'url
        /auth/connexion
    */
    // Fonction pour se connecter
    protected function connexion()
    {
        $errors = [];
        $userMail = "";

        try {
            if (!isset($_POST['logIn'])) {
                $this->render("Auth/log-in", ['errors' => $errors, 'mail' => $userMail]);
                exit;
            }

            $userRepository = new UserRepository();
            $userValidator = new UserValidator();

            $mail = htmlspecialchars($_POST['mail']) ?? "";
            $user = $userRepository->findOneByMail($mail);
            $userMail = $user ? $user->getMail() : $mail;

            // Validation des erreurs dans le formulaire
            $errors = $userValidator->logInValidate($userMail);

            if (!empty($errors)) {
                $this->render("Auth/log-in", ['errors' => $errors, 'mail' => $userMail]);
                exit;
            }

            if (!$user || !$userValidator->passwordVerify($user)) {
                $errors['invalidUser'] = "Email ou mot de passe invalide";
                $this->render("Auth/log-in", ['errors' => $errors, 'mail' => $userMail]);
                exit;
            }

            if ($user->getActive() != 1) {
                // Si le compte est suspendu, on affiche un message d'erreur
                $errors['inactiveUser'] = "Votre compte est suspendu, veuillez nous contacter pour en savoir plus.";
                $this->render("Auth/log-in", ['errors' => $errors, 'mail' => $userMail]);
                exit;
            }

            $this->connectUser($user, $userRepository);
            UserController::redirectAfterLogin($user, $userRepository);
            exit;
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }
    }

    /*
    Exemple d'appel depuis l'url
        /auth/deconnexion
    */
    // Fonction pour se deconnecter
    protected function deconnexion()
    {
        //Prévient les attaques de fixation de session
        session_regenerate_id(true);
        //Supprime les données de session du serveur
        session_destroy();
        //Supprime les données du tableau $_SESSION
        unset($_SESSION);
        // On envoie l'utilisateur vers la page de connexion
        header('location: /auth/connexion');
    }

    public static function connectUser(User $user, UserRepository $userRepository)
    {
        $user = $userRepository->findOneByMail($user->getMail());
        // Pour générer l'id de la session
        session_regenerate_id(true);
        // On crée une nouvelle session avec les données de l'utilisateur connecté
        $_SESSION['user'] = [
            "id" => $user->getId(),
            "pseudo" => $user->getPseudo(),
            "mail" => $user->getMail(),
            "password" => $user->getPassword(),
            "role" => $user->getRoleId(),
        ];
        // On crée cette session pour pouvoir afficher le message de succès,
        // le message_code c'est pour l'icon de SweetAlert
        $_SESSION['message_to_User'] = "Vous êtes connectez";
        $_SESSION['message_code'] = "success";
    }
}
