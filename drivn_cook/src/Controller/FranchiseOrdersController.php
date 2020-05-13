<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Warehouses;
use App\Entity\FranchiseOrders;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/franchiseOrder") 
 */
class FranchiseOrdersController extends AbstractController
{
    /**
     * @Route("/panier", name="franchise_cart_show")
     */
    public function show(SessionInterface $session, ProductsRepository $productsRepository)
    {
        $cart = $session->get('cart', []);
        $filledCart = [];

        foreach($cart as $id => $quantity){
            $filledCart[] = [
                'product' => $productsRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($filledCart as $item){
            $totalProduct = $item['product']->getPrice() * $item['quantity'];
            $total += $totalProduct;
        }
        return $this->render('franchises/orders/show.html.twig', [
            'items' => $filledCart,
            'total' => $total 
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="franchise_cart_add")
     */
    public function add($id, SessionInterface $session)
    {

        $cart = $session->get('cart', []);
        if (!empty($cart[$id])){
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('product_index');

    }

    /**
     * @Route("/panier/delete/{id}", name="franchise_cart_delete")
     */
    public function delete($id, SessionInterface $session, Request $request)
    {
        $cart = $session->get('cart', []);
        if (!empty($cart[$id])){
            unset($cart[$id]);
        }

        $request->getSession()->getFlashBag()->add('info', 'Produit supprimé');

        $session->set('cart', $cart);

        return $this->redirectToRoute("franchise_cart_show"); 
    }

    /**
     * @Route("/panier/validate", name="franchise_cart_validate")
     */
    public function validate(SessionInterface $session)
    {

    }
}