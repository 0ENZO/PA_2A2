<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {
    
    /**
     * @Route("/panier/ajout/{id}/{qty}", name="cart_add", requirements={"id"="\d+", "qty"="\d+"})
     */
    public function cart_add($id, $qty, SessionInterface $session, Request $request)
    {
        if($qty > 0){
            $cart = $session->get('cart', []);
            if (!empty($cart[$id])){
                $cart[$id] = $cart[$id] + $qty;
            } else {
                $cart[$id] = $qty;
            }
            $session->set('cart', $cart);

            $request->getSession()->getFlashBag()->add('info', 'Ajouté au panier');
        } else {
            $request->getSession()->getFlashBag()->add('info', 'Merci de préciser une quantité');
        }
    }

}