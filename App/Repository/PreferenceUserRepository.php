<?php

namespace App\Repository;

use App\Entity\PreferenceUser;
use App\Entity\User;

class PreferenceUserRepository extends Repository
{
    // Fonction pour Insérer une préférence 
    public function createPreference(PreferenceUser $UserPreference, int $user_id)
    {
        $sql = ("INSERT INTO User_Preferences (preference_personnelle, preference_id, user_id) 
                VALUES (:preference_personnelle, :preference_id, :user_id)");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":preference_personnelle", $UserPreference->getPreferencePersonnelle(), $this->pdo::PARAM_STR);
        $query->bindValue(":preference_id", $UserPreference->getPreferenceId(), $this->pdo::PARAM_INT);
        $query->bindValue(":user_id", $user_id, $this->pdo::PARAM_INT);
        return $query->execute();
    }
}
