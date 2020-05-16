<?php

namespace App\Controller;

use Faker;
use App\Entity\Products;
use App\Entity\Warehouses;
use App\Entity\FranchiseOrders;

use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\FranchiseOrdersRepository;
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
class FranchiseOrdersController extends AbstractController
{

    /**
     * @Route("/panier", name="franchise_cart_show")
     */
    public function index(SessionInterface $session, ProductsRepository $productsRepository)
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

        $session->set('cart_total', $total);

        return $this->render('franchises/orders/index.html.twig', [
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
    public function validate(SessionInterface $session, ProductsRepository $productsRepository)
    {
        $cart = $session->get('cart', []);
        $em = $this->getDoctrine()->getManager();
        $total = $session->get('cart_total');

        if (!empty($cart)){

            $warehouse = $em->getRepository(Warehouses::class)->findOneByEmail('entrepot1@drivncook.fr');

            $order = new FranchiseOrders();
            $order->setIdFranchise($this->getUser());
            $order->setIdWarehouse($warehouse);
            $order->setDate(new \DateTime());
            $order->setStatus(1);
            $order->setTotalPrice($total);
            
            foreach ($cart as $id => $quantity){
                $product = $productsRepository->find($id);
                for ($i=0; $i < $quantity; $i++) { 
                    $order->addIdProduct($product);
                }
            }

            $em->persist($order);
            $em->flush();

            // trouver une autre méthode pour vider le panier de la session
            $session->invalidate();
        } else {
            throw $this->createNotFoundException('Votre panier est vide.');
        }

        return $this->render('franchises/orders/validate.html.twig');
    }

    /**
     * @Route("/fav/{id}", name="franchise_fav_order")
     */
    public function fav($id, FranchiseOrdersRepository $franchiseOrdersRepository, EntityManagerInterface $em){

        $order = $franchiseOrdersRepository->find($id);
        $order->setStatus($order->getStatus()+1);
        $em->persist($order);
        $em->flush();

        return $this->redirectToRoute('franchise_profil');
    }


    /**
     * @Route("/unfav/{id}", name="franchise_unfav_order")
     */
    public function unfav($id, FranchiseOrdersRepository $franchiseOrdersRepository, EntityManagerInterface $em){

        $order = $franchiseOrdersRepository->find($id);
        $order->setStatus('1');
        $em->persist($order);
        $em->flush();

        return $this->redirectToRoute('franchise_profil');
    }

    /**
     * @Route("/{id}", name="franchise_order_show")
     */
    public function show($id){

        //Vérif si cette commande appartient bien au franchisé connecté sinon exception 

        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(FranchiseOrders::class)->findOneByIdFranchiseOrder($id);

        return $this->render('franchises/orders/show.html.twig', [
            'order' => $order
        ]);
    }

    /**
     * @Route("/pdf/{id}", name="franchise_order_pdf", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function pdf($id, \Knp\Snappy\Pdf $knpSnappy)
    {  

        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(FranchiseOrders::class)->findOneByIdFranchiseOrder($id);
        
        $knpSnappy->setOption("encoding","UTF-8");
        $filename = "mypdf";
        $html = $this->renderView('franchises/orders/show.html.twig' , array(
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