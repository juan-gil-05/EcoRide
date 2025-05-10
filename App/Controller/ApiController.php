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

            $totalGainArray = []; // Array vide pour enregistrer le nombre total de crédit gagné par la plateforme

            // On parcours le tableau pour trouver les gains journalières
            foreach($platformCovoituragesAndGainPerDate as $data){
                array_push($totalGainArray, $data['gain']);
            }
            // On fait la somme de tous les gains journalières, pour avoir le total
            $totalGainValue = array_sum($totalGainArray);


            header('Content-Type: application/json');
            // response JSON
            echo json_encode([$platformCovoituragesAndGainPerDate, $totalGainValue]); // On encode le tableau en JSON
            exit;
        } catch (\Exception $e) {
            // En cas d'erreur, on renvoie un message d'erreur
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
}
