<?php

namespace App\Controller;

use App\Entity\Product;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Entity\Warehouses;
use App\Entity\FranchiseOrders;
use App\Repository\ProductRepository;
use App\Repository\WarehouseRepository;
use App\Repository\WarehouseStockRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/product") 
 */
class ProductController extends AbstractController
{

    /**
     * @Route("/{id}", name="product_index",  requirements={"id"="\d+"})
     */
    public function index(ProductRepository $productRepository,  WarehouseRepository $warehouseRepository, $id, Request $request, SessionInterface $session)
    { 
        /*
        $pagination = $paginator->paginate(
            $productRepository->findAllQuery(),
            $request->query->getInt('page', 1),
            10
        );
        */

        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);

        $cart_warehouse = $session->get('cart_warehouse');
        if ($cart_warehouse && $cart_warehouse != $id){
            $cart = $session->get('cart');
            if (!empty($cart)) {
                $request->getSession()->getFlashBag()->add('danger', 'Vous devez vider votre panier actuel avant de changer de fournisseur.');
                return $this->redirectToRoute('franchise_order_warehouse');
            } else {
                $session->set('cart_warehouse', $id);
            }
        } else {
            $session->set('cart_warehouse', $id);
        } 

        $warehouse = $warehouseRepository->findOneById($id);
        $products = $productRepository->findSearch($data, $warehouse);

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'warehouse' => $warehouse,
            'form' => $form->createView()
            // 'pagination' => $pagination
        ]);
    
    }

}
