<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PreferenceUserRepository;
use App\Repository\UserRepository;
use App\Repository\VoitureRepository;
use App\Security\Security;
use App\Security\UserValidator;
use Exception;

class UserController extends Controller
{
    /*
    Exemple d'appel depuis l'url
        /user/inscription
    */
    // Fonction pour créer un compte utilisateur
    protected function inscription()
    {
        $errors = [];
        $pseudo = "";
        $mail = "";
        $password = "";
        $passwordConfirm = "";
        $roleName = "";
        $roleId = "";
        try {
            if (!isset($_POST['signUp'])) {
                $this->render(
                    "User/sign-up",
                    [
                        'errors' => $errors,
                        'pseudo' => $pseudo,
                        'password' => $password,
                        'passwordConfirm' => $passwordConfirm,
                        'mail' => $mail,
                        'roleName' => $roleName,
                        'roleId' => $roleId
                    ]
                );
                exit;
            }

            $user = new User();
            $userValidator = new UserValidator();
            $userRepository = new UserRepository();

            $user->hydrate($_POST);
            $pseudo = $user->getPseudo();
            $mail = $user->getMail();
            $password = $user->getPassword();
            $roleId = $user->getRoleId();
            $roleName = $userRepository->findRoleName($user->getRoleId());
            $passwordConfirm = $_POST['passwordConfirm'];

            // Pour valider s'il n'y a pas des erreurs dans le formulaire
            $errors = $userValidator->signUpValidate($user, $passwordConfirm);

            // Pour hasher le mot de passe
            Security::passwordHasher($user);

            if (!empty($errors)) {
                $this->render(
                    "User/sign-up",
                    [
                        'errors' => $errors,
                        'pseudo' => $pseudo,
                        'password' => $password,
                        'passwordConfirm' => $passwordConfirm,
                        'mail' => $mail,
                        'roleName' => $roleName,
                        'roleId' => $roleId
                    ]
                );
                exit;
            }

            $userCreated = $this->createUserDependingOnRole($user, $userRepository, $userValidator, $errors);

            // Si userCreated n'est pas vide, c'est parce qu'il contient les erreurs retournées para la fonction
            if (!empty($userCreated)) {
                $this->render(
                    "User/sign-up",
                    [
                        'errors' => $userCreated,
                        'pseudo' => $pseudo,
                        'password' => $password,
                        'passwordConfirm' => $passwordConfirm,
                        'mail' => $mail,
                        'roleName' => $roleName,
                        'roleId' => $roleId
                    ]
                );
                exit;
            }

            // Pour connecter l'utilisateur
            AuthController::connectUser($user, $userRepository);

            // Pour rediriger l'user selon certaines conditions
            $this->redirectAfterLogin($user, $userRepository);
            exit();
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }
    }

    /*
    Exemple d'appel depuis l'url
        /user/profil
    */
    // Fonction pour afficher le profil de l'utilisateur
    protected function profil()
    {
        // Si l'utilisateur est connecté
        if (Security::isLogged()) {
            // Repositories
            $userRepository = new UserRepository();
            $carRepository = new VoitureRepository();
            $preferenceRepository = new PreferenceUserRepository();

            $userId = $_SESSION['user']['id'];
            // Pour récuperer le mail de l'utilisateur qui est connecté
            $userMail = $_SESSION['user']['mail'];
            // Fonction pour trouver l'information de l'utilisateur par son mail
            $user =  $userRepository->findOneByMail($userMail);

            // Variables de l'user
            $userPseudo = $user->getPseudo();
            $userMail = $user->getMail();
            $userCredits = $user->getNbCredits();
            $photoUniqueId = $user->getPhotoUniqId();

            // Fonction pour chercher toutes les voitures par l'id de l'utilisateur
            $allCars = ($carRepository->findAllCarsByUserId($userId))
                ? $carRepository->findAllCarsByUserId($userId)
                : [];

            // Fonction pour chercher toutes les préférences par l'id de l'utilisateur
            $allPreferences = $preferenceRepository->searchPreferencesByDriverId($userId);
            // Fonction pour chercher toutes les préférences personnelles par l'id de l'utilisateur
            $allPersoPref = $preferenceRepository->searchPreferencesByDriverId($userId, true);

            // Fonction array_map pour récupérer uniquement les values des libelles dans un nouveau array
            $preferencesLibelle = array_map(fn($pref) => $pref['libelle'], $allPreferences);

            $this->deletePreference($preferenceRepository);

            PreferenceUserController::editPersonnelle();

            $this->render(
                "User/profil",
                [
                    "pseudo" => $userPseudo,
                    "mail" => $userMail,
                    "credits" => $userCredits,
                    "photoUniqueId" => $photoUniqueId,
                    "allCars" => $allCars,
                    "preferencesLibelle" => $preferencesLibelle,
                    "allPersoPref" => $allPersoPref
                ]
            );
        } else {
            // Sinon on envoie à la page de connexion
            header('Location: /auth/connexion');
        }
    }

    private function createUserDependingOnRole(
        User $user,
        UserRepository $userRepository,
        UserValidator $userValidator,
        array $errors
    ) {
        // Si l'utilisateur est passager
        if ($user->getRoleId() == "1") {
            $userRepository->createUser($user);
        } else { // Si l'utilisateur est chauffeur
            // Pour enregistrer la photo dans l'attribut photo de l'objet User
            $user->setPhoto($_FILES['photo']['name']);
            // Pour valider s'il n'y a pas des erreurs dans le formulaire
            $errors = $userValidator->userPhotoValidate($user);
            // S'il n'y pas des erreur, on crée l'utilisateur avec la photo de profile
            if (!empty($errors)) {
                // $errors = array_push($errors, $errors);
                return $errors;
            }
            $userRepository->createDriverUser($user);
        }
        // On crée cette session pour pouvoir afficher le message de succès,
        // le message_code c'est pour l'icon de SweetAlert
        $_SESSION['message_to_User'] = "Compte crée avec succès";
        $_SESSION['message_code'] = "success";
    }

    public static function redirectAfterLogin(User $user, UserRepository $userRepository): void
    {
        $voitureRepository = new VoitureRepository();
        $user = $userRepository->findOneByMail($user->getMail());

        if ($user->getRoleId() == "2" || $user->getRoleId() == "3") {
            // Chauffeur
            if ($voitureRepository->findCarByUserId($user->getId())) { // s'il a déjà des voitures
                header('Location: /page/accueil');
            } else { // sinon, on envoie vers la page d'inscription d'une voiture
                header('Location: /voiture/inscription');
            }
        } else {
            // Passager
            header('Location: /page/accueil');
        }
        exit;
    }

    private function deletePreference(PreferenceUserRepository $preferenceRepository)
    {
        if (isset($_POST['deletePreference'])) {
            $preferenceRepository->deletePreferenceById($_POST['prefId']);
            // On crée cette session pour pouvoir afficher le message de succès,
            // le message_code c'est pour l'icon de SweetAlert
            $_SESSION['message_to_User'] = 'La préférence a été supprimée.';
            $_SESSION['message_code'] = "success";
        }
    }
}
