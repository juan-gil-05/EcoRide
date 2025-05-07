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
            
            // Pour récupérer les dates, les nombres et les gains des covoiturages dans la plateforme par jour
            $platformCovoituragesAndGainPerDate = $covoiturageRepository->getPlatformCovoituragesAndGainPerDate();

            header('Content-Type: application/json');
            // response JSON
            echo json_encode($platformCovoituragesAndGainPerDate); // On encode le tableau en JSON
            exit;
        } catch (\Exception $e) {
            // En cas d'erreur, on renvoie un message d'erreur
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
}
