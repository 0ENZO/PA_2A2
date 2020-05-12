<?php

namespace App\Repository;

use App\Entity\Trucks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trucks|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trucks|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trucks[]    findAll()
 * @method Trucks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrucksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trucks::class);
    }

    // /**
    //  * @return Trucks[] Returns an array of Trucks objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trucks
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
