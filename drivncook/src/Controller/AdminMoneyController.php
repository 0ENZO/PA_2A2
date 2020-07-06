<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Entity\FranchiseOrder;
use App\Entity\FranchiseOrderContent;
use App\Entity\UserOrder;
use App\Entity\UserOrderContent;
use App\Service\IdentificationService;
use App\Service\MoneyService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminMoneyController extends AbstractController
{

    /**
     * @Route("/donnees-monetaires", name="admin_money_show")
     */
    public function admin_money_show(EntityManagerInterface $manager, MoneyService $moneyService)
    {
        return $this->render("admin/money.html.twig", [
            "franchiseOrders" => $manager->getRepository(FranchiseOrder::class)->findAll(),
            "franchises" => $manager->getRepository(Franchise::class)->findAll(),
            "userOrders" => $manager->getRepository(UserOrder::class)->findAll(),
            "moneyData" => $moneyService->getMoneyData(),
        ]);
    }

    /**
     * @Route("/commande-franchise/{franchiseOrderId}", name="admin_franchise_order_content")
     */
    public function admin_franchise_order_show($franchiseOrderId, EntityManagerInterface $manager)
    {

        $franchiseOrderContent = $manager->getRepository(FranchiseOrderContent::class)->findBy(["franchiseOrder" => $franchiseOrderId]);

        return $this->render("admin/franchise_order_content.html.twig", [
            "franchiseOrderContent" => $franchiseOrderContent
        ]);

    }

    /**
     * @Route("/commande-client/{userOrderId}", name="admin_user_order_content")
     */
    public function admin_user_order_show($userOrderId, EntityManagerInterface $manager)
    {

        $userOrderContent = $manager->getRepository(UserOrderContent::class)->findBy(["userOrder" => $userOrderId]);

        return $this->render("admin/user_order_content.html.twig", [
            "userOrderContent" => $userOrderContent
        ]);

    }

}
