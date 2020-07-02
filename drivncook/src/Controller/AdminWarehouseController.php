<?php

namespace App\Controller;

use App\Entity\Warehouse;
use App\Entity\WarehouseStock;
use App\Form\WarehouseStockType;
use App\Form\WarehouseType;
use App\Service\WarehouseService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminWarehouseController extends AbstractController
{

    // Fonctions utiles pour les fonctions du Controller

    // TODO : Checker les produits disponible/indisponible pour qu'un franchisé ne puisse pas commander, même si y'a du stock un produit qui serait indisponible

    /**
     * @param $warehouse
     * @return array
     * Description : Ratourne un tableau associatif de toutes quantités relatives à l'entrepôt passé en paramètre
     */
    private function getWarehouseCurrentCapacity(Warehouse $warehouse) : array {

        $manager = $this->getDoctrine()->getManager();
        $warehouse = $manager->getRepository(Warehouse::class)->find($warehouse);
        $stock = $manager->getRepository(WarehouseStock::class)->findBy(["warehouse" => $warehouse]);

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
    private function isOverLoaded(array $warehouseData, WarehouseStock $warehouse_stock) : bool {

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









    // Fonctions controller

    /**
     * @Route("/warehouse", name="admin_warehouse_menu")
     */
    public function admin_warehouse_menu()
    {
        $manager = $this->getDoctrine()->getManager();
        $warehouses = $manager->getRepository(Warehouse::class)->findAll();

        return $this->render("admin/warehouses_menu.html.twig", [
            "warehouses" => $warehouses
        ]);
    }


    /**
     * @Route("/warehouse/{name}", name="admin_warehouse_show")
     */
    public function admin_warehouse_show($name, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        // Test service
        // Instanciation du service qu'on vient de créer
        $myHelloService = new WarehouseService($manager, $request);
        // Execution de la fonction sayHello, que l'on vient de mettre grace à l'objet instancié
        $hello = $myHelloService->sayHello();

        $warehouse = $manager->getRepository(Warehouse::class)->findOneBy(["name" => $name]);
        $stock = $manager->getRepository(WarehouseStock::class)->findBy(["warehouse" => $warehouse]);

        $warehouseData = $this->getWarehouseCurrentCapacity($warehouse);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock->setWarehouse($warehouse);
        $add_warehouse_stock_form = $this->createForm(WarehouseStockType::class, $warehouse_stock);
        $add_warehouse_stock_form->remove("warehouse");

        $add_warehouse_stock_form->handleRequest($request);
        if ($add_warehouse_stock_form->isSubmitted() and $add_warehouse_stock_form->isValid()) {

            if ( !$this->isOverLoaded($warehouseData, $warehouse_stock) ) {
                $this->addFlash("danger", "Impossible de rajouté plus de produits de cette catégorie : Il n'y a pas assez de place pour la quantité que vous avez entré !");
                return $this->redirectToRoute('admin_warehouse_show', ["name" => $name]);
            } else {
                $manager->persist($warehouse_stock);
                $manager->flush();
                $this->addFlash("success", "Vous avez ajouté un nouveau produit à cet entrepôt.");
                return $this->redirectToRoute("admin_warehouse_show", ["name" => $name]);
            }
        }

        return $this->render("admin/warehouse.html.twig", [
            "warehouse" => $warehouse,
            "stock" => $stock,
            "warehouseData" => $warehouseData,
            "add_warehouse_stock_form" => $add_warehouse_stock_form->createView(),
            "hello" => $hello // On passe la variable à twig pour l'afficher
        ]);
    }




    /**
     * @Route("warehouse/edit/{name}", name="admin_warehouse_edit")
     */
    public function admin_warehouse_edit($name, Request $request)
    {

        $manager = $this->getDoctrine()->getManager();
        $warehouse = $manager->getRepository(Warehouse::class)->findOneBy(["name" => $name]);

        $form = $this->createForm(WarehouseType::class, $warehouse);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager->flush();
            $this->addFlash("success", "Une ou plusieurs informations sur cet entrepôt ont été modifiées.");
            return $this->redirectToRoute("admin_warehouse_show", ["name" => $name]);
        }

        return $this->render("admin/warehouse_edit.html.twig", [
            "form" => $form->createView()
        ]);
    }


    /**
     * @Route("warehouse/{name}/stock/edit/{id}", name="admin_warehouse_stock_edit")
     */
    public function admin_warehouse_stock_edit($name, $id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $warehouse_stock = $manager->getRepository(WarehouseStock::class)->find($id);
        $warehouse = $manager->getRepository(Warehouse::class)->findOneBy(["name" => $name]);

        $form = $this->createForm(WarehouseStockType::class, $warehouse_stock);
        $form->remove("warehouse");

        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {

            $warehouseData = $this->getWarehouseCurrentCapacity($warehouse);

            if ( !$this->isOverLoaded($warehouseData, $warehouse_stock) ) {
                $this->addFlash("danger", "Impossible de modifier ce produit : Il n'y a pas assez de place pour la quantité du produit que vous avez entré !");
                return $this->redirectToRoute("admin_warehouse_show", ["name" => $name]);
            } else {
                $manager->flush();
                $this->addFlash("primary", "Vous avez mis à jour un produit dans cet entrepôt.");
                return $this->redirectToRoute("admin_warehouse_show", ["name" => $name]);
            }
        }

        return $this->render("admin/warehouse_stock_edit.html.twig", [
            "form" => $form->createView()
        ]);

    }


    /**
     * @Route("warehouse/{name}/stock/delete/{id}", name="admin_warehouse_stock_delete")
     */
    public function admin_warehouse_stock_delete($name, $id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $warehouse_stock = $manager->getRepository(WarehouseStock::class)->find($id);

        $manager->remove($warehouse_stock);
        $manager->flush();

        $this->addFlash("danger", "Vous avez supprimer un produit de cet entrepôts.");
        return $this->redirectToRoute("admin_warehouse_show", ["name" => $name]);
    }



}
