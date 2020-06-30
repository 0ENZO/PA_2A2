<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Franchise;
use App\Entity\Menu;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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

    /**
     * @param $id
     * @param ObjectManager $manager
     * @return bool
     * Description : Cherche à savoir si un franchisé est sur le marché ou pas (isActivated == 1 ou 0)
     */
    public function isActivated($id, ObjectManager $manager) : bool {
        $franchise = $manager->getRepository(Franchise::class)->findOneBy(["id" => $id]);
        if ($franchise->getIsActivated() != 0 )
            return true;
        else
            false;
    }


    /**
     * @return bool
     * Description : Permet l'établissement du menu de base d'un franchisé
     * Retourne true uniquement en cas de succès
     */
    private function auto_filling() : bool {

        // TODO : ça fonctionne. Manque plus qu'à le rattacher à un franchisé et faire ça pour tous les articles et le mettre dans un service pour pas que ça prenne de place

        $manager = $this->getDoctrine()->getManager();
        $a_repo = $manager->getRepository(Article::class);
        $avaiblable = "Disponible";
        $unvailable = "Indisponible";

        $menu = new Menu();
        $menu
            ->addArticle($a_repo->findOneBy(["name" => "Oeufs à la coque"]))
            ->addArticle($a_repo->findOneBy(["name" => "Canette de Coca"]))
            ->setName("Oeufs à la coque avec canette de coco izy")
            ->setPrice(100.99)
            ->setVat($menu->getPrice() * 0.20)
            ->setDescription("Un oeufs à la coque avec un canette de coca à 100 balles. Du jamais vu.")
            ->setStatus($avaiblable)
            ->setIsLocked(1);

        $manager->persist($menu);
        $manager->flush();

        return true;
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
     * @Route("/{id}/auto-remplissage", name="menu_auto_filled")
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
     * @Route("/{id}/auto-remplissage/accepte", name="menu_auto_filled_process")
     */
    public function menu_auto_filled_process($id)
    {
        if (!$this->isTheRightFranchise($id)) {
            $this->addFlash("danger", "Erreur d'authentification détectée.");
            return $this->redirectToRoute("about");
        }

        // TODO : Fonction qui créer les menus automatiquement. Faire un `return true`
        $performed_process = $this->auto_filling();

        if ($performed_process) {
            $this->addFlash("success", "Les menus sont auto générés et vous êtes maintenant présent parmis la liste des franchisé actuellment en activité !");
        } else {
            $this->addFlash("danger", "Une erreure est survenu. Veuillez rééssayer ultérieusement");
        }

        return $this->render("franchise_menu/menu_auto_filled_validated.html.twig");

    }


}
