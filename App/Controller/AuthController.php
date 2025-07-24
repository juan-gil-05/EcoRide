<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use App\Repository\AuthRepository;
use App\Security\UserValidator;
use DateTime;
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
            $authRepository = new AuthRepository();
            $userValidator = new UserValidator();

            $mail = $_POST['mail'] ?? "";
            $user = $userRepository->findOneByMail($mail);
            $userMail = $user ? $user->getMail() : $mail;

            // Validation des erreurs dans le formulaire
            $errors = $userValidator->logInValidate($userMail);

            if (!empty($errors)) {
                $this->render("Auth/log-in", ['errors' => $errors, 'mail' => $userMail]);
                exit;
            }

            // Si l'utilisateur n'existe pas en bdd
            if (!$user) {
                $errors['invalidUser'] = "Email ou mot de passe invalide";
                $this->render("Auth/log-in", ['errors' => $errors, 'mail' => $userMail]);
                exit;
            }

            $userId = $user->getId(); // Pour récuperer l'id de l'utilisateur
            $attempts = $user->getLoginAttempts();
            $lockedUntil = $user->getLockedUntil();
            $now = new DateTime(); // Nouvelle date afin de comparer la date du lockedUntil

            /* Si l'utilisateur n'est pas bloqué temporellement,
            on réinitialise les champs loginAttempts et lockedUntil */
            if ($lockedUntil && $now > $lockedUntil) {
                $attempts = 0;
                $lockedUntil = null;
                $user = $this->resetUserAttempts($user, $userRepository, $authRepository);
            }

            // Si l'utilisateur est bloqué temporellement car plus de 5 essais de mot de passe incorrect
            if ($lockedUntil && $now < $lockedUntil) {
                $errors['accountLocked'] = "Compte temporairement bloqué. Réessayez à " .
                    ($lockedUntil)->format('H\h:i');
                $this->render("Auth/log-in", ['errors' => $errors, 'mail' => $userMail]);
                exit;
            }

            // Fonction qui gére la verification du mot de passe et le blocage temporelle de l'utilisateur
            $this->handlePasswordVerification(
                $user,
                $userId,
                $userValidator,
                $attempts,
                $lockedUntil,
                $now,
                $authRepository,
                $userMail
            );

            // Si le compte utilisateur a été bloqué par l'admin
            if ($user->getActive() != 1) {
                // Si le compte est suspendu, on affiche un message d'erreur
                $errors['inactiveUser'] = "Votre compte est suspendu, veuillez nous contacter pour en savoir plus.";
                $this->render("Auth/log-in", ['errors' => $errors, 'mail' => $userMail, 'attempts' => $attempts]);
                exit;
            }

            // réinitialiser les champs loginAttempts et lockedUntil ainsi que l'objet User
            $user = $this->resetUserAttempts($user);

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

    private function resetUserAttempts(User $user): User
    {
        $userRepository = new UserRepository();
        $authRepository = new AuthRepository();
        $authRepository->loginAttemptsAndLockedReinit($user->getId());
        return $userRepository->findOneByMail($user->getMail());
    }

    private function handlePasswordVerification(
        User $user,
        int $userId,
        UserValidator $userValidator,
        int $attempts,
        $lockedUntil,
        DateTime $now,
        AuthRepository $authRepository,
        string $userMail
    ): bool {
        if ($userValidator->passwordVerify($user)) {
            return true;
        }

        // Si le mot de passe est incorrect
        if (!$userValidator->passwordVerify($user)) {
            $attempts += 1; // à chaque essai

            // Pour afficher le message qu'on il reste 2 tentaives d'inserer le mot de passe
            if ($attempts < 5) {
                $remaining = 5 - $attempts;
                if ($remaining <= 2) {
                    $errors['remainingAttempts'] = "Il vous reste <strong>$remaining</strong> tentative" .
                        ($remaining > 1 ? "s" : "") . " avant le blocage de 15 minutes.";
                }
            }
            /* Pour ajouter 15 minutes au champ lockedUntil
            et en suite faire la modification en bdd */
            if ($attempts >= 5) {
                $lockedUntil = ($now)->modify("+ 15 minutes")->format("Y-m-d H:i:s");
            }
            $authRepository->accountLocked($userId, $attempts, $lockedUntil);

            // Si lockedUntil n'est pas null, ca veut dire que l'utilisateur est bloqué temporellement
            ($lockedUntil)
                ? $errors['accountLocked'] = "Trop de tentatives. Compte bloqué jusqu’à " .
                (new DateTime($lockedUntil))->format('H\h:i')
                : $errors['invalidUser'] = "Email ou mot de passe invalide";
            $this->render("Auth/log-in", ['errors' => $errors, 'mail' => $userMail]);
            exit;
        }
        return false;
    }
}
