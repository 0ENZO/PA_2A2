<?php

namespace App\Repository;

use App\Entity\TechnicalControl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TechnicalControl|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechnicalControl|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechnicalControl[]    findAll()
 * @method TechnicalControl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnicalControlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechnicalControl::class);
    }

    // /**
    //  * @return TechnicalControl[] Returns an array of TechnicalControl objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TechnicalControl
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
