<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Entity\UserOrder;
use App\Entity\UserOrderContent;
use App\Repository\FranchiseRepository;
use App\Service\CartService;
use App\Repository\MenuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/client/commande") 
 * IsGranted("ROLE_USER")
 */
class UserOrderController extends AbstractController
{
    /**
     * @Route("/user/order", name="user_order")
     */
    public function index()
    {
        return $this->render('user_order/index.html.twig', [
            'controller_name' => 'UserOrderController',
        ]);
    }

    /**
     * @Route("/panier/ajout/{id}/{qty}", name="user_cart_add", requirements={"id"="\d+", "qty"="\d+"})
     */
    public function cart_add($id, $qty, SessionInterface $session, Request $request, CartService $cartService)
    {

        $cartService->cart_add($id, $qty, $session, $request);
        $franchise = $session->get('cart_franchise');

        return $this->redirectToRoute('menu_showcase', [
            'id' => $franchise,
        ]);
    }
    
    /**
     * @Route("/panier", name="user_cart_show")
     */
    public function cart_show(SessionInterface $session, MenuRepository $menuRepository)
    {
        $cart = $session->get('cart', []);
        $filledCart = [];

        foreach($cart as $id => $quantity){
            $filledCart[] = [
                'product' => $menuRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $totalVAT = 0;
        $totalHT = 0;

        foreach ($filledCart as $item){
            $vatProduct = $item['product']->getVat() * $item['quantity'];
            $priceProduct = $item['product']->getPrice() * $item['quantity'];
            $totalVAT += $vatProduct;
            $totalHT += $priceProduct;
        }

        $session->set('cart_totalTTC', $totalVAT + $totalHT);
        $session->set('cart_totalHT', $totalHT);

        return $this->render('user/order/index.html.twig', [
            'items' => $filledCart,
            'cart_franchise' => $session->get('cart_franchise')
        ]);
    }

    /**
     * @Route("/vider", name="user_cart_empty")
     */
    public function empty(SessionInterface $session, Request $request)
    {
        $session->remove('cart');
        $session->remove('cart_totalTTC');
        $session->remove('cart_franchise');

        $request->getSession()->getFlashBag()->add('info', 'Panier vidé.');
        return $this->redirectToRoute('user_cart_show');
    }

    /**
     * @Route("/panier/supprimer/{id}", name="user_cart_delete")
     */
    public function delete($id, SessionInterface $session, Request $request)
    {
        $cart = $session->get('cart', []);
        if (!empty($cart[$id])){
            unset($cart[$id]);
        }

        $request->getSession()->getFlashBag()->add('info', 'Produit supprimé');

        $session->set('cart', $cart);

        return $this->redirectToRoute("user_cart_show"); 
    }

    /**
     * @Route("/panier/validate", name="user_cart_validate")
     */
    public function validate(SessionInterface $session, FranchiseRepository $franchiseRepository, MenuRepository $menuRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $cart = $session->get('cart', []);
        $total = $session->get('cart_totalTTC');
        $cart_franchise = $session->get('cart_franchise');
        $franchise = $franchiseRepository->findOneById($cart_franchise);

        if (!empty($cart)){

            $order = new UserOrder();
            $order->setUser($user);
            $order->setFranchise($franchise);
            $order->setCompleteAddress('Adresse statique à 1 rue de la flemme, Néant 00001');
            $order->setDate(new \DateTime());
            $order->setStatus(1);
            $order->setTotalPrice($total);
            
            foreach ($cart as $id => $quantity){
                $menu = $menuRepository->find($id);

                // Ajout des produits dans la commande 
                $content = new UserOrderContent();
                $content->setUserOrder($order);
                $content->setMenu($menu);

                for ($i=0; $i < $quantity; $i++) { 
                    $contentQty = $content->getQuantity();
                    $content->setQuantity($contentQty+1);                    
                }
                $em->persist($content);
            }
            $em->persist($order);
            $em->flush();

            $session->remove('franchise');
            $session->remove('cart');
            $session->remove('cart_totalTTC');
            $session->remove('cart_totalHT');
        }
        return $this->redirectToRoute('payment_success');
    }

    /**
     * @Route("/{id}", name="user_order_show", requirements={"id"="\d+"})
     */
    public function show($id){

        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(UserOrder::class)->findOneById($id);

        if ($this->getUser() == $order->getUser()) {
            return $this->render('user/order/show.html.twig', [
                'order' => $order
            ]);
        } else {
            throw new \Exception('Vous n\'êtes pas autorisé à accéder à  cette commande');    
        }
    }
}
