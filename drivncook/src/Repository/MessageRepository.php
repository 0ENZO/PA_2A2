<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    // /**
    //  * @return Message[] Returns an array of Message objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Message[] 
     */
    public function findPlannedMessages()
    {
        return $this->createQueryBuilder('m')
            ->where('m.plannedFor > :date')->setParameter('date',new \Datetime(date('Y-m-d')))
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Message[] 
     */
    public function findExpiredMessages()
    {
        return $this->createQueryBuilder('m')
            ->where('m.plannedFor < :date')->setParameter('date',new \Datetime(date('Y-m-d')))
            ->andWhere('m.isSent IS NULL')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Message[] 
     */
    public function isPlannedForToday()
    {
        return $this->createQueryBuilder('m')
            ->where('m.plannedFor = :date')->setParameter('date',new \Datetime(date('Y-m-d')))
            ->andWhere('m.isSent IS NULL OR m.isSent = 0')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Message[] 
     */
    public function isPlannedForTodayRequest()
    {
        return $this->createQueryBuilder('m')
            ->where('m.plannedFor = :date')->setParameter('date',new \Datetime(date('Y-m-d')))
            ->andWhere('m.isSent = 0')
            ->getQuery()
        ;
    }


}
