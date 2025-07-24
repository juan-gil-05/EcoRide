<?php

namespace App\Controller;

use App\Entity\PreferenceUser;
use App\Repository\PreferenceUserRepository;
use App\Security\PreferenceUserValidator;
use Exception;

class PreferenceUserController extends Controller
{
    /*
    Exemple d'appel depuis l'url
        /preference/choix-fumeur
    */
    // Fonction pour enregistrer une nouvelle préférence
    public function choixFumeur()
    {
        // Tableau d'erreurs
        $errors = [];
        // L'id de l'utilisateur
        $user_id = $_SESSION['user']['id'];

        try {
            $preference = new PreferenceUser();
            $preferenceRepository = new PreferenceUserRepository();
            $preferenceValidator = new PreferenceUserValidator();
            if (isset($_POST['prefInscriptionSmoker'])) {
                $preference->hydrate($_POST);
                // Pour la validation des erreurs
                $errors = $preferenceValidator->newPreferenceValidator($preference);
                // S'il n'y a pas des erreurs, on crée la préférence dans la base des données
                if (empty($errors)) {
                    $preferenceRepository->createPreference($preference, $user_id);
                    // On envoi vers la page suivante pour continuer l'insciption
                    header('Location: /preference/choix-animal');
                    exit;
                }
            }
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }

        $this->render("PreferencesUser/preferences-inscription-smoker", [
            'errors' => $errors,
            'preference' => $preference,
        ]);
    }

    /*
    Exemple d'appel depuis l'url
        /preference/choix-animal
    */
    // Fonction pour enregistrer une nouvelle préférence
    public function choixAnimal()
    {
        // Tableau d'erreurs
        $errors = [];
        // L'id de l'utilisateur
        $user_id = $_SESSION['user']['id'];

        try {
            $preference = new PreferenceUser();
            $preferenceRepository = new PreferenceUserRepository();
            $preferenceValidator = new PreferenceUserValidator();

            if (isset($_POST['prefInscriptionAnimal'])) {
                $preference->hydrate($_POST);
                // Pour la validation des erreurs
                $errors = $preferenceValidator->newPreferenceValidator($preference);
                // S'il n'y a pas des erreurs, on crée la préférence dans la base des données
                if (empty($errors)) {
                    $preferenceRepository->createPreference($preference, $user_id);
                    // On envoi vers la page suivante pour continuer l'insciption
                    header('Location: /preference/choix-personnelle');
                    exit;
                }
            }
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }

        $this->render("PreferencesUser/preferences-inscription-animal", [
            'errors' => $errors,
            'preference' => $preference,
        ]);
    }

    /*
    Exemple d'appel depuis l'url
        /preference/choix-personnelle
    */
    // Fonction pour enregistrer une nouvelle préférence personnelle
    public function choixPersonnelle()
    {
        // L'id de l'utilisateur
        $user_id = $_SESSION['user']['id'];
        $preferenceRepository = new PreferenceUserRepository();

        // Pour enregistrer une nouvelle préférence personnelle
        $personalPreference = new PreferenceUser();
        if (isset($_POST['newPersonalPreference'])) {
            // On hydrate l'objet avec les données passées
            $personalPreference->hydrate($_POST);
            // Pour la créer dans la base de données
            $preferenceRepository->createPreference($personalPreference, $user_id);
            // On crée cette session pour pouvoir afficher le message de succès,
            // le message_code c'est pour l'icon de SweetAlert
            $_SESSION['message_to_User'] = "Préférence sauvegardée";
            $_SESSION['message_code'] = "success";
            // On envoi vers la page d'accueil
            header('Location: /user/profil');
            exit();
        }

        $this->render("PreferencesUser/preferences-inscription-personal");
    }

    // Fonction pour éditer une préférence personnelle
    public static function editPersonnelle()
    {
        $preferenceRepository = new PreferenceUserRepository();

        // Pour éditer une préférence personnelle
        if (isset($_POST['editPersonalPreference'])) {
            $prefId = $_POST['preference_id'];
            $prefEdited = $_POST['preference_personnelle'];
            // Pour la créer dans la base de données
            $preferenceRepository->updatePreferenceById($prefId, $prefEdited);
            // On crée cette session pour pouvoir afficher le message de succès,
            // le message_code c'est pour l'icon de SweetAlert
            $_SESSION['message_to_User'] = "Préférence modifiée";
            $_SESSION['message_code'] = "success";
            // On envoi vers la page d'accueil
            header('Location: /user/profil');
            exit();
        }
    }
}
