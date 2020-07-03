<?php

namespace App\Service;

use App\Entity\Warehouse;
use App\Entity\WarehouseStock;
use Doctrine\ORM\EntityManagerInterface;

class WarehouseService
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    /**
     * @param $warehouse
     * @return array
     * Description : Ratourne un tableau associatif de toutes quantités relatives à l'entrepôt passé en paramètre
     */
    public function getWarehouseCurrentCapacity(Warehouse $warehouse) : array {

        $warehouse = $this->manager->getRepository(Warehouse::class)->find($warehouse);
        $stock = $this->manager->getRepository(WarehouseStock::class)->findBy(["warehouse" => $warehouse]);

        $nb_ingredients = 0;
        $nb_drinks = 0;
        $nb_desserts = 0;
        $nb_meals = 0;
        $nb_products = 0;

        foreach ($stock as $product) {

            $category = $product->getProduct()->getSubCategory()->getCategory()->getName();
            $quantity = $product->getQuantity();

            $nb_products += $quantity;

            if ($category == "Ingrédients") {
                $nb_ingredients += $quantity;
            } elseif ($category === "Boissons") {
                $nb_drinks += $quantity;
            } elseif ($category === "Desserts") {
                $nb_desserts += $quantity;
            } elseif ($category === "Repas") {
                $nb_meals += $quantity;
            } else
                continue; // Aucune catégories trouvées
        }

        $array = [
            "nb_max_ingredients" => $warehouse->getMaxCapacity()->getMaxIngredients(),
            "nb_max_drinks" => $warehouse->getMaxCapacity()->getMaxDrinks(),
            "nb_max_desserts" => $warehouse->getMaxCapacity()->getMaxDesserts(),
            "nb_max_meals" => $warehouse->getMaxCapacity()->getMaxMeals(),
            "nb_max_products" =>
                $warehouse->getMaxCapacity()->getMaxIngredients() +
                $warehouse->getMaxCapacity()->getMaxDrinks() +
                $warehouse->getMaxCapacity()->getMaxDesserts() +
                $warehouse->getMaxCapacity()->getMaxMeals(),
            "nb_ingredients" => $nb_ingredients,
            "nb_drinks" => $nb_drinks,
            "nb_desserts" => $nb_desserts,
            "nb_meals" => $nb_meals,
            "nb_products" => $nb_products
        ];

        return $array;
    }


    /**
     * @param array $warehouseData
     * @param WarehouseStock $warehouse_stock
     * @return bool
     * Description : Vérifie qu'un produit que l'on veut ajouter / éditer ne dépasse pas la quantité actuel de l'entrepôt
     */
    public function isOverLoaded(array $warehouseData, WarehouseStock $warehouse_stock) : bool {

        $involved_category = $warehouse_stock->getProduct()->getSubCategory()->getCategory()->getName();
        $involved_quantity = $warehouse_stock->getQuantity();

        if ($involved_category === 'Ingrédients') {
            $actual_quantity = $warehouseData["nb_ingredients"];
            $max_quantity = $warehouseData["nb_max_ingredients"];
        }
        elseif ($involved_category === 'Boissons') {
            $actual_quantity = $warehouseData["nb_drinks"];
            $max_quantity = $warehouseData["nb_max_drinks"];
        }
        elseif ($involved_category === 'Desserts') {
            $actual_quantity = $warehouseData["nb_desserts"];
            $max_quantity = $warehouseData["nb_max_desserts"];
        }
        elseif ($involved_category === 'Repas') {
            $actual_quantity = $warehouseData["nb_meals"];
            $max_quantity = $warehouseData["nb_max_meals"];
        }
        else {
            return false; // Une erreur est survenue => N'est pas sensé arrivé mais prévoir un false quand même
        }

        if ($involved_quantity + $actual_quantity > $max_quantity)
            return false;
        else
            return true;
    }


}