<?php

namespace App\Repository;

use App\Entity\FranchiseOrders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FranchiseOrders|null find($id, $lockMode = null, $lockVersion = null)
 * @method FranchiseOrders|null findOneBy(array $criteria, array $orderBy = null)
 * @method FranchiseOrders[]    findAll()
 * @method FranchiseOrders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FranchiseOrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FranchiseOrders::class);
    }

    // /**
    //  * @return FranchiseOrders[] Returns an array of FranchiseOrders objects
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
    public function findOneBySomeField($value): ?FranchiseOrders
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
