<?php
namespace App\Repository;

use App\Entity\Energie;

class EnergieRepository extends Repository
{
    // Fonction pour chercher le nom de l'energie par l'id passé
    public function findOneByid(int $id)
    {
        $sql = ("SELECT * FROM Energie WHERE id = :id");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':id', $id, $this->pdo::PARAM_INT);
        $query->execute();
        $energie = $query->fetch($this->pdo::FETCH_ASSOC);

        // Si on trouve une energie, alors, on hydrate la classe de l'energie avec celui trouvé
        if($energie){
            return Energie::createAndHydrate($energie);
        } else {
            return false;
        }
    }
}