<?php

namespace App\Security;

class Security
{
    // Fonction pour savoir si l'utlisateur est connecté ou pas
    public static function isLogged(){
        return isset($_SESSION['user']);
    }

    // Fonction pour savoir si l'utlisateur est passager
    public static function isPassager(){
        if($_SESSION['user']['role'] == "1"){
            return true;
        } else {
            return false;
        }
    }

    // Fonction pour savoir si l'utlisateur est chauffeur ou passager
    public static function isChauffeur(){
        if($_SESSION['user']['role'] == "2" || $_SESSION['user']['role'] == "3"){
            return true;
        } else {
            return false;
        }
    }



}