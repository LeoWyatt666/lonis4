<?
namespace App\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;

class CsPlayersRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    public function queryAll($search)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM App:CsPlayers p WHERE p.username LIKE :search ORDER BY p.username ASC'
            )
            ->setParameter('search', "%{$search}%");
    }
}