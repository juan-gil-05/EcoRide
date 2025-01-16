<?php

namespace App\Controller;
// require_once './App/Controller/PageController.php';

use Exception;


class Controller
{
    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['controller'])) {
                switch ($_GET['controller']) {
                        // On appel le contrôleur 
                    case 'page':
                        $controller = new PageController();
                        $controller->route();
                        break;
                    case 'covoiturages':
                        $controller = new CovoiturageController();
                        $controller->route();
                        break;
                    // Si le contrôtreul passe dans l'url n'existe pas
                    default:
                        throw new Exception("Ce contrôleur n'existe pas: ".$_GET['controller']);
                        break;
                }
            }
            // Si il n'y a pas des contôleur dans l'url 
            else {
                // On charge la page d'accueil
                $controller = new PageController();
                $controller->accueil();
            }
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }
    }

    // Fonction pour appeler à la vue via le path de la page et avec des params specifiques
    protected function render(string $path, array $params = []): void
    {
        // Path du fichier avec la vue
        $filePath = _ROOTPATH_ ."/Templates/".$path.".php";

        try {
            // Si le path est introuvable
            if (!file_exists($filePath)) {
                throw new Exception("Le fichier n'existe pas" . $filePath);
            }
            /**
             *  Si le path est trouvé, nous créons des variables à partir du tableau $params 
             *  et on appel la vue*/
            else {
                extract($params);
                require_once $filePath;
            }
        } catch (Exception $e) {
            $this->render(
                "/Errors/default",
                [
                    'error' => $e->getMessage()
                ]
            );
        }
    }
}
