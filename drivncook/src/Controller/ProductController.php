<?php

namespace App\Controller;

use App\Entity\Product;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Entity\Warehouses;
use App\Entity\FranchiseOrders;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/product") 
 */
class ProductController extends AbstractController
{

    /**
     * @Route("/", name="product_index")
     */
    public function index(ProductRepository $productRepository, PaginatorInterface $paginator, Request $request)
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
        $products = $productRepository->findSearch($data);

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            // 'pagination' => $pagination
        ]);
    
    }

}
