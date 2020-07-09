<?php

namespace App\Controller;

use App\Entity\CreditCard;
use App\Entity\FranchiseOrder;
use App\Entity\Franchise;
use App\Entity\Notify;
use App\Entity\Truck;
use App\Entity\UserOrder;
use App\Entity\Vote;
use App\Form\FranchiseType;
use App\Repository\FranchiseOrderRepository;
use App\Repository\FranchiseRepository;
use App\Repository\TruckRepository;

use App\Service\MoneyService;
use App\Service\NotifyService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/franchise")
 * @IsGranted("ROLE_FRANCHISE")
 */
class FranchiseController extends AbstractController
{

    /**
     * @Route("/profil", name="franchise_profil")
     */
    public function profil(Request $request, MoneyService $moneyService, NotifyService $notifyService){

        $em = $this->getDoctrine()->getManager();
        $franchise = $this->getUser();
        $truck = $em->getRepository(Truck::class)->findOneByFranchise($franchise);
        $orders = $em->getRepository(FranchiseOrder::class)->findByFranchise($franchise);
        $credit_cards = $em->getRepository(CreditCard::class)->findBy(["franchise" => $franchise]);

        $franchiseOrders = $em->getRepository(FranchiseOrder::class)->findBy(["franchise" => $franchise]);
        $userOrders = $em->getRepository(UserOrder::class)->findBy(["franchise" => $franchise]);

        $rates = $em->getRepository(Vote::class)->findBy(["franchise" => $franchise]);

        $notices = $em->getRepository(Notify::class)->findBy(["franchise" => $franchise]);

        $form = $this->createForm(FranchiseType::class, $franchise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('franchise_profil');
        }

        return $this->render('franchise/profil.html.twig', [
            'franchise' => $franchise,
            'truck' => $truck,
            'orders' => array_reverse($orders),
            'form' => $form->createView(),
            "credit_cards" => $credit_cards,
            "franchiseOrders" => $franchiseOrders,
            "userOrders" => $userOrders,
            "FranchiseMoneyData" => $moneyService->getFranchiseSalesRevenu($franchiseOrders, $userOrders),
            "rates" => $rates,
            "notices" => $notices
        ]);

    }

}
