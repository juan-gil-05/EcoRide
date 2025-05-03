<?php
require 'vendor/autoload.php'; // si usaste Composer

use MongoDB\Client;

$mongo = new Client("mongodb://localhost:27017");

$db = $mongo->EcoRideMongo; // crea o selecciona una base de datos
$collection = $db->test; // crea o selecciona una colección

// Insertar un documento
$insertOneResult = $collection->insertOne([
    'nombre' => 'Juan',
    'correo' => 'juan@ejemplo.com'
]);

// echo "Insertado con ID: " . $insertOneResult->getInsertedId();

// Encontrar un documento
$doc = $collection->findOne(['nombre' => 'Juan']);

print_r($doc['correo']);
// var_dump($doc);

