<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Warehouses;
use App\Entity\FranchiseOrders;
use App\Repository\ProductsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/product") 
 */
class ProductsController extends AbstractController
{

    /**
     * @Route("/", name="product_index")
     */
    public function index(ProductsRepository $productsRepository, PaginatorInterface $paginator, Request $request)
    {

        $pagination = $paginator->paginate(
            $productsRepository->findAllQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('products/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

}
