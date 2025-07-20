<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use App\Repository\VoitureRepository;
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
                    // Action pour se connecter
                    case 'logIn':
                        $this->logIn();
                        break;
                    // Action pour se deconnecter
                    case 'logOut':
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
    // Fonction pour se connecter
    protected function logIn()
    {
        $errors = [];
        $userMail = "";

        try {

            if (!isset($_POST['logIn'])) {
                $this->render("Auth/log-in", ['errors' => $errors, 'mail' => $userMail]);
                exit;
            }

            $userRepository = new UserRepository;
            $userValidator = new UserValidator;
            $voitureRepository = new VoitureRepository;

            $mail = $_POST['mail'] ?? "";
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







            // $this->render("Auth/log-in", ['errors' => $errors, 'mail' => $userMail]);

            // Si le formulaire est envoyé, on cherche l'utilisateur par son mail
            // if (isset($_POST['logIn'])) {
            //     // S'il n'y a pas des erreurs ...
            //     if (empty($errors)) {
            //         // Et si le mot de passe est correct ...
            //         if ($user && $userValidator->passwordVerify($user)) {
            //             // On vérifie si l'utilisateur est actif
            //             if ($user->getActive() == 1) {
            //                 // Pour générer l'id de la session
            //                 session_regenerate_id(true);
            //                 // On crée une nouvelle session avec les données de l'utilisateur connecté
            //                 $_SESSION['user'] = [
            //                     "id" => $user->getId(),
            //                     "pseudo" => $user->getPseudo(),
            //                     "mail" => $user->getMail(),
            //                     "password" => $user->getPassword(),
            //                     "role" => $user->getRoleId(),
            //                 ];
            //                 // Si l'utilisateur a le role du Chauffeur ou Passager-chaffeur,
            //                 // On envoi l'user vers la page pour enregister une voiture
            //                 if ($user->getRoleId() == 2 || $user->getRoleId() == 3) {
            //                     // Si l'utilisateur a déjà enregistré des voitures, 
            //                     // On envoi a la page d'accueil
            //                     if ($voitureRepository->findCarByUserId($user->getId())) {
            //                         // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
            //                         $_SESSION['message_to_User'] = "Vous êtes connectez";
            //                         $_SESSION['message_code'] = "success";
            //                         // On redirige vers la page d'accueil
            //                         header('location: ?controller=page&action=accueil');
            //                         exit();
            //                     } else {
            //                         // Envois vers la page pour enregistrer une voiture
            //                         header('location: ?controller=voiture&action=carInscription');
            //                     }
            //                 } else { // Si l'user n'est pas chauffeur mais passager, alors ...
            //                     // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
            //                     $_SESSION['message_to_User'] = "Vous êtes connectez";
            //                     $_SESSION['message_code'] = "success";
            //                     // On redirige vers la page d'accueil
            //                     header('location: ?controller=page&action=accueil');
            //                     exit();
            //                 }
            //             } else {
            //                 // Si le compte est suspendu, on affiche un message d'erreur
            //                 $errors['inactiveUser'] = "Votre compte est suspendu, veuillez nous contacter pour en savoir plus.";
            //             }
            //         } // Si le mot de passe ou le mail est incorrect
            //         else {
            //             $errors['invalidUser'] = "Email ou mot de passe invalide";
            //         }
            //     }
            // }
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }
    }

    /*
    Exemple d'appel depuis l'url
        ?controller=auth&action=logOut
    */
    // Fonction pour se deconnecter
    protected function logOut()
    {
        //Prévient les attaques de fixation de session
        session_regenerate_id(true);
        //Supprime les données de session du serveur
        session_destroy();
        //Supprime les données du tableau $_SESSION
        unset($_SESSION);
        // On envoie l'utilisateur vers la page de connexion
        header('location: index.php?controller=auth&action=logIn');
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
        // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
        $_SESSION['message_to_User'] = "Vous êtes connectez";
        $_SESSION['message_code'] = "success";
    }
}
