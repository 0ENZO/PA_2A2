<?php

namespace App\Controller;

use App\Entity\FranchiseOrder;
use App\Entity\Franchise;
use App\Entity\Truck;
use App\Form\FranchiseType;
use App\Repository\FranchiseOrderRepository;
use App\Repository\FranchiseRepository;
use App\Repository\TruckRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/franchise") 
 */
class FranchiseController extends AbstractController
{

    /**
     * @Route("/profil", name="franchise_profil")
     */
    public function profil(Request $request){

        $em = $this->getDoctrine()->getManager();
        $franchise = $this->getUser();
        $truck = $em->getRepository(Truck::class)->findOneByFranchise($franchise);
        $orders = $em->getRepository(FranchiseOrder::class)->findByFranchise($franchise);
/*
        $order = $em->getRepository(FranchiseOrder::class)->findOneByFranchiseOrder('12');
        $products = $order->getProduct();
        foreach ($products as $product) {
            var_dump($product);
        }
*/
        $form = $this->createForm(FranchiseType::class, $franchise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('franchise_profil');
        }

        return $this->render('franchises/profil.html.twig', [
            'franchise' => $franchise,
            'truck' => $truck,
            'orders' => array_reverse($orders),
            'form' => $form->createView()
        ]);

    }

}