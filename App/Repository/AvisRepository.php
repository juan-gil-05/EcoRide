<?php

namespace App\Repository;

use MongoDB\BSON\ObjectId;

class AvisRepository extends Repository
{
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

    // Function pour trouver tous les avis d'un chauffeur selon son id
    public function findAllAvisByDriverId(int $driverId)
    {
        $collection = $this->mongo->Avis; // pour choisir la collection Avis 
        $data = $collection->find(['user_id_cible' => $driverId]);

        $result = iterator_to_array($data);
        return $result;
    }
}
