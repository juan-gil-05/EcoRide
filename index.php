<?php
// Definition de un constante pour le path depuis l'index.php
define('_ROOTPATH_', __DIR__);

// Sécurise le cookie de session avec httponly
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'domain' => $_SERVER['SERVER_NAME'],
    'httponly' => true
]);
session_start();



// Function php pour charger les namespaces
spl_autoload_register();

// Pour le système du routage
use App\Controller\Controller;

$controller = new Controller();
$controller->route();
