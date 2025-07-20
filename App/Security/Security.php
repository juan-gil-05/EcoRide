<?php

namespace App\Security;

class Security
{
    // Fonction pour savoir si l'utlisateur est connecté ou pas
    public static function isLogged()
    {
        return isset($_SESSION['user']);
    }

    // Fonction pour savoir si l'utlisateur est passager
    public static function isPassager()
    {
        if ($_SESSION['user']['role'] == "1") {
            return true;
        } else {
            return false;
        }
    }

    // Fonction pour savoir si l'utlisateur est chauffeur ou passager
    public static function isChauffeur(): bool
    {
        if ($_SESSION['user']['role'] == "2" || $_SESSION['user']['role'] == "3") {
            return true;
        } else {
            return false;
        }
    }

    // Fonction pour savoir si l'utilisateur est un employé
    public static function isEmploye(): bool
    {
        if ($_SESSION['user']['role'] == "4") {
            return true;
        } else {
            return false;
        }
    }

    // Fonction pour savoir si l'utilisateur est un admin
    public static function isAdmin(): bool
    {
        if ($_SESSION['user']['role'] == "5") {
            return true;
        } else {
            return false;
        }
    }

    // Fonction pour crypter un paramètre passé dans l'url avec l'algorithme ASE (Advanced Encryption Standard)
    public static function encryptUrlParameter($id)
    {
        // Pour appeler les variables d'environement
        $config = require BASE_PATH . "/config.php";

        // Clé pour crypter et décrypter 
        $key = $config["ENCRYPTER_KEY"];
        // Parce qu'on utilise le CBC (Cipher Block Chaining) qui a besoin d'un 'Initialization Vector'
        $IV = random_bytes(16); // 16 bytes car on utilise 128 bites
        // On crypte avec la fonction openssl
        $encrypted = openssl_encrypt($id, "AES-128-CBC", $key, 0, $IV);
        // Variable qui joint le 'Initialization Vector' avec le paramètre crypté et fait un encode 
        $base64Encoded = base64_encode($IV . $encrypted);
        // finallement, on change les symbole '+' et '/' pour éviter des erreurs au moment de décripter le IV
        return strtr($base64Encoded, '+/', '-_');
    }

    // Fonction pour décryper un paramètre passé dans l'url avec l'algorithme ASE (Advanced Encryption Standard)
    public static function decryptUrlParameter($encryptedParam)
    {
        // Pour appeler les variables d'environement
        $config = require BASE_PATH . "/config.php";

        // Clé pour crypter et décrypter 
        $key = $config["ENCRYPTER_KEY"];
        // on change les symbole '-' et '_' pour éviter les erreurs
        $base64Decoded = strtr($encryptedParam, '-_', '+/');
        // fonction pour decoder le param
        $decodedParam = base64_decode($base64Decoded);
        // Pour séparer le IV du param, (les 16 premières chiffres)
        $IV = substr($decodedParam, 0, 16);
        // Pour récuperer le param, (les chiffres après la 16ème chiffre)
        $encrypted = substr($decodedParam, 16);
        // On décripte avec la fonction openssl
        $decrypted = openssl_decrypt($encrypted, "AES-128-CBC", $key, 0, $IV);
        return $decrypted;
    }
}
