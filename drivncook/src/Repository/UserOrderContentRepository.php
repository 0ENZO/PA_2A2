<?php

namespace App\Repository;

use App\Entity\UserOrderContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserOrderContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserOrderContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserOrderContent[]    findAll()
 * @method UserOrderContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserOrderContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserOrderContent::class);
    }

    // /**
    //  * @return UserOrderContent[] Returns an array of UserOrderContent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserOrderContent
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
