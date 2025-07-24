<?php

namespace App\Repository;

use DateTime;

class AuthRepository extends Repository
{
    /* Fonction pour réinitialiser dans la BDD les champs:
       login_attempts et locked_until
       si le mot de passe est correct */
    public function loginAttemptsAndLockedReinit(int $userId): bool
    {
        $query = $this->pdo->prepare("UPDATE User 
                                    SET login_attempts = 0, locked_until = NULL 
                                    WHERE id = :userId");
        $query->bindValue(":userId", $userId, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    public function accountLocked(int $userId, int $attempts, ?string $lockedUntil): bool
    {
        $query = $this->pdo->prepare("UPDATE User 
                                    SET login_attempts = :attempts, 
                                    locked_until = :lockedUntil 
                                    WHERE id = :userId");
        $query->bindValue(":attempts", $attempts, $this->pdo::PARAM_INT);
        $query->bindValue(":lockedUntil", $lockedUntil, $this->pdo::PARAM_STR);
        $query->bindValue(":userId", $userId, $this->pdo::PARAM_INT);
        return $query->execute();
    }
}
