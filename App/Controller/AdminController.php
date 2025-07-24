<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\Security;
use App\Security\UserValidator;
use Exception;

class AdminController extends Controller
{
    /*
    Exemple d'appel depuis l'url
        /admin/espace
    */
    // Fonction pour afficher l'espace admin
    public function espace()
    {
        // Si l'utilisateur est connecté en tant qu'administrateur
        if (Security::isAdmin()) {
            // repository pour la table User
            $userRepository = new UserRepository();
            // On récupère tous les utilisateurs
            $allUsers = $userRepository->findAllUsers();

            $this->userAccountStatus($userRepository);

            // Fonction pour créer un compte employé
            $employeAccount = $this->createEmployeAccount();

            $this->render(
                "User/adminEspace",
                [
                    'allUsers' => $allUsers,
                    "employePseudoAccount" => $employeAccount['pseudo'],
                    "employeMailAccount" => $employeAccount['mail'],
                    "employePasswordAccount" => $employeAccount['password'],
                    "errors" => $employeAccount['errors']
                ]
            );
        } else {
            // Sinon on envoie à la page de connexion
            header('Location: /auth/connexion');
        }
    }

    // Fonction pour créer un compte employé
    private function createEmployeAccount()
    {
        $errors = [];
        $pseudo = "";
        $mail = "";
        $password = "";
        try {
            $user = new User();
            $UserValidator = new UserValidator();
            $userRepository = new UserRepository();
            $userController = new UserController();
            // Si le formulaire est envoyé, on hydrate l'objet User avec les données passées
            if (isset($_POST['signUp'])) {
                $user->hydrate($_POST);
                $pseudo = $user->getPseudo();
                $mail = $user->getMail();
                $password = $user->getPassword();
                // Pour hasher le mot de passe
                Security::passwordHasher($user);
                // Pour valider s'il n'y a pas des erreurs dans le formulaire
                $errors = $UserValidator->signUpEmployeValidate($user);
                // S'il n'y a pas des erreurs, on crée l'utilisateur dans la base des données
                if (empty($errors)) {
                    // on crée l'employé dans la base de données
                    $userRepository->createEmployeAccount($user);

                    // On crée cette session pour pouvoir afficher le message de succès,
                    // le message_code c'est pour l'icon de SweetAlert
                    $_SESSION['message_to_User'] = "Le compte employé a été créé avec succès.";
                    $_SESSION['message_code'] = "success";
                    // On envoie le json au fetch
                    echo (json_encode(['success' => true, 'message' => 'Compte créé avec succès']));
                    exit;
                } else { // S'il y a des erreurs
                    // On envoie le json au fetch
                    echo (json_encode(['success' => false, 'errors' => $errors]));
                    exit;
                }
            }

            return [
                'pseudo' => $pseudo,
                'mail' => $mail,
                'password' => $password,
                'errors' => $errors
            ];
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }
    }

    private function userAccountStatus(UserRepository $userRepository)
    {
        // Si il y a une action de suppression d'un utilisateur
        if (isset($_POST['suspendUser'])) {
            $userId = $_POST['id']; // On récupère l'id de l'utilisateur à suspendre
            // On suspendre l'utilisateur
            $userRepository->userAccountStatus($userId, 0);
            // On crée cette session pour pouvoir afficher le message de succès,
            // le message_code c'est pour l'icon de SweetAlert
            $_SESSION['message_to_User'] = 'Le compte utilisateur a bien été suspendu.';
            $_SESSION['message_code'] = "success";
        } elseif (isset($_POST['reactiveUser'])) {
            $userId = $_POST['id']; // On récupère l'id de l'utilisateur à suspendre
            // On réactive l'utilisateur
            $userRepository->userAccountStatus($userId, 1);
            // On crée cette session pour pouvoir afficher le message de succès,
            // le message_code c'est pour l'icon de SweetAlert
            $_SESSION['message_to_User'] = 'Le compte utilisateur a été réactivé.';
            $_SESSION['message_code'] = "success";
        } elseif (isset($_POST['deleteUser'])) {
            $userId = $_POST['id']; // On récupère l'id de l'utilisateur à suspendre
            // On supprime l'utilisateur
            $userRepository->userAccountStatus($userId, 1, true);
            // On crée cette session pour pouvoir afficher le message de succès,
            // le message_code c'est pour l'icon de SweetAlert
            $_SESSION['message_to_User'] = 'Le compte utilisateur a bien été supprimé.';
            $_SESSION['message_code'] = "success";
        }
    }


    /*
    Exemple d'appel depuis l'url
        /admin/graphique
    */
    // Fonction pour afficher les graphiques du site
    public function graphique()
    {
        // Si l'utilisateur est connecté en tant qu'administrateur
        if (Security::isAdmin()) {
            $this->render("User/adminGraphs");
        } else {
            // Sinon on envoie à la page de connexion
            header('Location: /auth/connexion');
        }
    }
}
