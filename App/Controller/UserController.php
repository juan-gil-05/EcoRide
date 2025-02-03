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
                        // Action pour créer un compte utilisateur
                    case 'singUp':
                        $this->singUp();
                        break;
                        // Si l'action passée dans l'url n'existe pas
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
        ?controller=user&action=singUp
    */
    // Fonction pour créer un compte utilisateur 
    protected function singUp()
    {
        $errors = [];
        $pseudo = "";
        $mail = "";
        $password = "";
        $roleName = "";
        $roleId = "";
        try {
            $user = new User();
            $UserValidator = new UserValidator();
            $userRepository = new UserRepository();
            // Si le formulaire est envoyé, on hydrate l'objet User avec les données passées
            if (isset($_POST['singUp'])) {
                $user->hydrate($_POST);
                $pseudo = $user->getPseudo();
                $mail = $user->getMail();
                $password = $user->getPassword();
                $roleId = $user->getRoleId();
                $roleName = $userRepository->findRoleName($user->getRoleId());
                // Pour hasher le mot de passe
                $this->passwordHasher($user);
                // Pour valider s'il n'y a pas des erreurs dans le formulaire
                $errors = $UserValidator->singUpValidate($user);
                // S'il n'y a pas des erreurs, on crée l'utilisateur dans la basse des données
                if (empty($errors)) {
                    // Si l'utilisateur est passager 
                    if ($user->getRoleId() == "1") {
                        $userRepository->createUser($user);
                        // On envoie l'utilisateur vers la page de connexion
                        header('Location: ?controller=auth&action=logIn');
                    } elseif ($user->getRoleId() == "2" || $user->getRoleId() == "3") { // Si l'utilisateur est chauffeur
                        // Pour enregistrer la photo dans l'attribut photo de l'objet User
                        $user->setPhoto($_FILES['photo']['name']);
                        // Pour valider s'il n'y a pas des erreurs dans le formulaire
                        $errors = $UserValidator->UserPhotoValidate($user);
                        // S'il n'y aps des erreur, on crée l'utilisateur avec la photo de profile
                        if (empty($errors)) {
                            $userRepository->createDriverUser($user);
                            // On envoie l'utilisateur vers la page de connexion
                            header('Location: ?controller=auth&action=logIn');
                        }
                    }
                }
            }
            // On affiche la page de création du compte, et on passe des params
            $this->render(
                "User/sing-up",
                [
                    'errors' => $errors,
                    'pseudo' => $pseudo,
                    'password' => $password,
                    'mail' => $mail,
                    'roleName' => $roleName,
                    'roleId' => $roleId
                ]
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
