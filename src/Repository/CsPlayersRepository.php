<?
namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class CsPlayersRepository extends EntityRepository
{
    public function queryAll($search)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM App:CsPlayers p WHERE p.name LIKE :search ORDER BY p.name ASC'
            )
            ->setParameter('search', "%{$search}%");
    }
}