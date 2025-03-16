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
        $query->bindValue(":date_heure_arrivee", $covoiturage->getDateHeureArrivee()->format("Y-m-d H:i"), $this->pdo::PARAM_STR);
        $query->bindValue(":adresse_depart", $covoiturage->getAdresseDepart(), $this->pdo::PARAM_STR);
        $query->bindValue(":adresse_arrivee", $covoiturage->getAdresseArrivee(), $this->pdo::PARAM_STR);
        $query->bindValue(":nb_place_disponible", $covoiturage->getNbPlaceDisponible(), $this->pdo::PARAM_INT);
        $query->bindValue(":prix", $covoiturage->getPrix(), $this->pdo::PARAM_INT);
        $query->bindValue(":voiture_id", $covoiturage->getVoitureId(), $this->pdo::PARAM_INT);
        $query->bindValue(":statut_id", $covoiturage->getStatutId(), $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour checher des covoiturages
    public function searchCovoiturageByDateAndAdresse(string $adresseDepart, string $adresseArrivee, ?string $dateDepart = null): array
    {
        $sql = ("SELECT * FROM Covoiturage
                WHERE adresse_depart LIKE :adresseDepart AND
                adresse_arrivee LIKE :adresseArrivee
                ");

        // Si on passe la date de départ, alors on l'ajout au query sql
        (!empty($dateDepart)) ? $sql .= " AND date_heure_depart LIKE :dateDepart" : null;

        $query = $this->pdo->prepare($sql);

        $query->bindValue(":adresseDepart", "%$adresseDepart%", $this->pdo::PARAM_STR);
        $query->bindValue(":adresseArrivee", "%$adresseArrivee%", $this->pdo::PARAM_STR);
        // Si on passe la date de départ, alors on fait le bindValue avec la donée passée 
        (!empty($dateDepart)) ? $query->bindValue(":dateDepart", "%$dateDepart%", $this->pdo::PARAM_STR) : null;

        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour checher tous les détails des covoiturages par le covoiturage ID
    public function searchCovoiturageDetailsById(int $CovoiturageId): array
    {
        $sql = ("SELECT Covoiturage.*, Covoiturage.id as covoiturage_id,
                User.pseudo, User.photo_uniqId, User.nb_credits, User.id as user_id,
                Voiture.marque, Voiture.modele, 
                Energie.id as energie_id, Energie.libelle as energie
                FROM Covoiturage
                INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
                INNER JOIN User ON Voiture.user_id = User.id
                INNER JOIN Energie ON Voiture.energie_id = Energie.id
                WHERE Covoiturage.id = :CovoiturageId;
                ");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":CovoiturageId", $CovoiturageId, $this->pdo::PARAM_INT);
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour checher que des covoiturages écologiques
    public function filterSearchCovoiturage(
        string $dateDepart,
        string $adresseDepart,
        string $adresseArrivee,
        ?int $energiId = null,
        ?int $maxPrice = null,
        ?int $maxDuration = null
    ): array {
        $sql = ("SELECT Covoiturage.* FROM Covoiturage
                INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
                INNER JOIN Energie ON Voiture.energie_id = Energie.id
                WHERE date_heure_depart LIKE :dateDepart AND 
                adresse_depart LIKE :adresseDepart AND
                adresse_arrivee LIKE :adresseArrivee
                ");

        // Si on passe des paramètres des filtres, on les ajout au query sql
        (!empty($energiId)) ? $sql .= " AND  Energie.id = :energiId" : null;
        (!empty($maxPrice)) ? $sql .= " AND  prix <= :price" : null;
        (!empty($maxDuration)) ? $sql .= " AND  TIMESTAMPDIFF(HOUR, date_heure_depart, date_heure_arrivee) <= :maxDuration" : null;

        $query = $this->pdo->prepare($sql);
        $query->bindValue(":dateDepart", "%$dateDepart%", $this->pdo::PARAM_STR);
        $query->bindValue(":adresseDepart", "%$adresseDepart%", $this->pdo::PARAM_STR);
        $query->bindValue(":adresseArrivee", "%$adresseArrivee%", $this->pdo::PARAM_STR);
        // Si on passe des paramètres des filtres, on fait les bindValue
        (!empty($energiId)) ? $query->bindValue(":energiId", $energiId, $this->pdo::PARAM_INT) : null;
        (!empty($maxPrice)) ? $query->bindValue(":price", $maxPrice, $this->pdo::PARAM_INT) : null;
        (!empty($maxDuration)) ? $query->bindValue(":maxDuration", $maxDuration, $this->pdo::PARAM_INT) : null;
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour enregistrer la participation à un covoiturage
    public function participateToCovoiturage(int $userId, int $covoiturageId)
    {
        $sql = "INSERT INTO User_Covoiturages (user_id, covoiturage_id)
                VALUES (:userId, :covoiturageId)";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":userId", $userId, $this->pdo::PARAM_INT);
        $query->bindValue(":covoiturageId", $covoiturageId, $this->pdo::PARAM_INT);
        return $query->execute();
    }
}
