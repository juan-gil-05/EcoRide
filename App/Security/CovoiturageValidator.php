<?php

namespace App\Security;

use App\Entity\Covoiturage;

class CovoiturageValidator
{

    public function createCovoiturageValidate(Covoiturage $covoiturage): array
    {
        // Tableau d'erreurs
        $errors = [];

        // Si le champ est vide
        if (empty($covoiturage->getDateHeureDepart())) {
            $errors['dateTimeDepartEmpty'] = "Ce champ est obligatoire";
        }

        // Si le champ est vide
        if (empty($covoiturage->getDateHeureArrivee())) {
            $errors['dateTimeArriveeEmpty'] = "Ce champ est obligatoire";
        }

        // Si le champ est vide
        if (empty($covoiturage->getAdresseDepart())) {
            $errors['adresseDepartEmpty'] = "Ce champ est obligatoire";
        }

        // Si le champ est vide
        if (empty($covoiturage->getAdresseArrivee())) {
            $errors['adresseArriveeEmpty'] = "Ce champ est obligatoire";
        }

        // Si le champ est vide
        if (empty($covoiturage->getNbPlaceDisponible())) {
            $errors['nbPlaceEmpty'] = "Ce champ est obligatoire";
        }

        // Si le champ est vide
        if (empty($covoiturage->getPrix())) {
            $errors['prixEmpty'] = "Vous debez choisir un prix";
        }

        // Si le champ est vide
        if (empty($covoiturage->getVoitureId())) {
            $errors['voitureEmpty'] = "Vous debez choisir une voiture";
        }

        return $errors;
    }

    public function searchCovoiturageValidate(string $dateDepart, string $adresseDepart, string $adresseArrivee) : array 
    {
        // Tableau d'erreurs
        $errors = [];

        // Si le champ est vide
        if(empty($dateDepart)){
            $errors['dateDepartEmpty'] = "Vous debez choisir une date de départ";
        }
        // Si le champ est vide
        if(empty($adresseDepart)){
            $errors['adresseDepartEmpty'] = "Vous debez choisir une adresse de départ";
        }
        // Si le champ est vide
        if(empty($adresseArrivee)){
            $errors['adresseArriveeEmpty'] = "Vous debez choisir une adresse d'arrivée";
        }

        return $errors;
    }
}
