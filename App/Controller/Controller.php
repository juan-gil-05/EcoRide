<?php

namespace App\Controller;

use App\Tools\StringTools;
use Exception;

class Controller
{
    // Fonction pour gérer le routage - voir le .htaccess
    public function route(): void
    {
        try {
            $url = $_GET['url'] ?? "";
            $url = trim($url, '/'); // Pour supprimer les "/" au debut et a la fin de l'url
            $segments = explode('/', $url); // Pour séparer l'url dans un tableau

            $controllerName = ($segments[0]) ? $segments[0] : "page";
            // On transforme l'action passée en camelCase, afin d'utiliser la method du controller
            $action = ($segments[1]) ? StringTools::toCamelCase($segments[1]) : "accueil";

            switch ($controllerName) {
                case 'page':
                    $controller = new PageController();
                    break;
                case 'covoiturage':
                    $controller = new CovoiturageController();
                    break;
                case 'user':
                    $controller = new UserController();
                    break;
                case 'auth':
                    $controller = new AuthController();
                    break;
                case 'voiture':
                    $controller = new VoitureController();
                    break;
                case 'preference':
                    $controller = new PreferenceUserController();
                    break;
                case 'employe':
                    $controller = new EmployeController();
                    break;
                case 'admin':
                    $controller = new AdminController();
                    break;
                // pour gerer le routage de l'API
                case 'api':
                    $controller = new ApiController();
                    break;
                default:
                    throw new Exception("Ce contrôleur n'existe pas: " . $controllerName);
            };

            if (method_exists($controller, $action)) {
                $params = array_slice($segments, 2); // Pour récuperer tous les params dans un tableau
                // Appelle de l'action avec les paramètres
                $controller->$action(...$params);
                /* (...$params) = Splat Operator, qui décompresse les arguments passées dans l'url
                    pour les ajouter comme paramètres de la method du controller*/
            } else {
                throw new Exception("Cette action n'existe pas: " . $action);
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
        $filePath = BASE_PATH . "/Templates/" . $path . ".php";

        try {
            // Si le path est introuvable
            if (!file_exists($filePath)) {
                throw new Exception("Le fichier n'existe pas" . $filePath);
            } else {
                /**
                 *  Si le path est trouvé, nous créons des variables à partir du tableau $params
                 *  et on appel la vue*/
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
