<?php

namespace App\Security;

use App\Entity\Covoiturage;

class CovoiturageValidator
{

    public function createCovoiturageValidate(Covoiturage $covoiturage)
    {
        $errors = [];



        if(empty($covoiturage->getDateHeureDepart())){
            $errors['dateTimeEmpty'] = "Ce champ est obligatoire";
        }

        if(empty($covoiturage->getDateHeureArrivee())){
            $errors['dateTimeEmpty'] = "Ce champ est obligatoire";
        }


        if(empty($covoiturage->getAdresseDepart())){
            $errors['adresseEmpty'] = "Ce champ est obligatoire";
        }

        if(empty($covoiturage->getAdresseArrivee())){
            $errors['adresseEmpty'] = "Ce champ est obligatoire";
        }

        if(empty($covoiturage->getNbPlaceDisponible())){
            $errors['nbPlaceEmpty'] = "Ce champ est obligatoire";
        }

        if(empty($covoiturage->getPrix())){
            $errors['prixEmpty'] = "Vous debez choisir un prix";
        }

        if(empty($covoiturage->getVoitureId())){
            $errors['voitureEmpty'] = "Vous debez choisir une voiture";
        }

        return $errors;
    }
}