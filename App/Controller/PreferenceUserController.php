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
                        // Action pour créer les préférences du chauffeur
                    case 'preferencesInscription':
                        $this->preferencesInscription();
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
        ?controller=preferences&action=preferencesInscription
    */

    public function preferencesInscription()
    {

        // Tableau d'erreurs
        $errors = [];
        $errors2 = [];
        // L'id de l'utilisateur
        $user_id = $_SESSION['user']['id'];

        try {
            $preference = new PreferenceUser;
            $preference2 = new PreferenceUser;
            $preferenceRepository = new PreferenceUserRepository;
            $preferenceValidator = new PreferenceUserValidator;
            // Si le formulaire est envoyé, on hydrate l'objet Voiture avec les données passées
            if (isset($_POST['prefInscription1'])) {
                $preference->hydrate($_POST);
                // Pour la validation des erreurs
                $errors = $preferenceValidator->newPreferenceValidator($preference);
                // S'il n'y a pas des erreurs, on crée la voiture dans la basse des données
                if (empty($errors)) {
                    $preferenceRepository->createPreference($preference, $user_id);
                } else {
                    echo ('non registré');
                }
            }
            if (isset($_POST['prefInscription2'])) {
                $preference2->hydrate($_POST);
                $errors2 = $preferenceValidator->newPreferenceValidator($preference2);
                if (empty($errors2)) {
                    $preferenceRepository->createPreference($preference2, $user_id);
                    header('Location: ?controller=page&action=accueil');
                } else {
                    echo('non registré');
                }
            }
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }

        $this->render("PreferencesUser/preferences-inscription", [
            'errors' => $errors,
            'errors2' => $errors2,
            'preference' => $preference,
            'preference2' => $preference2
        ]);
    }
}
