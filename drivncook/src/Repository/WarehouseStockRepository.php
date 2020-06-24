<?php

namespace App\Repository;

use App\Entity\WarehouseStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WarehouseStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method WarehouseStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method WarehouseStock[]    findAll()
 * @method WarehouseStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WarehouseStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WarehouseStock::class);
    }

//    public function findAllProductsInWarehouse($warehouse_id) {
//        return $this
//            ->createQueryBuilder('ws')
//            ->select('ws')
//            ->where("ws.warehouse = $warehouse_id")
//            ->getQuery()
//            ->getResult();
//
//    }
//
//    public function findNumberOfProductsInWarehouse($warehouse_id) {
//        return $this
//            ->createQueryBuilder('ws')
//            ->select('SUM(ws.quantity) as quantite')
//            ->where("ws.warehouse = $warehouse_id")
//            ->getQuery()
//            ->getResult();
//
//    }


    // /**
    //  * @return WarehouseStock[] Returns an array of WarehouseStock objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WarehouseStock
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
