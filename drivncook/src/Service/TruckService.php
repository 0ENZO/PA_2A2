<?php


namespace App\Service;


use App\Entity\Franchise;
use App\Entity\FranchiseStock;
use App\Entity\Truck;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\False_;

class TruckService
{
    private $manager;


    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    /**
     * Description: Retourne un tableau associatif des valeurs max et actuels d'un camion d'un franchisé (FranchiseStock)
     *              Attention. Doit avoir un camion, auquel cas => Donne une erreur lor de l'obtention des capacités maximales
     * @param $franchise
     * @return array
     */
    public function getFranchiseCurrentCapacity($franchise) : array {

        $truck = $this->manager->getRepository(Truck::class)->findOneBy(["franchise" => $franchise->getId()]);
        $stock = $this->manager->getRepository(FranchiseStock::class)->findBy(["franchise" => $franchise]);

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
            "nb_max_ingredients" => $truck->getMaxCapacity()->getMaxIngredients(),
            "nb_max_drinks" => $truck->getMaxCapacity()->getMaxDrinks(),
            "nb_max_desserts" => $truck->getMaxCapacity()->getMaxDesserts(),
            "nb_max_meals" => $truck->getMaxCapacity()->getMaxMeals(),
            "nb_max_products" =>
                $truck->getMaxCapacity()->getMaxIngredients() +
                $truck->getMaxCapacity()->getMaxDrinks() +
                $truck->getMaxCapacity()->getMaxDesserts() +
                $truck->getMaxCapacity()->getMaxMeals(),
            "nb_ingredients" => $nb_ingredients,
            "nb_drinks" => $nb_drinks,
            "nb_desserts" => $nb_desserts,
            "nb_meals" => $nb_meals,
            "nb_products" => $nb_products
        ];

        return $array;
    }


    /**
     * @param array $franchiseStockData // Obtenu à partir de getFranchiseCurrentCapacity
     * @param FranchiseStock $franchise_stock
     * @return bool
     * Description: Check si l'objet FranchiseStock que l'on est en train de créer/éditer ne fait pas dépasser la limite
     *              de la catégorie du camion concerné
     */
    public function isOverLoaded(array $franchiseStockData, FranchiseStock $franchise_stock) : bool {

        $involved_category = $franchise_stock->getProduct()->getSubCategory()->getCategory()->getName();
        $involved_quantity = $franchise_stock->getQuantity();

        if ($involved_category === 'Ingrédients') {
            $actual_quantity = $franchiseStockData["nb_ingredients"];
            $max_quantity = $franchiseStockData["nb_max_ingredients"];
        }
        elseif ($involved_category === 'Boissons') {
            $actual_quantity = $franchiseStockData["nb_drinks"];
            $max_quantity = $franchiseStockData["nb_max_drinks"];
        }
        elseif ($involved_category === 'Desserts') {
            $actual_quantity = $franchiseStockData["nb_desserts"];
            $max_quantity = $franchiseStockData["nb_max_desserts"];
        }
        elseif ($involved_category === 'Repas') {
            $actual_quantity = $franchiseStockData["nb_meals"];
            $max_quantity = $franchiseStockData["nb_max_meals"];
        }
        else {
            return false; // Une erreur est survenue => N'est pas sensé arrivé mais prévoir un false quand même
        }

        if ($involved_quantity + $actual_quantity > $max_quantity)
            return false;
        else
            return true;
    }

    /**
     * Description : Permet de savor, pour un franchisé donné, s'il possède un camion ou non.
     * @param $franchise
     * @return bool
     */
    public function hasTruck($franchise) : bool {
        $truck = $this->manager->getRepository(Truck::class)->findOneBy(["franchise" => $franchise]);
        if (empty($truck))
            return false;
        else
            return true;
    }



}