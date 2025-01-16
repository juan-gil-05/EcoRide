<?php
// Definition de un constante pour le path depuis l'index.php
define('_ROOTPATH_', __DIR__);

// Function php pour charger les namespaces
spl_autoload_register();

// Pour le système du routage
use App\Controller\Controller;

$controller = new Controller();
$controller->route();
