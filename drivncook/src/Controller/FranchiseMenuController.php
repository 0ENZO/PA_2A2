<?php

namespace App\Controller;

use App\Entity\Franchise;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

/**
 * @Route("/ma-franchise")
 */
class FranchiseMenuController extends AbstractController
{
    // Fonction utilitaires

    /**
     * @param $id
     * @return bool
     * Description : Vérifie que c'est bien le franchisé connecté qui manage son menu et pas un autre
     */
    private function isTheRightFranchise($id) : bool {
        $franchise = $this->getUser();
        if ($franchise->getId() == $id)
            return true;
        else
            return false;
    }





    // Fonctions controller

    /**
     * @Route("/{id}", name="franchise_menu")
     */
    public function index($id, Request $request)
    {
        if (!$this->isTheRightFranchise($id)) {
            $this->addFlash("danger", "Erreur d'authentification détectée.");
            return $this->redirectToRoute("about");
        }

        return $this->render('franchise_menu/index.html.twig', [
            "franchise" => $this->getUser()
        ]);
    }


    /**
     * @Route("/{id}/auto-fill", name="menu_auto_filled")
     */
    public function menu_auto_filled($id)
    {
        if (!$this->isTheRightFranchise($id)) {
            $this->addFlash("danger", "Erreur d'authentification détectée.");
            return $this->redirectToRoute("about");
        }

        // TODO Faire une fonction pour voir s'il a deja fait son auto fill -> pas besoin de la faire encore

        return $this->render("franchise_menu/menu_auto_filled.html.twig", [
            "id" => $id
        ]);

    }


    /**
     * @Route("/{id}/auto-fill/proccess", name="menu_auto_filled_process")
     */
    public function menu_auto_filled_process($id)
    {
        if (!$this->isTheRightFranchise($id)) {
            $this->addFlash("danger", "Erreur d'authentification détectée.");
            return $this->redirectToRoute("about");
        }

        // TODO : Fonction qui créer les menus automatiquement. Faire un `return true`
        $performed_process = true;

        if ($performed_process) {
            $this->addFlash("success", "Les menus sont auto générés et vous êtes maintenant présent parmis la liste des franchisé actuellment en activité !");
        } else {
            $this->addFlash("danger", "Une erreure est survenu. Veuillez rééssayer ultérieusement");
        }

        return $this->render("franchise_menu/menu_auto_filled_validated.html.twig");

    }


}
