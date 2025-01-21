<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;

class UserValidator
{

    public function singUpValidate(User $userHydrate): array
    {
        $errors = [];
        $user = $userHydrate;
        $userRepository = new UserRepository;
        $regex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).{12,}$/';

        if (empty($user->getPseudo())) {
            $errors['pseudoEmpty'] = 'Le champ pseudo ne doit pas être vide';
        }


        if (empty($user->getMail())) {
            $errors['mailEmpty'] = "Le champ mail ne doit pas être vide";
        } elseif (!filter_var($user->getMail(), FILTER_VALIDATE_EMAIL)) {
            $errors['mail'] = "Le mail n\'est pas valide";
        } elseif ($userRepository->findOneByMail($user->getMail())) {
            $errors['mailUsed'] = "Le e-mail est déjà utilisé";
        }

        if (empty($user->getPassword())) {
            $errors['passwordEmpty'] = "Le champ mot de passe ne doit pas être vide";
        } elseif (strlen($_POST['password']) < 12) {
            $errors['passwordLen'] = "Le mot de passe doit comporter au moins 12 caractères";
        } elseif (! preg_match($regex, $_POST['password'])) {
            $errors['passwordInfo'] = "Votre mot de passe doit contenir :
	                                Une lettre majuscule et une lettre minuscule,
	                                un chiffre et
	                                un caractère spécial";
        }
        return $errors;
    }



    public function logInValidate(User $user): array
    {
        $errors = [];

        if (empty($user->getMail())) {
            $errors['mail'] = "Vous devez mettre une adresse e-mail";
        }

        return $errors;
    }

    public function passwordVerify(User $user)
    {
        if ($user && password_verify($_POST['password'], $user->getPassword())) {
            return true;
        } else {
            return false;
        }
    }
}
