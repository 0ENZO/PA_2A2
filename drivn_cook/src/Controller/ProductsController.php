<?php

namespace App\Controller;

use App\Entity\FranchiseOrders;
use App\Entity\Products;
use App\Entity\Warehouses;
use App\Repository\ProductsRepository;
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
    public function index(ProductsRepository $productsRepository)
    {
        return $this->render('products/index.html.twig', [
            'products' => $productsRepository->findAll()
        ]);
    }

}
