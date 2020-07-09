<?php

namespace App\Controller;

use App\Service\NotifyService;
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
     * @Route("nouvelle-commande/{$idUserOrder}", name="notify_new_order")
     */
    public function notify_new_order($idUserOrder, NotifyService $notifyService) {
        $notifyService->hasNewOrder($idUserOrder);
        return $this->redirectToRoute("payment_success");
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
