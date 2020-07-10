<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Entity\Menu;
use App\Service\FranchiseMenuService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/une-petite-faim")
 */
class HungryController extends AbstractController
{
    /**
     * @Route("/", name="hungry_menu")
     */
    public function hungry_menu(FranchiseMenuService $franchiseMenuService)
    {
        /*
         * TODO : Faire une fonction qui check tout ce qui pourrait empêcher un franchisé de vendre ses articles
         * - Checker si son camion est indisponible à cause d'une panne, est en révision etc
         * - S'il a été désactivé par l'administrateur pour une raison diverses -> FAIT
         * - S'il na pas de menu -> FAIT
         */

        /*
         * TODO : Faire une fonction pour checker si un des menu peu apparaître à la vente, et ce, pour tous les menus
         * - Si un article est retiré de la vente par drivncook
         * - Si un franchisé ne contient pas les produits requis dans son FranchiseStock
         * - A rajouter si besoin
         */



        $manager = $this->getDoctrine()->getManager();
        $franchises = $manager->getRepository(Franchise::class)->findAll();

        $verifiedFranchise = [];
        foreach ($franchises as $franchise) {
            if ((!$franchiseMenuService->hasEmptyMenu($franchise->getId())) || ($franchiseMenuService->isActivated($franchise->getId())))
                array_push($verifiedFranchise, $franchise);
        }

        return $this->render('hungry/index.html.twig', [
            'franchises' => $verifiedFranchise,
        ]);
    }


    /**
     * @Route("/franchise/{id}/menu", name="menu_showcase")
     */
    public function menu_showcase($id, Session $session) {

        $session->set('cart_franchise', $id);
        $manager = $this->getDoctrine()->getManager();
        $franchise = $manager->getRepository(Franchise::class)->findOneBy(["id" => $id]);
        $menus = $manager->getRepository(Menu::class)->findBy(["franchise" => $id]);

        // TODO Afficher le menu du franchisé

        return $this->render("hungry/menu_showcase.html.twig", [
            "franchise" => $franchise,
            "menus" => $menus
        ]);

    }


}
