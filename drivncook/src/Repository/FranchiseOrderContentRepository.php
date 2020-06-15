<?php

namespace App\Repository;

use App\Entity\FranchiseOrderContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FranchiseOrderContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method FranchiseOrderContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method FranchiseOrderContent[]    findAll()
 * @method FranchiseOrderContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FranchiseOrderContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FranchiseOrderContent::class);
    }

    // /**
    //  * @return FranchiseOrderContent[] Returns an array of FranchiseOrderContent objects
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
    public function findOneBySomeField($value): ?FranchiseOrderContent
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
