<?php

namespace App\Repository;

use App\Entity\Preference;
use App\Entity\PreferencePersonnelle;
use App\Entity\User;

class PreferenceRepository extends Repository
{
    // Fonction pour Insérer une préférence
    public function createPreference(int $preferenceId, int $user_id)
    {
        $sql = ("INSERT INTO User_Preference (preference_id, user_id) 
                VALUES (:preference_id, :user_id)");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":preference_id", $preferenceId, $this->pdo::PARAM_INT);
        $query->bindValue(":user_id", $user_id, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour Insérer une préférence personnelle
    public function createPersonalPreference(PreferencePersonnelle $newPreference, int $user_id)
    {
        $sql = ("INSERT INTO Preference_Personnelle (preference, user_id) 
                VALUES (:newPreference, :user_id)");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":newPreference", $newPreference->getPreference(), $this->pdo::PARAM_STR);
        $query->bindValue(":user_id", $user_id, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour chercher les péférences du chauffeur
    public function findPreferencesByDriverId(int $driverId): array
    {
        $sql = ("SELECT P.libelle AS 'preference'
                FROM User_Preference as UP
                INNER JOIN Preference AS P ON UP.preference_id = P.id
                WHERE UP.user_id = :driverId");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":driverId", $driverId, $this->pdo::PARAM_INT);
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour chercher les péférences personnelles du chauffeur
    public function findPersonalPreferenceByDriverId(int $driverId)
    {
        $sql = ("SELECT id, PP.preference AS 'personnelle'
                FROM Preference_Personnelle AS PP
                WHERE user_id = :driverId");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":driverId", $driverId, $this->pdo::PARAM_INT);
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    public function updatePreferenceById(int $prefId, string $prefEdit): void
    {
        $sql = ('UPDATE Preference_Personnelle 
                SET preference = :prefEdited
                WHERE id = :prefId');
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":prefId", $prefId, $this->pdo::PARAM_INT);
        $query->bindValue(":prefEdited", $prefEdit, $this->pdo::PARAM_STR);
        $query->execute();
    }

    public function deletePreferenceById(int $prefId): void
    {
        $sql = ('DELETE FROM Preference_Personnelle WHERE id = :prefId');
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":prefId", $prefId, $this->pdo::PARAM_INT);
        $query->execute();
    }
}
