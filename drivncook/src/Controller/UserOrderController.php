<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Entity\UserOrder;
use App\Service\CartService;
use App\Entity\UserOrderContent;
use App\Entity\Vote;
use App\Form\VoteType;
use App\Repository\MenuRepository;
use App\Repository\FranchiseRepository;
use App\Repository\FranchiseStockRepository;
use App\Repository\UserOrderRepository;
use App\Repository\VoteRepository;
use Knp\Bundle\SnappyBundle\KnpSnappyBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;

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
    public function validate(SessionInterface $session, FranchiseRepository $franchiseRepository, MenuRepository $menuRepository, FranchiseStockRepository $franchiseStockRepository)
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
                $articles = $menu->getArticle();

                for ($i=0; $i < $quantity; $i++) { 

                    // Que 1 article pour le moment, méthode à changer
                    foreach ($articles as $article){
                        // pour chaque article on recherche ses recettes
                        $recipes = $article->getRecipes();

                        // pour chaque recette on cherche le produit et la quantité 
                        // on multiplie la qté associé dans la recette par le type de mesure
                        // on soustrait au franchiseStock associé selon la qté de menu précisée
                        foreach ($recipes as $recipe){
                            $product = $recipe->getProduct();
                            $recipeQty = $recipe->getQuantity();
                            $stock = $franchiseStockRepository->findByProductAndFranchise($product, $franchise);
                            $stockQty = $stock->getQuantity();

                            $recipeType = $recipe->getType();
                            $productType = $product->getType();
                            $type = $this->checkType($productType, $recipeType);

                            $substractQty = $recipeQty * $type;

                            if ($stockQty - $substractQty < 0 ) {
                                $stock->setQuantity(0);
                            } else {
                                $stock->setQuantity($stockQty - $substractQty);
                            }
                        }
                    }
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

                $session->set('order_id', $order->getId());
            }
            return $this->redirectToRoute('payment_success');
        }
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

    /**
     * @Route("/pdf/{id}", name="user_order_pdf", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function pdf($id, \Knp\Snappy\Pdf $knpSnappy)
    {  
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(UserOrder::class)->findOneById($id);
        if ($this->getUser() == $order->getUser() || $this->isGranted('ROLE_ADMIN')){
            $knpSnappy->setOption("encoding","UTF-8");
            $filename = "mypdf";
            $html = $this->renderView('user/order/show.html.twig' , array(
                'order' => $order,
            ));
            
            return new Response(
                $knpSnappy->getOutputFromHtml($html),
                200,
                array(
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.$filename.'.pdf"'
                )
            );
        } else {
            throw new \Exception('Vous n\'êtes pas autorisé à accéder à cette ressource.');    
        }
    }
    /**
     * @Route("/avis", name="user_order_vote")
     * @isGranted("ROLE_USER")
     */
    public function vote(Request $request, Session $session, UserOrderRepository $userOrderRepository){

        $em = $this->getDoctrine()->getManager();
        $id = $session->get('order_id');
        $order = $userOrderRepository->findOneById($id);

        $vote = new Vote();
        $form = $this->createForm(VoteType::class, $vote);
        $form
            ->remove('user')
            ->remove('date')
            ->remove('franchise')
            ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $vote->setUser($this->getUser());
            $vote->setDate(new \DateTime());
            $vote->setFranchise($order->getFranchise());

            $request->getSession()->getFlashBag()->add('info', 'Avis envoyé.');
            $session->remove('order_id');
            
            $em->persist($vote);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('vote/new.html.twig', [
            'form' => $form->createView(),
            'order' => $order
        ]);
    }

    /**
     * Get both type, and return the good relationship
     *
     * @param [type] $productType
     * @param [type] $recipeType
     * @return void
     */
    private function checkType($productType, $recipeType)
    {
        if ($recipeType == 'Unit' && $productType == 'Unit'){
            $type = 1;
        } elseif ($recipeType == 'Kg') {
            if ($productType == 'Kg') {
                $type = 1;
            } elseif ($productType == 'g') {
                $type = 0.001;
            } else {
                $type = 'error';
            }
        }  elseif ($recipeType == 'g') {
            if ($productType == 'g') {
                $type = 1;
            } elseif ($productType == 'Kg') {
                $type = 1000;
            } else {
                $type = 'error';
            }
        } elseif ($recipeType == 'L') {
            if ($productType == 'L') {
                $type = 1;
            } elseif ($productType == 'cl') {
                $type = 0.01;
            } else {
                $type = 'error';
            }
        } else {
            $type = 'error';
        }

        return $type;
    }
}

