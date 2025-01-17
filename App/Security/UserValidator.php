<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;

class UserValidator
{
    public function singUpValidate(User $userHydrate):array
    {
        $errors = [];
        $user = $userHydrate;

        if(empty($user->getPseudo())){
            $errors['pseudo'] = "Vous debez choisir un pseudo";
        }
        if(empty($user->getMail())){
            $errors['mail'] = "Le champ mail ne doit pas être vide";
        }else if(!filter_var($user->getMail(), FILTER_VALIDATE_EMAIL)){
            $errors['mail'] = "Le mail n\'est pas valide";
        }   
        if(empty($user->getPassword())){
            $errors['password'] = "Le champ mot de passe ne doit pas être vide";
        }

        return $errors;
    }

    public function verifyPassword(string $password)
    {
        $userRepository = new UserRepository;
        $user = $userRepository->findOneByMail($_POST['mail']);

        if(password_verify($password, $user->getPassword())){
            return true;
        } else {
            return false;
        }
    }
}