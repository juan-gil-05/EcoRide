<?php

namespace App\Repository;

use App\Db\Mysql;
use PDO;

class Repository
{
    public PDO $pdo;

    public function __construct()
    {
        // On appele une instance de la class Mysql pour appeler la base de données
        $mysql = Mysql::getInstance();
        // Et on "passe" l'instance à l'objet PDO pour créer la conexion a la BDD
        $this->pdo = $mysql->getPdo();
    }
}