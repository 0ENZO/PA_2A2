<?php


namespace App\Service;


use App\Entity\MaxCapacity;
use App\Entity\Truck;
use Doctrine\ORM\EntityManagerInterface;

class MaxCapacityService
{
    private $manager;
    private $warehouseService;
    private $truckService;

    public function __construct(EntityManagerInterface $manager, WarehouseService $warehouseService, TruckService $truckService)
    {
        $this->manager = $manager;
        $this->warehouseService = $warehouseService;
        $this->truckService = $truckService;
    }


    // TODO : Fusionner les deux fonctions, car redondantes. Checker avec instance of est une solution





    /**
     * @param $warehouse
     * @param MaxCapacity $maxCapacity
     * @return bool
     * Description: Check si la MaxCapacity d'un entrepôt qu'on est en train d'éditer n'est pas inférieur pour chaque catégorie
     */
    public function checkMaxCapacityWarehouse($warehouse, MaxCapacity $maxCapacity) : bool {

        $warehouseData = $this->warehouseService->getWarehouseCurrentCapacity($warehouse);

        if
        (
            ($warehouseData["nb_ingredients"] > $maxCapacity->getMaxIngredients())
            || ($warehouseData["nb_drinks"] > $maxCapacity->getMaxDrinks())
            || ($warehouseData["nb_desserts"] > $maxCapacity->getMaxDesserts())
            || ($warehouseData["nb_meals"] > $maxCapacity->getMaxMeals())
        )
            return false;
        else
            return true;
    }




    /**
     * @param $franchise
     * @param MaxCapacity $maxCapacity
     * @return bool
     * Description: Check si la MaxCapacity d'un Truck qu'on est en train d'éditer n'est pas inférieur pour chaque catégorie

     */
    public function checkMaxCapacityTruck($franchise, MaxCapacity $maxCapacity) {

        $franchiseStockData = $this->truckService->getFranchiseCurrentCapacity($franchise);

        if
        (
            ($franchiseStockData["nb_ingredients"] > $maxCapacity->getMaxIngredients())
            || ($franchiseStockData["nb_drinks"] > $maxCapacity->getMaxDrinks())
            || ($franchiseStockData["nb_desserts"] > $maxCapacity->getMaxDesserts())
            || ($franchiseStockData["nb_meals"] > $maxCapacity->getMaxMeals())
        )
            return false;
        else
            return true;
    }


}