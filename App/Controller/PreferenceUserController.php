<?php

namespace App\Controller;

use App\Entity\PreferenceUser;
use App\Repository\PreferenceUserRepository;
use App\Security\PreferenceUserValidator;
use Exception;

class PreferenceUserController extends Controller
{
    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    // Actions pour créer les préférences du chauffeur
                    case 'preferencesInscriptionSmoker':
                        $this->preferencesInscriptionSmoker();
                        break;
                    case 'preferencesInscriptionAnimal':
                        $this->preferencesInscriptionAnimal();
                        break;
                    case 'preferencesInscriptionPersonal':
                        $this->preferencesInscriptionPersonal();
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
        ?controller=preferences&action=preferencesInscriptionSmoker
    */
    // Fonction pour enregistrer une nouvelle préférence
    public function preferencesInscriptionSmoker()
    {
        // Tableau d'erreurs
        $errors = [];
        // L'id de l'utilisateur
        $user_id = $_SESSION['user']['id'];

        try {
            $preference = new PreferenceUser;
            $preferenceRepository = new PreferenceUserRepository;
            $preferenceValidator = new PreferenceUserValidator;
            if (isset($_POST['prefInscriptionSmoker'])) {
                $preference->hydrate($_POST);
                // Pour la validation des erreurs
                $errors = $preferenceValidator->newPreferenceValidator($preference);
                // S'il n'y a pas des erreurs, on crée la préférence dans la base des données
                if (empty($errors)) {
                    $preferenceRepository->createPreference($preference, $user_id);
                    // On envoi vers la page suivante pour continuer l'insciption
                    header('Location: ?controller=preferences&action=preferencesInscriptionAnimal');
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
        ?controller=preferences&action=preferencesInscriptionAnimal
    */
    // Fonction pour enregistrer une nouvelle préférence
    public function preferencesInscriptionAnimal()
    {
        // Tableau d'erreurs
        $errors = [];
        // L'id de l'utilisateur
        $user_id = $_SESSION['user']['id'];

        try {
            $preference = new PreferenceUser;
            $preferenceRepository = new PreferenceUserRepository;
            $preferenceValidator = new PreferenceUserValidator;

            if (isset($_POST['prefInscriptionAnimal'])) {
                $preference->hydrate($_POST);
                // Pour la validation des erreurs
                $errors = $preferenceValidator->newPreferenceValidator($preference);
                // S'il n'y a pas des erreurs, on crée la préférence dans la base des données
                if (empty($errors)) {
                    $preferenceRepository->createPreference($preference, $user_id);
                    // On envoi vers la page suivante pour continuer l'insciption
                    header('Location: ?controller=preferences&action=preferencesInscriptionPersonal');
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
        ?controller=preferences&action=preferencesInscriptionPersonal
    */
    // Fonction pour enregistrer une nouvelle préférence personnelle
    public function preferencesInscriptionPersonal()
    {
        // Tableau d'erreurs
        $errors = [];
        // L'id de l'utilisateur
        $user_id = $_SESSION['user']['id'];
        $preferenceRepository = new PreferenceUserRepository;

        // Pour enregistrer une nouvelle préférence personnelle
        $personalPreference = new PreferenceUser;
        if (isset($_POST['newPersonalPreference'])) {
            // On hydrate l'objet avec les données passées
            $personalPreference->hydrate($_POST);
            // Pour la créer dans la base de données 
            $preferenceRepository->createPreference($personalPreference, $user_id);
            // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
            $_SESSION['message_to_User'] = "Préférence sauvegardée";
            $_SESSION['message_code'] = "success";
            // On envoi vers la page d'accueil
            header('Location: ?controller=user&action=profil');
            exit();
        }

        $this->render("PreferencesUser/preferences-inscription-personal", [
            'errors' => $errors,
        ]);
    }
}
