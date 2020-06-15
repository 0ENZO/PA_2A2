<?php

namespace App\Repository;

use App\Entity\SaleRecord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SaleRecord|null find($id, $lockMode = null, $lockVersion = null)
 * @method SaleRecord|null findOneBy(array $criteria, array $orderBy = null)
 * @method SaleRecord[]    findAll()
 * @method SaleRecord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaleRecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SaleRecord::class);
    }

    // /**
    //  * @return SaleRecord[] Returns an array of SaleRecord objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SaleRecord
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
