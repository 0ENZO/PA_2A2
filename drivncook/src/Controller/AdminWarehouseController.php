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


    // TODO : Checker les produits disponible/indisponible pour qu'un franchisé ne puisse pas commander, même si y'a du stock un produit qui serait indisponible

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
    public function admin_warehouse_show($name, Request $request, WarehouseService $warehouseService)
    {
        $manager = $this->getDoctrine()->getManager();

        $warehouse = $manager->getRepository(Warehouse::class)->findOneBy(["name" => $name]);
        $stock = $manager->getRepository(WarehouseStock::class)->findBy(["warehouse" => $warehouse]);

        $warehouseData = $warehouseService->getWarehouseCurrentCapacity($warehouse);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock->setWarehouse($warehouse);
        $add_warehouse_stock_form = $this->createForm(WarehouseStockType::class, $warehouse_stock);
        $add_warehouse_stock_form->remove("warehouse");

        $add_warehouse_stock_form->handleRequest($request);
        if ($add_warehouse_stock_form->isSubmitted() and $add_warehouse_stock_form->isValid()) {

            if ( !$warehouseService->isOverLoaded($warehouseData, $warehouse_stock) ) {
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
    public function admin_warehouse_stock_edit($name, $id, Request $request, WarehouseService $warehouseService)
    {
        $manager = $this->getDoctrine()->getManager();
        $warehouse_stock = $manager->getRepository(WarehouseStock::class)->find($id);
        $warehouse = $manager->getRepository(Warehouse::class)->findOneBy(["name" => $name]);

        $form = $this->createForm(WarehouseStockType::class, $warehouse_stock);
        $form->remove("warehouse");

        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {

            $warehouseData = $warehouseService->getWarehouseCurrentCapacity($warehouse);

            if ( !$warehouseService->isOverLoaded($warehouseData, $warehouse_stock) ) {
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
