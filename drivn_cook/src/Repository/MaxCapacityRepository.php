<?php

namespace App\Repository;

use App\Entity\MaxCapacity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MaxCapacity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaxCapacity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaxCapacity[]    findAll()
 * @method MaxCapacity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaxCapacityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaxCapacity::class);
    }

    // /**
    //  * @return MaxCapacity[] Returns an array of MaxCapacity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MaxCapacity
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
