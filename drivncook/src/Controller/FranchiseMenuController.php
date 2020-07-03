<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Franchise;
use App\Entity\Menu;
use App\Service\FranchiseMenuService;
use App\Service\IdentificationService;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ma-franchise")
 */
class FranchiseMenuController extends AbstractController
{

    /**
     * @Route("/{id}", name="franchise_menu")
     */
    public function index($id, Request $request, IdentificationService $identificationService)
    {
        if (!$identificationService->isTheRightFranchise($id)) {
            $this->addFlash("danger", "Erreur d'authentification détectée.");
            return $this->redirectToRoute("about");
        }

        $manager = $this->getDoctrine()->getManager();
        $menus = $manager->getRepository(Menu::class)->findBy(["franchise" => $id]);

        return $this->render('franchise_menu/index.html.twig', [
            "franchise" => $this->getUser(),
            "menus" => $menus
        ]);
    }


    /**
     * @Route("/{id}/auto-remplissage", name="menu_auto_filled")
     */
    public function menu_auto_filled($id, IdentificationService $identificationService, FranchiseMenuService $franchiseMenuService)
    {
        if (!$identificationService->isTheRightFranchise($id)) {
            $this->addFlash("danger", "Erreur d'authentification détectée.");
            return $this->redirectToRoute("about");
        }
        // TODO vérifier s'il a un camion ou qu'il ne soit pas en panne, ou alors qu'elle a été résolu

        if ( ($franchiseMenuService->hasEmptyMenu($id)) == false ) {
            $this->addFlash("danger", "Vous avez déjà un menu actif. Veuillez le supprimer pour en re-créer un à nouveau");
            return $this->redirectToRoute("franchise_profil");
        }

        return $this->render("franchise_menu/menu_auto_filled.html.twig", [
            "id" => $id
        ]);

    }


    /**
     * @Route("/{id}/auto-remplissage/accepte", name="menu_auto_filled_process")
     */
    public function menu_auto_filled_process($id, IdentificationService $identificationService, FranchiseMenuService $franchiseMenuService)
    {
        if (!$identificationService->isTheRightFranchise($id)) {
            $this->addFlash("danger", "Erreur d'authentification détectée.");
            return $this->redirectToRoute("about");
        }

        $performed_process = false;
        $needToFill = $franchiseMenuService->hasEmptyMenu($id);
        if ($needToFill)
            $performed_process = $franchiseMenuService->auto_filling($id);

        if ($performed_process) {
            $this->addFlash("success", "Les menus sont auto générés et vous êtes maintenant présent parmis la liste des franchisé actuellment en activité !");
        } else {
            $this->addFlash("danger", "Vous avez déjà un menu actif. Veuillez le supprimer pour en re-créer un à nouveau");
            return $this->redirectToRoute("franchise_profil");
        }

        return $this->render("franchise_menu/menu_auto_filled_validated.html.twig");

    }


    /**
     * @Route("/{id}/reinitialisation-menu", name="menu_reset")
     */
    public function menu_reset($id, IdentificationService $identificationService, FranchiseMenuService $franchiseMenuService)
    {
        if (!$identificationService->isTheRightFranchise($id)) {
            $this->addFlash("danger", "Erreur d'authentification détectée.");
            return $this->redirectToRoute("about");
        }

        $has_empty_menu = $franchiseMenuService->hasEmptyMenu($id);
        $reset = false;
        if ($has_empty_menu == false) {
            $reset = $franchiseMenuService->delete_menu($id);
        }

        if ($reset) {
            $this->addFlash("success", "Tous vos menus ont été supprimés. Vous êtes maintenant hors activité.");
        } else {
            $this->addFlash("danger", "Vous n'avez aucun menu pour le moment. Veuillez en créer un pour vous mettre en activité");
            return $this->redirectToRoute("franchise_profil");
        }

        return $this->render("franchise_menu/menu_reset.html.twig", [
            "id" => $id
        ]);

    }


}
