<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Entity\FranchiseOrder;
use App\Entity\FranchiseOrderContent;
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
    public function admin_money_show(EntityManagerInterface $manager, IdentificationService $identificationService, MoneyService $moneyService)
    {
        if (!$identificationService->isAdmin($this->getUser())) {
            $this->addFlash("danger", "Vous n'avez pas les droits pour vous rendre sur cette page");
            return $this->redirectToRoute("about");
        }

        $franchiseOrders = $manager->getRepository(FranchiseOrder::class)->findAll();

        // TODO : To do the same but for clientOrders....

        return $this->render("admin/money.html.twig", [
            "franchiseOrders" => $franchiseOrders,
            "moneyData" => $moneyService->getMoneyData(),
        ]);
    }

    /**
     * @Route("/commande-franchise/{franchiseOrderId}", name="admin_franchise_order_content")
     */
    public function admin_franchise_order_show($franchiseOrderId, EntityManagerInterface $manager, IdentificationService $identificationService)
    {
        if (!$identificationService->isAdmin($this->getUser())) {
            $this->addFlash("danger", "Vous n'avez pas les droits pour vous rendre sur cette page");
            return $this->redirectToRoute("about");
        }

        $franchiseOrderContent = $manager->getRepository(FranchiseOrderContent::class)->findBy(["franchiseOrder" => $franchiseOrderId]);

        return $this->render("admin/franchise_order_content.html.twig", [
            "franchiseOrderContent" => $franchiseOrderContent
        ]);

    }

}
