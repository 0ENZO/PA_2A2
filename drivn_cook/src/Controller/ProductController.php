<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Warehouse;
use App\Entity\FranchiseOrder;
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
    public function index(ProductRepository $productsRepository, PaginatorInterface $paginator, Request $request)
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
