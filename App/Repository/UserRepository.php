<?php

namespace App\Repository;

use App\Entity\User;

class UserRepository extends Repository
{
    // Fonction pour créer un nouveau utilisateur
    public function createUser(User $user)
    {
        $sql = ("INSERT INTO User (pseudo, mail, password) VALUES (:pseudo,:mail,:mdp)");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":pseudo", $user->getPseudo(), $this->pdo::PARAM_STR);
        $query->bindValue(":mail", $user->getMail(), $this->pdo::PARAM_STR);
        $query->bindValue(":mdp", $user->getPassword(), $this->pdo::PARAM_STR);
        return $query->execute();
    }

    // Fonction pour trouver un utilisateur par son mail
    public function findOneByMail(string $mail)
    {
        $sql = ("SELECT * FROM User WHERE mail = :mail");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':mail', $mail, $this->pdo::PARAM_STR);
        $query->execute();
        $user = $query->fetch($this->pdo::FETCH_ASSOC);

        // Si on trouve un utilisateur, alors, on hydrate la classe de l'utilisateur avec celui trouvé
        if($user){
            return User::createAndHydrate($user);
        } else {
            return false;
        }
    }

}
