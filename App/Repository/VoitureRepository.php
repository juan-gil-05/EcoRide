<?php

namespace App\Repository;

use App\Entity\Voiture;
use DateTime;

class VoitureRepository extends Repository
{
    // Fonction pour créer une nouvelle voiture 
    public function createCar(Voiture $voiture, int $user_id)
    {
        $sql = ('INSERT INTO Voiture (modele, couleur, marque, immatriculation, date_premiere_immatriculation, user_id, energie_id)
                        VALUES (:modele, :couleur, :marque, :immatriculation, :date_premiere_immatriculation, :user_id, :energie_id)');
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':modele', $voiture->getModele(), $this->pdo::PARAM_STR);
        $query->bindValue(':couleur', $voiture->getCouleur(), $this->pdo::PARAM_STR);
        $query->bindValue(':marque', $voiture->getMarque(), $this->pdo::PARAM_STR);
        $query->bindValue(':immatriculation', $voiture->getImmatriculation(), $this->pdo::PARAM_STR);
        $query->bindValue(':date_premiere_immatriculation', $voiture->getDatePremiereImmatriculation()->format("Y-m-d"), $this->pdo::PARAM_STR);
        $query->bindValue(':user_id', $user_id, $this->pdo::PARAM_INT);
        $query->bindValue(':energie_id', $voiture->getEnergieId(), $this->pdo::PARAM_INT);
        return $query->execute();
    }
}
