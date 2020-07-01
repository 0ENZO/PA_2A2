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
     * @return bool
     * Description : Cherche à savoir si un franchisé est sur le marché ou pas (isActivated == 1 ou 0)
     */
    public function isActivated($id) : bool {
        $manager = $this->getDoctrine()->getManager();
        $franchise = $manager->getRepository(Franchise::class)->findOneBy(["id" => $id]);
        if ($franchise->getIsActivated() != 0 )
            return true;
        else
            false;
    }

    /**
     * @param $id
     * @return bool
     * Description: Fetch tous les menus possibles d'un franchisé.
     *              Retourne false s'il a déjà au moins un menu
     *              Retourne true s'il n'a aucun menu
     */
    public function hasEmptyMenu($id) : bool {
        $manager = $this->getDoctrine()->getManager();
        $menus = $manager->getRepository(Menu::class)->findBy(["franchise" => $id]);
        if (!empty($menus))
            return false;
        else
            return true;
    }

    /**
     * @return bool
     * Description: Permet l'établissement du menu de base d'un franchisé.
     *              Retourne true uniquement en cas de succès.
     */
    private function auto_filling($id) : bool {

        // TODO : Ça marche. Mais sélectionne automatiquement tous les articles en bdd, pour un en faire leur propre menu (donc menu identique à article pour tous les articles)

        $manager = $this->getDoctrine()->getManager();
        $franchise = $manager->getRepository(Franchise::class)->findOneBy(["id" => $id]);
        $a_repo = $manager->getRepository(Article::class);
        $articles = $a_repo->findAll();
        $avaiblable = "Disponible";


        foreach ($articles as $article) {
            $menu = new Menu();
            $menu
                ->setFranchise($franchise)
                ->addArticle($article)
                ->setName($article->getName())
                ->setPrice($article->getPrice())
                ->setVat($menu->getPrice() * 0.20)
                ->setDescription($article->getDescription())
                ->setStatus($avaiblable)
                ->setIsLocked(1);

            $manager->persist($menu);
        }

        $franchise->setIsActivated(1);

        $manager->flush();

        return true;
    }


    /**
     * @param $id
     * @return bool
     * Description: Permet de supprimer tous les menu d'un franchisé. Son activité est elle aussi suspendu. C'est une remise à 0.
     *              Retourne true en cas de succès.
     */
    private function delete_menu($id) : bool {

        $manager = $this->getDoctrine()->getManager();
        $franchise = $manager->getRepository(Franchise::class)->findOneBy(["id" => $id]);

        $menus = $manager->getRepository(Menu::class)->findBy(["franchise" => $id]);

        foreach ($menus as $menu) {
            $manager->remove($menu);
        }
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
    public function menu_auto_filled($id)
    {
        if (!$this->isTheRightFranchise($id)) {
            $this->addFlash("danger", "Erreur d'authentification détectée.");
            return $this->redirectToRoute("about");
        }

        // TODO vérifier s'il a un camion ou qu'il ne soit pas en panne

        if ( ($this->hasEmptyMenu($id)) == false ) {
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
    public function menu_auto_filled_process($id)
    {
        if (!$this->isTheRightFranchise($id)) {
            $this->addFlash("danger", "Erreur d'authentification détectée.");
            return $this->redirectToRoute("about");
        }

        $performed_process = false;
        $needToFill = $this->hasEmptyMenu($id);
        if ($needToFill)
            $performed_process = $this->auto_filling($id);

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
    public function menu_reset($id)
    {
        if (!$this->isTheRightFranchise($id)) {
            $this->addFlash("danger", "Erreur d'authentification détectée.");
            return $this->redirectToRoute("about");
        }

        $has_empty_menu = $this->hasEmptyMenu($id);
        $reset = false;
        if ($has_empty_menu == false) {
            $reset = $this->delete_menu($id);
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
