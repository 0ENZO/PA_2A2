<?php

namespace App\Controller;

use App\Entity\Franchise;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/une-petite-faim")
 */
class HungryController extends AbstractController
{
    /**
     * @Route("/", name="hungry_menu")
     */
    public function hungry_menu()
    {
        /*
         * TODO : Faire une fonction qui check tout ce qui pourrait empêcher un franchisé de vendre ses articles
         * - Checker si son camion est indisponible à cause d'une panne, est en révision etc
         * - S'il a été désactivé par l'administrateur pour une raison diverses.
         */

        /*
         * TODO : Faire une fonction pour checker si un des menu peu apparaître à la vente, et ce, pour tous les menus
         * - Si un article est retiré de la vente par drivncook
         * - Si un franchisé ne contient pas les produits requis dans son FranchiseStock
         * - A rajouter si besoin
         */



        $manager = $this->getDoctrine()->getManager();
        $franchises = $manager->getRepository(Franchise::class)->findAll();


        return $this->render('hungry/index.html.twig', [
            'franchises' => $franchises,
        ]);
    }


    /**
     * @Route("/franchise/{id}/menu", name="menu_showcase")
     */
    public function menu_showcase($id, Request $request) {

        $manager = $this->getDoctrine()->getManager();
        $franchise = $manager->getRepository(Franchise::class)->findOneBy(["id" => $id]);

        // TODO Afficher le menu du franchisé

        return $this->render("hungry/menu_showcase.html.twig", [
            "franchise" => $franchise
        ]);

    }


}
