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
    public function searchCovoiturageByDateAndAdresse(string $dateDepart, string $adresseDepart, string $adresseArrivee): array
    {
        $sql = ("SELECT * FROM Covoiturage
                WHERE date_heure_depart LIKE :dateDepart AND 
                adresse_depart LIKE :adresseDepart AND
                adresse_arrivee LIKE :adresseArrivee
                ");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":dateDepart", "%$dateDepart%", $this->pdo::PARAM_STR);
        $query->bindValue(":adresseDepart", "%$adresseDepart%", $this->pdo::PARAM_STR);
        $query->bindValue(":adresseArrivee", "%$adresseArrivee%", $this->pdo::PARAM_STR);
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour checher les covoiturages avec son energie ID
    public function searchCovoiturageWithEnergieId(int $CovoiturageId): array
    {
        $sql = ("SELECT Energie.id as energie_id, Covoiturage.id as covoiturage_id
                FROM Covoiturage
                INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
                INNER JOIN Energie ON Voiture.energie_id = Energie.id
                WHERE Covoiturage.id = :CovoiturageId;
                ");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":CovoiturageId", $CovoiturageId, $this->pdo::PARAM_INT);
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour checher les covoiturages avec son energie ID
    public function searchCovoiturageWithAllDrivers(int $CovoiturageId): array
    {
        $sql = ("SELECT User.pseudo, User.photo_uniqId, Covoiturage.id as covoiturage_id
                FROM Covoiturage
                INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
                INNER JOIN User ON Voiture.user_id = User.id
                WHERE Covoiturage.id = :CovoiturageId;
                ");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":CovoiturageId", $CovoiturageId, $this->pdo::PARAM_INT);
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour checher le covoiturage par son ID
    public function searchCovoiturageDetailById(int $CovoiturageId): array
    {
        $sql = ("SELECT * FROM Covoiturage
                WHERE Covoiturage.id = :CovoiturageId;
            ");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":CovoiturageId", $CovoiturageId, $this->pdo::PARAM_INT);
        $query->execute();

        return $query->fetch($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour checher le chauffeur par l'ID du covoiturage
    public function searchCovoiturageWithDriver(int $CovoiturageId): array
    {
        $sql = ("SELECT User.pseudo, User.id, User.photo_uniqId, Covoiturage.id as covoiturage_id
                FROM Covoiturage
                INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
                INNER JOIN User ON Voiture.user_id = User.id
                WHERE Covoiturage.id = :CovoiturageId;
                ");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":CovoiturageId", $CovoiturageId, $this->pdo::PARAM_INT);
        $query->execute();

        return $query->fetch($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour les détaille de la voiture par l'ID du covoiturage
    public function searchCovoiturageWithCarInfoById(int $CovoiturageId): array
    {
        $sql = ("SELECT Voiture.marque, Voiture.modele, Energie.libelle as energie
                FROM Covoiturage
                INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
                INNER JOIN Energie ON Voiture.energie_id = Energie.id
                WHERE Covoiturage.id = :coviturageId;
                ");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":coviturageId", $CovoiturageId, $this->pdo::PARAM_INT);
        $query->execute();
        return $query->fetch($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour chercher tous les covoiturages selon les adresse de départ et d'arrivée
    public function searchAllCovoituragerByAdresse(string $adresseDepart, string $adresseArrivee): array
    {
        $sql = ("SELECT * FROM Covoiturage
                WHERE adresse_depart = :adresseDepart && adresse_arrivee = :adresseArrivee;");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":adresseDepart", $adresseDepart, $this->pdo::PARAM_STR);
        $query->bindValue(":adresseArrivee", $adresseArrivee, $this->pdo::PARAM_STR);
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

}
