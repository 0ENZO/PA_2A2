<?php

namespace App\Service;

use App\Entity\Menu;
use App\Repository\MenuRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {
    
    private $em;
    private $session;

    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    /**
     * @Route("/panier/ajout/{id}/{qty}", name="cart_add", requirements={"id"="\d+", "qty"="\d+"})
     */
    public function cart_add($id, $qty, Request $request)
    {
        if($qty > 0){

            $url = $request->headers->get('referer');
            if (strpos($url, 'fidelite') !== false) {
                $promo = $this->session->get('promo', []);
                if (!empty($promo[$id])){
                    $promo[$id] = $promo[$id] + $qty;
                } else {
                    $promo[$id] = $qty;
                }
                $menuRepository = $this->em->getRepository(Menu::class);
                $menu = $menuRepository->findOneById($id);
                $euroPoints = $this->session->get('euroPoints');
                if($euroPoints - $menu->getEuroPointsGap() >= 0 ){
                    $this->session->set('promo', $promo);
                    $this->session->set('euroPoints', $euroPoints - $menu->getEuroPointsGap());
                    $request->getSession()->getFlashBag()->add('info', 'Ajouté au panier');
                }else{
                    $request->getSession()->getFlashBag()->add('danger', 'Vous n\'avez pas assez de point.');
                }
            }else{
                $cart = $this->session->get('cart', []);
                if (!empty($cart[$id])){
                    $cart[$id] = $cart[$id] + $qty;
                } else {
                    $cart[$id] = $qty;
                }
                $this->session->set('cart', $cart);    
                $request->getSession()->getFlashBag()->add('info', 'Ajouté au panier');
            }
        } else {
            $request->getSession()->getFlashBag()->add('info', 'Merci de préciser une quantité');
        }
    }
}