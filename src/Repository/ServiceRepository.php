<?php

namespace App\Repository;

use App\Entity\Service;
use App\Entity\ServiceSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Service>
 *
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function save(Service $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Service $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllVisibleQuery(ServiceSearch $search): Query
    {
        $query = $this->createQueryBuilder('s');

        if ($search->getLigne()) {
            $query = $query
                ->andWhere('s.ligne = :ligne')
                ->setParameter('ligne', $search->getLigne());
        }

        if ($search->getDepot()) {
            $query = $query
                ->andWhere('s.depot = :depot')
                ->setParameter('depot', $search->getDepot());
        }

        if ($search->getDebut()) {
            $query = $query
                ->andWhere('s.debut >= :debut')
                ->setParameter('debut', $search->getDebut());
        }

        if ($search->getFin()) {
            $query = $query
                ->andWhere('s.fin <= :fin')
                ->setParameter('fin', $search->getFin());
        }

        return $query->getQuery();
    }

//    /**
//     * @return Service[] Returns an array of Service objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Service
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
