<?php

namespace App\Repository;

use App\Entity\FranchiseOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FranchiseOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method FranchiseOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method FranchiseOrder[]    findAll()
 * @method FranchiseOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FranchiseOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FranchiseOrder::class);
    }

    // /**
    //  * @return FranchiseOrder[] Returns an array of FranchiseOrder objects
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
    public function findOneBySomeField($value): ?FranchiseOrder
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
