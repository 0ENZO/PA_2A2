<?php

namespace App\Controller;

use App\Entity\FranchiseOrders;
use App\Entity\Products;
use App\Entity\Warehouses;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/franchiseOrder") 
 */
class FranchiseOrdersController extends AbstractController
{

    /**
     * @Route("/show", name="franchise_order_show")
     */
    public function show(Request $request)
    {
        return $this->render('franchises/orders/show.html.twig');
    }
}