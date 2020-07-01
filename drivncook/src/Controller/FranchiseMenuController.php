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
        $performed_process = $this->auto_filling($id);

        if ($performed_process) {
            $this->addFlash("success", "Les menus sont auto générés et vous êtes maintenant présent parmis la liste des franchisé actuellment en activité !");
        } else {
            $this->addFlash("danger", "Une erreure est survenu. Veuillez rééssayer ultérieusement");
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

        $reset = $this->delete_menu($id);

        if ($reset) {
            $this->addFlash("success", "Tous vos menus ont été supprimés. Vous êtes maintenant hors activité.");
        } else {
            $this->addFlash("danger", "Une erreure est survenu. Veuillez rééssayer ultérieusement.");
        }

        return $this->render("franchise_menu/menu_reset.html.twig", [
            "id" => $id
        ]);

    }


}
