<?php

// Pour charger les namespaces
require_once __DIR__ . '/../vendor/autoload.php';

/** Paramètres de la session de l'utilisateur
 *  Sécurise le cookie de session avec httponly
 *  */

session_set_cookie_params([
    'lifetime' => 86400, //24 heures
    'path' => '/',
    'domain' => $_SERVER['SERVER_NAME'],
    'httponly' => true
]);
// Initialisation de la session
session_start();

// On definit le path pour appeler les fichier depuis l'index, afin d'eviter des erreurs dans le serveur
define('BASE_PATH', dirname(__DIR__));
// Pour utiliser la bonne zone horaire
date_default_timezone_set('Europe/Paris');

// Pour le système du routage
use App\Controller\Controller;

$controller = new Controller();
$controller->route();

// Fichier pour afficher les messages d'information à l'utilisateur
require_once BASE_PATH . '/App/Tools/SweetAlerts.php';
