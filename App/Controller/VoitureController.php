<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use App\Security\Security;
use App\Security\VoitureValidator;
use Exception;

class VoitureController extends Controller
{
    /*
    Exemple d'appel depuis l'url
        /voiture/inscription
    */

    // Fonction pour enregistrer une voiture
    protected function inscription()
    {
        // Si l'utilisateur est connecté
        if (Security::isLogged()) {
            // Tableau d'erreurs
            $errors = [];
            // L'id de l'utilisateur
            $user_id = $_SESSION['user']['id'];
            // Varibles pour autocompléter le formulaire
            $immatriculation = "";
            $dateImmatriculation = "";
            $marque = "";
            $modele = "";
            $couleur = "";

            try {
                $voiture = new Voiture();
                $voitureRepository = new VoitureRepository();
                $voitureValidator = new VoitureValidator();

                // Si le formulaire est envoyé, on hydrate l'objet Voiture avec les données passées
                if (isset($_POST['carInscription'])) {
                    $voiture->hydrate($_POST);
                    $immatriculation = $voiture->getImmatriculation();
                    $dateImmatriculation = $voiture->getDatePremiereImmatriculation();
                    $marque = $voiture->getMarque();
                    $modele = $voiture->getModele();
                    $couleur = $voiture->getCouleur();
                    // Pour valider s'il n'y a pas des erreurs dans le formulaire
                    $errors = $voitureValidator->newCarValidate($voiture);
                    // S'il n'y a pas des erreurs, on crée la voiture dans la basse des données
                    if (empty($errors)) {
                        $voitureRepository->createCar($voiture, $user_id);
                        // Pour trouver tous les voitures de l'utilisateur
                        $cars = $voitureRepository->findAllCarsByUserId($user_id);
                        // Si l'utilisateur a 2 ou plus de 2 voitures, alors on envoi vers la page d'accueil
                        if (count($cars) >= 2) {
                            // On crée cette session pour pouvoir afficher le message de succès,
                            // le message_code c'est pour l'icon de SweetAlert
                            $_SESSION['message_to_User'] = "Voiture crée avec succès";
                            $_SESSION['message_code'] = "success";
                            // On redirige vers la page d'accueil
                            header('location: /user/profil');
                            exit;
                        } else {
                            // On evoi vers la page pour enregistrer les préférences
                            header('Location: /preference/enregistrement');
                        }
                    }
                }
            } catch (Exception $e) {
                $this->render("Errors/404", [
                    'error' => $e->getMessage()
                ]);
            }
            $this->render(
                "Voiture/voiture-inscription",
                [
                    "errors" => $errors,
                    "immatriculation" => $immatriculation,
                    "dateImmatriculation" => $dateImmatriculation,
                    "marque" => $marque,
                    "modele" => $modele,
                    "couleur" => $couleur
                ]
            );
        } else {
            // Sinon on envoie à la page de connexion
            header('Location: /auth/connexion');
        }
    }
}
