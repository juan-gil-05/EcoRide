<?php

namespace App\Repository;

use App\Entity\Covoiturage;

class CovoiturageRepository extends Repository
{

    // Fonction pour créer un nouveau covoiturage
    public function createCovoiturage(Covoiturage $covoiturage)
    {
        $sql = ("INSERT INTO Covoiturage 
                       (date_heure_depart, date_heure_arrivee, adresse_depart, adresse_arrivee, nb_place_disponible, prix, voiture_id, statut_id) 
                VALUES (:date_heure_depart,:date_heure_arrivee, :adresse_depart, :adresse_arrivee, :nb_place_disponible, :prix, :voiture_id, :statut_id)");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":date_heure_depart", $covoiturage->getDateHeureDepart()->format("Y-m-d H:i"), $this->pdo::PARAM_STR);
        $query->bindValue(":date_heure_arrivee", $covoiturage->getDateHeureDepart()->format("Y-m-d H:i"), $this->pdo::PARAM_STR);
        $query->bindValue(":adresse_depart", $covoiturage->getAdresseDepart(), $this->pdo::PARAM_STR);
        $query->bindValue(":adresse_arrivee", $covoiturage->getAdresseArrivee(), $this->pdo::PARAM_STR);
        $query->bindValue(":nb_place_disponible", $covoiturage->getNbPlaceDisponible(), $this->pdo::PARAM_INT);
        $query->bindValue(":prix", $covoiturage->getPrix(), $this->pdo::PARAM_INT);
        $query->bindValue(":voiture_id", $covoiturage->getVoitureId(), $this->pdo::PARAM_INT);
        $query->bindValue(":statut_id", $covoiturage->getStatutId(), $this->pdo::PARAM_INT);
        return $query->execute();
    }
}
