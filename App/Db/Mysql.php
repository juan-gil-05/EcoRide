<?php
// Class pour faire la connexion avec la BDD

namespace App\Db;

use PDO;

class Mysql
{
    private $db_name;
    private $db_user;
    private $db_password;
    private $db_port;
    private $db_host;
    private $pdo = null;
    private static $_instance = null;

    public function __construct()
    {
        // Appel du fichier avec les paramètres de la BDD
        // $conf = require_once _ROOTPATH_.'./db_config.php'; 
        $conf = require_once "./db_config.php";
        
        if(isset($conf['db_name'])){
            $this->db_name = $conf['db_name'];
        }
        if(isset($conf['db_user'])){
            $this->db_user = $conf['db_user'];
        }
        if(isset($conf['db_password'])){
            $this->db_password = $conf['db_password'];
        }
        if(isset($conf['db_port'])){
            $this->db_port = $conf['db_port'];
        }
        if(isset($conf['db_host'])){
            $this->db_host = $conf['db_host'];
        }
    }

    // SINGLETON pour instancier la class Mysql 
    public static function getInstance():self
    {
        if(is_null(self::$_instance)){
            self::$_instance = new Mysql();
        }   
        return self::$_instance;
    }

    // Ajout des param à la propipriété pdo et connexion a la BDD via Objet PDO
    public function getPdo():PDO
    {
        if(is_null($this->pdo)){
            $this->pdo = new PDO('mysql:dbname='.$this->db_name.';charset=utf8;host='.$this->db_host.':'.$this->db_port, $this->db_user, $this->db_password);
        }
        return $this->pdo;
        var_dump($this->pdo);
    }


}