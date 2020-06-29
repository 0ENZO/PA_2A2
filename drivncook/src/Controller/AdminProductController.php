<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminProductController extends AbstractController
{

    /**
     * @Route("/product", name="admin_product_show")
     */
    public function admin_product_show(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $products = $manager->getRepository(Product::class)->findAll();
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $price = $form["price"]->getData();
            $vat = $price * 0.20;
            $product->setVat($vat);

            $manager->persist($product);
            $manager->flush();

            $this->addFlash("success", "Vous avez ajouté un nouveau produit parmis les produits disponibles");
            return $this->redirectToRoute("admin_product_show");
        }

        return $this->render("admin/products.html.twig", [
            "form" => $form->createView(),
            "products" => $products,
        ]);
    }


    /**
     * @Route("/product/edit/{id}", name="admin_product_edit")
     */
    public function admin_product_edit($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $product = $manager->getRepository(Product::class)->find($id);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $price = $form["price"]->getData();
            $vat = $price * 0.20;
            $product->setVat($vat);

            $manager->flush();

            $this->addFlash("primary", "Les informations concernant le produit que vous venez de sélectionner ont été modifiées.");
            return $this->redirectToRoute("admin_product_show");
        }

        return $this->render("admin/products_edit.html.twig", [
            "form" => $form->createView()
        ]);
    }


    /**
     * @Route("/product/delete/{id}", name="admin_product_delete")
     */
    public function admin_product_delete($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $product = $manager->getRepository(Product::class)->find($id);

        $manager->remove($product);
        $manager->flush();

        $this->addFlash("danger", "Le produit que vous venez de sélectionner a été supprimé");
        return $this->redirectToRoute("admin_product_show");
    }





}
