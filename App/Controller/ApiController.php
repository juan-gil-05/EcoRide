<?php

namespace App\Controller;

use App\Repository\CovoiturageRepository;
use DateTime;

class ApiController extends Controller
{
    // Fonction pour envoyer les données au graphique via une API fetch
    public function getGraphData()
    {
        try {
            // repository
            $covoiturageRepository = new CovoiturageRepository();

            // On récupère tous les covoiturages
            $allCovoiturages = $covoiturageRepository->getAllCovoiturages();

            $allCovoituragesDates = []; // tableau pour stocker les dates

            // On parcourt le tableau pour récupérer chaque date de départ et l'ajouter au tableau
            foreach ($allCovoiturages as $covoiturage) {
                $dateDepart = new DateTime($covoiturage['date_heure_depart']);
                $dateFormated = $dateDepart->format('d-m-Y');
                $allCovoituragesDates[] = $dateFormated;
            }
            // On compte le nombre de fois que chaque date apparaît dans le tableau
            $dataCount = array_count_values($allCovoituragesDates);

            // response JSON
            header('Content-Type: application/json');
            echo json_encode($dataCount); // On encode le tableau en JSON
            exit;
        } catch (\Exception $e) {
            // En cas d'erreur, on renvoie un message d'erreur
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
}
