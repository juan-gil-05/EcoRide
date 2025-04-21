<?php

namespace App\Repository;

class AvisRepository extends Repository
{
    // Fonction pour chercher tous les avis avec les notes des chauffeurs
    public function searchAllAvisAndNotes(): array
    {
        $sql = ("SELECT * FROM Avis");
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
    
}
