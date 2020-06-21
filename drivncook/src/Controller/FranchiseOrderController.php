<?php

namespace App\Controller;

use Faker;
use App\Entity\Product;
use App\Entity\Warehouse;
use App\Entity\FranchiseOrder;
use App\Entity\FranchiseOrderContent;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\FranchiseOrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/franchiseOrder") 
 */
class FranchiseOrderController extends AbstractController
{

    /**
     * @Route("/panier", name="franchise_cart_show")
     */
    public function index(SessionInterface $session, ProductRepository $productRepository)
    {
        $cart = $session->get('cart', []);
        $filledCart = [];

        foreach($cart as $id => $quantity){
            $filledCart[] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($filledCart as $item){
            $totalProduct = $item['product']->getPrice() * $item['quantity'];
            $total += $totalProduct;
        }

        $session->set('cart_total', $total);

        return $this->render('franchise/order/index.html.twig', [
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
    public function validate(SessionInterface $session, ProductRepository $productRepository)
    {
        $cart = $session->get('cart', []);
        $em = $this->getDoctrine()->getManager();
        $total = $session->get('cart_total');
        $user = $this->getUser();

        if (!empty($cart)){

            $warehouse = $em->getRepository(Warehouse::class)->findOneByName('Alpha');

            $order = new FranchiseOrder();
            $order->setFranchise($user);
            $order->setWarehouse($warehouse);
            $order->setDate(new \DateTime());
            $order->setStatus(1);
            $order->setTotalPrice($total);
            
            foreach ($cart as $id => $quantity){
                $product = $productRepository->find($id);
                $content = new FranchiseOrderContent();
                $content->setFranchiseOrder($order);
                $content->setProduct($product);
                for ($i=0; $i < $quantity; $i++) { 
                    //$order->addProduct($product);
                    $currentQuantity = $content->getQuantity();
                    $content->setQuantity($currentQuantity+1);
                }
                $em->persist($content);
            }

            $em->persist($order);
            $em->flush();

            // trouver une autre méthode pour vider le panier de la session
            $session->invalidate();
        } else {
            throw $this->createNotFoundException('Votre panier est vide.');
        }

        return $this->render('franchise/order/validate.html.twig');
    }

    /**
     * @Route("/fav/{id}", name="franchise_fav_order")
     */
    public function fav($id, FranchiseOrderRepository $franchiseOrderRepository, EntityManagerInterface $em, Request $request){

        $order = $franchiseOrderRepository->find($id);
        $order->setStatus($order->getStatus()+1);
        $em->persist($order);
        $em->flush();

        $request->getSession()->getFlashBag()->add('info', 'Commande type ajoutéee.');
        return $this->redirectToRoute('franchise_profil');
    }


    /**
     * @Route("/unfav/{id}", name="franchise_unfav_order")
     */
    public function unfav($id, FranchiseOrderRepository $franchiseOrderRepository, EntityManagerInterface $em){

        $order = $franchiseOrderRepository->find($id);
        $order->setStatus('1');
        $em->persist($order);
        $em->flush();

        $request->getSession()->getFlashBag()->add('info', 'Commande type supprimée.');
        return $this->redirectToRoute('franchise_profil');
    }

    /**
     * @Route("/duplicate/{id}", name="franchise_duplicate_order")
     */
    public function duplicate($id, Request $request, FranchiseOrderRepository $franchiseOrderRepository, EntityManagerInterface $em){

        $order = $franchiseOrderRepository->find($id);

        $newOrder = new FranchiseOrder();
        
        $newOrder->setFranchise($this->getUser());
        $newOrder->setWarehouse($order->getWarehouse());
        $newOrder->setDate(new \DateTime());
        $newOrder->setStatus(1);
        $newOrder->setTotalPrice($order->getTotalPrice());

        $product = $order->getProduct();
        foreach ($product as $product) {
            $newOrder->addProduct($product);
        }

        $em->persist($newOrder);
        $em->flush();

        $request->getSession()->getFlashBag()->add('info', 'Commande passée.');
        return $this->redirectToRoute('franchise_profil');
    }

    

    /**
     * @Route("/{id}", name="franchise_order_show")
     */
    public function show($id){

        //Vérif si cette commande appartient bien au franchisé connecté sinon exception 
        
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(FranchiseOrder::class)->findOneById($id);

        if ($this->getUser() == $order->getFranchise()) {
            return $this->render('franchise/order/show.html.twig', [
                'order' => $order
            ]);
        } else {
            throw new \Exception('Vous n\'êtes pas autorisé à accéder à  cette commande');    
        }
    }

    /**
     * @Route("/pdf/{id}", name="franchise_order_pdf", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function pdf($id, \Knp\Snappy\Pdf $knpSnappy)
    {  

        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(FranchiseOrder::class)->findOneById($id);
        
        $knpSnappy->setOption("encoding","UTF-8");
        $filename = "mypdf";
        $html = $this->renderView('franchise/order/show.html.twig' , array(
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
    }
}