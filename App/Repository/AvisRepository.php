<?php

namespace App\Repository;

class AvisRepository extends Repository
{
    // Fonction pour chercher tous les avis avec les notes des chauffeurs
    public function searchAllAvisAndNotes(): array
    {
        $sql = ("SELECT * FROM Avis ORDER BY statut ASC;");
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour ajouter un avis et une note au covoiturage
    public function addAvisAndNote(string $titre, string $avis, int $note, bool $statut, int $userIdAuteur, int $userIdCible, int $covoiturageId): bool
    {
        $sql = "INSERT INTO Avis (titre, avis, note, statut, user_id_auteur, user_id_cible, covoiturage_id)
                    VALUES (:titre, :avis, :note, :statut, :userIdAuteur, :userIdCible, :covoiturageId);";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":titre", $titre, $this->pdo::PARAM_STR);
        $query->bindValue(":avis", $avis, $this->pdo::PARAM_STR);
        $query->bindValue(":note", $note, $this->pdo::PARAM_INT);
        $query->bindValue(":statut", $statut, $this->pdo::PARAM_BOOL);
        $query->bindValue(":userIdAuteur", $userIdAuteur, $this->pdo::PARAM_INT);
        $query->bindValue(":userIdCible", $userIdCible, $this->pdo::PARAM_INT);
        $query->bindValue(":covoiturageId", $covoiturageId, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour mettre à jour le statut de l'avis, après la validation d'un employé
    public function updateAvisStatut(int $avisStatut, int $avisId) : bool
    {
        $sql = "UPDATE Avis SET statut = :avisStatut WHERE avis_id = :avisId";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":avisStatut", $avisStatut, $this->pdo::PARAM_INT);
        $query->bindValue(":avisId", $avisId, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour chercher tous les avis d'un conducteur par son id
    public function searchAllAvisByDriverId(int $userId): array
    {
        $sql = ("SELECT * FROM Avis WHERE user_id_cible = :userId");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':userId', $userId, $this->pdo::PARAM_INT);
        $query->execute();
        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }


}
