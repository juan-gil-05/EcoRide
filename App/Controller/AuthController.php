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
        $mail = "";

        try {
            // Si le formulaire est envoyé, on cherche l'utilisateur par son mail
            if (isset($_POST['logIn'])) {
                $userRepository = new UserRepository;
                $userValidator = new UserValidator;
                $voitureRepository = new VoitureRepository;
                // on cherche l'utilisateur par son mail
                $user = $userRepository->findOneByMail($_POST['mail']);
                $mail = $user->getMail();
                // Validation des erreurs dans le formulaire
                $errors = $userValidator->logInValidate($user);
                // S'il n'y a pas des erreurs et si le mot de passe est correct
                if (empty($errors)) {
                    // Si le mot de passe est correct
                    if ($user && $userValidator->passwordVerify($user)) {
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
                        // Si l'utilisateur a le role du Chauffeur ou Passager-chaffeur,
                        // On envoi l'user vers la page pour enregister une voiture
                        if ($user->getRoleId() == 2 || $user->getRoleId() == 3) {
                            // Si l'utilisateur a déjà enregistré des voitures, 
                            // On envoi a la page d'accueil
                            if ($voitureRepository->findCarByUserId($user->getId())) {
                                header('location: ?controller=page&action=accueil');
                            } else {
                                // Envois vers la page pour enregistrer une voiture
                                header('Location: ?controller=voiture&action=carInscription');
                            }
                        } else { // Si l'user n'est pas chauffeur mais passager, alors ...
                            // On envoie l'utilisateur vers la page d'accueil
                            header('location: ?controller=page&action=accueil');
                        }
                    } // Si le mot de passe ou le mail est incorrect
                    else {
                        $errors['invalidUser'] = "Email ou mot de passe invalide";
                    }
                }
            }
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }
        // On affiche la page de connexion, et on passe des params
        $this->render("Auth/log-in", ['errors' => $errors, 'mail' => $mail]);
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
}
