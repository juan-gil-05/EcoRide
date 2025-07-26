<?php

namespace App\Security;

use App\Entity\Preference;

class PreferenceValidator
{
    // Fonction pour valider le formulaire des préférences utilisateur
    public function newPreferenceValidator($preferenceSmoker, $preferenceAnimal)
    {
        $errors = [];

        if (empty($preferenceSmoker)) {
            $errors['preferenceSmokerEmpty'] = "Vous debez choisir une réponse";
        }
        if (empty($preferenceAnimal)) {
            $errors['preferenceAnimalEmpty'] = "Vous debez choisir une réponse";
        }
        return $errors;
    }
}
