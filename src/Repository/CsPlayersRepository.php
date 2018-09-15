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

    public function findBySteam($steamId64)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM App:CsPlayers p WHERE p.steamId64 = :steamid64'
            )
            ->setParameter('steamid64', $steamId64)
            ->getOneOrNullResult();
    }

    public function findByUsername($username)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM App:CsPlayers p WHERE p.username = :username'
            )
            ->setParameter('username', $username)
            ->getOneOrNullResult();
    }

    public function isUsername($username) {
        $find = $this->findByUsername($username);
        //$id = substr(md5(uniqid(rand(), true)), 0, 6);
        $name = $username.rand(0, 9);
        return isset($find) ? $this->isUsername($name) : $name;
    }

    
}