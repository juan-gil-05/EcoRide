<?php

namespace App\Repository;

use App\Entity\PreferenceUser;
use App\Entity\User;

class PreferenceUserRepository extends Repository
{
    // Fonction pour Insérer une préférence
    public function createPreference(PreferenceUser $UserPreference, int $user_id)
    {
        $sql = ("INSERT INTO User_Preference (preference_personnelle, preference_id, user_id) 
                VALUES (:preference_personnelle, :preference_id, :user_id)");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(
            ":preference_personnelle",
            $UserPreference->getPreferencePersonnelle(),
            $this->pdo::PARAM_STR
        );
        $query->bindValue(":preference_id", $UserPreference->getPreferenceId(), $this->pdo::PARAM_INT);
        $query->bindValue(":user_id", $user_id, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour chercher les péférences du chauffeur
    public function searchPreferencesByDriverId(int $driverId, bool $onlyPersoPref = false): array
    {
        // On utilise le 'DISTINCT' pour récupérer q'une fois la valeur libelle, si elle est répétée
        $sql = ('SELECT DISTINCT UP.id, Preference.libelle, 
                                 UP.preference_personnelle as personnelle
                FROM User_Preference as UP
                INNER JOIN User ON UP.user_id = User.id
                INNER JOIN Preference ON UP.preference_id = Preference.id
                WHERE User.id = :driverId');
        // si onlyPersoPref est true, on récupére uniquement les préférences personnelles
        if ($onlyPersoPref) {
            $sql .= ' AND UP.preference_personnelle != ""';
        }
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":driverId", $driverId, $this->pdo::PARAM_INT);
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    public function updatePreferenceById(int $prefId, string $prefEdit): void
    {
        $sql = ('UPDATE User_Preference 
                SET preference_personnelle = :prefEdited
                WHERE id = :prefId');
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":prefId", $prefId, $this->pdo::PARAM_INT);
        $query->bindValue(":prefEdited", $prefEdit, $this->pdo::PARAM_STR);
        $query->execute();
    }

    public function deletePreferenceById(int $prefId): void
    {
        $sql = ('DELETE FROM User_Preference WHERE id = :prefId');
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":prefId", $prefId, $this->pdo::PARAM_INT);
        $query->execute();
    }
}
