<?php

namespace App\Controller;

use App\Entity\UserOrder;
use App\Service\NotifyService;
use App\Service\UserOrderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/notifications")
 */
class NotifyController extends AbstractController
{

    /**
     * @Route("/franchise-stock", name="notify_franchise-stock")
     */
    public function notify_franchise_stock(NotifyService $notifyService) {
        $franchise = $this->getUser();
        $notifyService->hasLowFranchiseStock($franchise);
        return $this->redirectToRoute("franchise_profil");
    }

    /**
     * @Route("/nouvelle-commande/{$idUserOrder}", name="notify_new_order")
     */
    public function notify_new_order($idUserOrder, NotifyService $notifyService, EntityManagerInterface $manager) {
        $userOrder = $manager->getRepository(UserOrder::class)->findOneBy(["id" => $idUserOrder]);
        $notifyService->hasNewOrder($$userOrder);
        return $this->redirectToRoute("payment_success");
    }

    /**
     * @Route("/commande-terminee/{idUserOrder}", name="user_order_is_ready")
     */
    public function user_order_is_ready($idUserOrder, EntityManagerInterface $manager, UserOrderService $orderService, NotifyService $notifyService) {
        $userOrder = $manager->getRepository(UserOrder::class)->findOneBy(["id" => $idUserOrder]);
        $orderService->order_finished($userOrder);
        if ($userOrder->getUser() != null)
            $notifyService->userOrderReady($userOrder);
        return $this->redirectToRoute("franchise_profil");
    }


    /**
     * @Route("/suppresion-totale", name="clear_all_notices")
     */
    public function clear_all_notices(NotifyService $notifyService) {
        $franchise = $this->getUser();
        $notifyService->clearAllNotices($franchise);
        return $this->redirectToRoute("franchise_profil");
    }


    /**
     * @Route("/suppression-unique/{id}", name="clear_notice")
     */
    public function clear_notice($id, NotifyService $notifyService) {
        $franchise = $this->getUser();
        $notifyService->clearNotice($franchise, $id);
        return $this->redirectToRoute("franchise_profil");
    }




}
