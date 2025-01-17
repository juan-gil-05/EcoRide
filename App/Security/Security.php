<?php

namespace App\Security;

class Security
{
    public static function isLogged(){
        return isset($_SESSION['user']);
    }
}