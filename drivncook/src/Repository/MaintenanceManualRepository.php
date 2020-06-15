<?php

namespace App\Repository;

use App\Entity\MaintenanceManual;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MaintenanceManual|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaintenanceManual|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaintenanceManual[]    findAll()
 * @method MaintenanceManual[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaintenanceManualRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaintenanceManual::class);
    }

    // /**
    //  * @return MaintenanceManual[] Returns an array of MaintenanceManual objects
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
    public function findOneBySomeField($value): ?MaintenanceManual
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
