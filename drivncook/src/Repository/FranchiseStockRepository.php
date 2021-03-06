<?php

namespace App\Repository;

use App\Entity\FranchiseStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FranchiseStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method FranchiseStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method FranchiseStock[]    findAll()
 * @method FranchiseStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FranchiseStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FranchiseStock::class);
    }

    // /**
    //  * @return FranchiseStock[] Returns an array of FranchiseStock objects
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
    public function findOneBySomeField($value): ?FranchiseStock
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByProductAndFranchise($product, $franchise)
    {
        return $this->createQueryBuilder('f')
            ->where('f.franchise = :franchise')->setParameter('franchise',$franchise)
            ->andWhere('f.product = :product')->setParameter('product',$product)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
