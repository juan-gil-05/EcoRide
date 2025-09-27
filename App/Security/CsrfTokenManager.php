<?php

namespace App\Security;

use App\Controller\Controller;

class CsrfTokenManager
{
    // Constructeur de la classe CsrfTokenManager qui initialise le token CSRF
    public function __construct()
    {
        // Créer le token (string aleatoire)
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        // Limiter la durée de vie du token pour plus de sécurité
        if (empty($_SESSION['csrf_token_expires'])) {
            $_SESSION['csrf_token_expires'] = time() + 3600; // 1 heure
        }
    }
    // Pour vérifier le token en session avec celui envoyé dans la requête
    private static function validateToken(): array
    {
        $errors = [];
        if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token'])) {
            $errors[] = 'invalidToken';
            return $errors;
        }
        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            $errors[] = 'invalidToken';
            return $errors;
        }
        if (time() > ($_SESSION['csrf_token_expires'] ?? 0)) {
            $errors[] = 'tokenExpired';
            return $errors;
        }
        return $errors;
    }
    // Fonction appelée depuis le index.php
    public static function middleware(): void
    {
        // On ne vérifie le CSRF que sur les requêtes sensibles (POST, PUT, DELETE)
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        if (in_array($method, ['POST', 'PUT', 'DELETE'])) {
            $errors = CsrfTokenManager::validateToken();

            if (!empty($errors)) {
                $message = [];
                if (in_array('invalidToken', $errors)) {
                    $message[] = "Erreur CSRF : requête non valide !";
                }
                if (in_array('tokenExpired', $errors)) {
                    $message[] = "Erreur CSRF : Token expiré !";
                }

                http_response_code(403);
                // Render vers la page d'erreur,
                $controller = new Controller();
                self::resetTokenCsrf();
                $controller->render("Errors/403", ['error' => $message]);
                exit;
            }
        }
    }
    // Fonction pour réinitialiser le token CSRF
    public static function resetTokenCsrf(): void
    {
        // Le token est validé, alors, on le supprime pour éviter la réutilisation
        unset($_SESSION['csrf_token'], $_SESSION['csrf_token_expires']);
    }
}
