<?
namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class CsServersRepository extends EntityRepository
{
    public function _queryAll($search)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT s, m FROM App:CsServers s LEFT JOIN s.CsServersMod m WHERE s.addres = :search OR s.name = :search'
            )
            ->setParameter('search', "%{$search}%");
    }
}