<?php

namespace App\Repository;

use MongoDB\BSON\ObjectId;

class AvisRepository extends Repository
{

    // Fonction pour chercher tous les avis d'un conducteur par son id
    public function searchAllAvisByDriverId(int $userId): array
    {
        $sql = ("SELECT * FROM Avis WHERE user_id_cible = :userId");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':userId', $userId, $this->pdo::PARAM_INT);
        $query->execute();
        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // MongoDB SECTION

    // Function pour insérer un avis et une note sur un chauffeur 
    public function insertAvisAndNote(string $titre, string $avis, int $note, int $userIdAuteur, int $userIdCible, int $covoiturageId)
    {
        $collection = $this->mongo->Avis; // pour choisir la collection Avis 
        $data = $collection->insertOne([
            'titre' => $titre,
            'avis' => $avis,
            'note' => $note,
            'accepte' => false,
            'user_id_auteur' => $userIdAuteur,
            'user_id_cible' => $userIdCible,
            'covoiturage_id' => $covoiturageId
        ]);
        return $data;
    }

    // Fonction pour trouver tous les avis et notes des chauffeurs 
    public function findAllAvisAndNotes(): object
    {
        $collection = $this->mongo->Avis; // pour choisir la collection Avis 
        $data = $collection->find([], ['sort' => ['accepte' => 1]]);
        return $data;
    }

    // Fonction pour changer le statut de l'avis selon le choix de l'employé
    public function updateAvisStatut(int $avisStatut, string $avisId)
    {
        $collection = $this->mongo->Avis;
        $data = $collection->updateOne(
            ['_id' => new ObjectId($avisId)], // le filtre
            ['$set' => ['accepte' => $avisStatut]] // la modification
        );
        return $data;
    }
}
