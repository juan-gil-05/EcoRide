<?php
namespace App\Db;

require BASE_PATH.'/vendor/autoload.php'; // Autoload de composer pour charger la class Client de MongoDB

use MongoDB\Client;

class Mongodb
{
    private $db_name_mongo;
    private $db_user_mongo;
    private $db_password_mongo;
    private $db_port_mongo;
    private $db_host_mongo;
    private static $_instance = null;

    public function __construct()
    {
        // Appel du fichier avec les paramètres de la BDD
        $conf = require BASE_PATH."/db_config.php";

        if (isset($conf['db_name_mongo'])) {
            $this->db_name_mongo = $conf['db_name_mongo'];
        }
        if (isset($conf['db_user_mongo'])) {
            $this->db_user_mongo = $conf['db_user_mongo'];
        }
        if (isset($conf['db_password_mongo'])) {
            $this->db_password_mongo = $conf['db_password_mongo'];
        }
        if (isset($conf['db_port_mongo'])) {
            $this->db_port_mongo = $conf['db_port_mongo'];
        }
        if (isset($conf['db_host_mongo'])) {
            $this->db_host_mongo = $conf['db_host_mongo'];
        }
    }


    // SINGLETON pour instancier la class Mongodb une seule fois
    public static function getInstance(): self
    {
        if(is_null(self::$_instance)){
            self::$_instance = new Mongodb;
        }
        return self::$_instance;
    }

    // Fonction pour se connecter à mongodb 
    public function mongoConnect()
    {
        $user = $this->db_user_mongo;
        $password = $this->db_password_mongo;
        $host = $this->db_host_mongo;
        $port = $this->db_port_mongo;
        $dbName = $this->db_name_mongo;

        // Connection string en LOCAL
        // $connectionPath = "mongodb://".$user.":".$password."@".$host.":".$port."/".$dbName;
        // Connection string en mongoDB Atlas
        $connectionPath = "mongodb+srv://ecorideAtlasUser:EMbrkLd2qKK7a1Lp@ecoridecluster.w66nwkr.mongodb.net/?retryWrites=true&w=majority&appName=EcoRideCluster";
        // Instance de la classe Client
        $mongo = new Client($connectionPath);
        $db = $mongo->selectDatabase($dbName); // Sélection de la base de données
        // On retourne l'instance de la base de données
        return $db;
    }
}
