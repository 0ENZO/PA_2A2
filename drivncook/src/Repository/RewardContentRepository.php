<?php

namespace App\Repository;

use App\Entity\RewardContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RewardContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method RewardContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method RewardContent[]    findAll()
 * @method RewardContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RewardContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RewardContent::class);
    }

    // /**
    //  * @return RewardContent[] Returns an array of RewardContent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RewardContent
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
