<?php

namespace App\Repository;

use App\Entity\AnswerReportBreakdown;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AnswerReportBreakdown|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnswerReportBreakdown|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnswerReportBreakdown[]    findAll()
 * @method AnswerReportBreakdown[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerReportBreakdownRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnswerReportBreakdown::class);
    }

    // /**
    //  * @return AnswerReportBreakdown[] Returns an array of AnswerReportBreakdown objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AnswerReportBreakdown
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
