<?php

namespace App\Repository;

use App\Entity\Breakdown;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Breakdown|null find($id, $lockMode = null, $lockVersion = null)
 * @method Breakdown|null findOneBy(array $criteria, array $orderBy = null)
 * @method Breakdown[]    findAll()
 * @method Breakdown[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BreakdownRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Breakdown::class);
    }

    // /**
    //  * @return Breakdown[] Returns an array of Breakdown objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Breakdown
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
