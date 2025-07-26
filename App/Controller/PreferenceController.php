<?php

namespace App\Controller;

use App\Entity\Preference;
use App\Entity\PreferencePersonnelle;
use App\Repository\PreferenceRepository;
use App\Security\PreferenceValidator;
use App\Security\Security;
use Exception;

class PreferenceController extends Controller
{
    /*
    Exemple d'appel depuis l'url
        /preference/enregistrement
    */
    // Fonction pour enregistrer les préférences avant just après créer un compte
    public function enregistrement()
    {

        if (!Security::isLogged()) {
            header('Location: /auth/connexion');
        }
        // Tableau d'erreurs
        $errors = [];
        // L'id de l'utilisateur
        $userId = $_SESSION['user']['id'];
        $preferenceSmoker = null;
        $preferenceAnimal = null;
        $personnelle = null;

        try {
            $preferencePersonnelle = new PreferencePersonnelle();
            $preferenceRepository = new PreferenceRepository();
            $preferenceValidator = new PreferenceValidator();
            if (isset($_POST['prefInscription'])) {
                $preferenceSmoker = $_POST['preference_smoker'] ?? null;
                $preferenceAnimal = $_POST['preference_animal'] ?? null;
                $personnelle = $_POST['preference'] ?? null;

                // Pour la validation des erreurs
                $errors = $preferenceValidator->newPreferenceValidator($preferenceSmoker, $preferenceAnimal);

                // S'il n'y a pas des erreurs, on crée la préférence dans la base des données
                if (empty($errors)) {
                    $preferenceRepository->createPreference($preferenceSmoker, $userId);
                    $preferenceRepository->createPreference($preferenceAnimal, $userId);

                    // Pour eregistrer la préférence presonnelle
                    if (!empty($_POST['preference'])) {
                        $preferencePersonnelle->hydrate($_POST);
                        $preferenceRepository->createPersonalPreference($preferencePersonnelle, $userId);
                    }

                    $_SESSION['message_to_User'] = "Compte crée avec succès";
                    $_SESSION['message_code'] = "success";
                    // On envoi vers la page du profil
                    header('Location: /user/profil');
                    exit;
                }
            }
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }

        $this->render("PreferencesUser/preferences-inscription", [
            'errors' => $errors,
            'preferenceSmoker' => $preferenceSmoker,
            'preferenceAnimal' => $preferenceAnimal,
            'preferencePersonnelle' => $personnelle,
        ]);
    }

    // Fonction pour enregistrer une nouvelle préférence personnelle depuis la page profil
    public function creerPersonnelle()
    {
        // L'id de l'utilisateur
        $user_id = $_SESSION['user']['id'];
        $preferenceRepository = new PreferenceRepository();

        // Pour enregistrer une nouvelle préférence personnelle
        $personalPreference = new PreferencePersonnelle();
        if (isset($_POST['newPersonalPreference'])) {
            // On hydrate l'objet avec les données passées
            $personalPreference->hydrate($_POST);
            // Pour la créer dans la base de données
            $preferenceRepository->createPersonalPreference($personalPreference, $user_id);
            // On crée cette session pour pouvoir afficher le message de succès,
            // le message_code c'est pour l'icon de SweetAlert
            $_SESSION['message_to_User'] = "Préférence sauvegardée";
            $_SESSION['message_code'] = "success";
            // On envoi vers la page d'accueil
            header('Location: /user/profil');
            exit();
        }
    }

    // Fonction pour éditer une préférence personnelle
    public static function editPersonnelle()
    {
        $preferenceRepository = new PreferenceRepository();

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
