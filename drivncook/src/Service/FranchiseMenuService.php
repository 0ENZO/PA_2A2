<?php


namespace App\Service;


use App\Entity\Article;
use App\Entity\Franchise;
use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;

class FranchiseMenuService
{
    private $manager;

    public function __construct(EntityManagerInterface $manager) {
        $this->manager = $manager;
    }


    /**
     * @param $id
     * @return bool
     * Description: Fetch tous les menus possibles d'un franchisé.
     *              Retourne false s'il a déjà au moins un menu
     *              Retourne true s'il n'a aucun menu
     */
    public function hasEmptyMenu($id) : bool {
        $menus = $this->manager->getRepository(Menu::class)->findBy(["franchise" => $id]);
        if (!empty($menus))
            return false;
        else
            return true;
    }


    /**
     * @param $id
     * @return bool
     * Description : Cherche à savoir si un franchisé est sur le marché ou pas (isActivated == 1 ou 0)
     */
    public function isActivated($id) : bool {
        $franchise = $this->manager->getRepository(Franchise::class)->findOneBy(["id" => $id]);
        if ($franchise->getIsActivated() != 0 )
            return true;
        else
            return false;
    }


    // TODO hasCurrentBreakdown (T2 ou T3)


    /**
     * @return bool
     * Description: Permet l'établissement du menu de base d'un franchisé.
     *              Retourne true uniquement en cas de succès.
     */
    public function auto_filling($id) : bool {

        // TODO : Ça marche. Mais sélectionne automatiquement tous les articles en bdd, pour un en faire leur propre menu (donc menu identique à article pour tous les articles)

        $franchise = $this->manager->getRepository(Franchise::class)->findOneBy(["id" => $id]);
        $a_repo = $this->manager->getRepository(Article::class);
        $articles = $a_repo->findAll();
        $avaiblable = "Disponible";


        foreach ($articles as $article) {
            $menu = new Menu();
            $menu
                ->setFranchise($franchise)
                ->addArticle($article)
                ->setName($article->getName())
                ->setSubCategory($article->getSubCategory())
                ->setPrice($article->getPrice())
                ->setVat($menu->getPrice() * 0.20)
                ->setDescription($article->getDescription())
                ->setStatus($avaiblable)
                ->setIsLocked(1);

            $this->manager->persist($menu);
        }

        $franchise->setIsActivated(1);

        $this->manager->flush();

        return true;
    }


    /**
     * @param $id
     * @return bool
     * Description: Permet de supprimer tous les menu d'un franchisé. Son activité est elle aussi suspendu. C'est une remise à 0.
     *              Retourne true en cas de succès.
     */
    public function delete_menu($id) : bool {

        $franchise = $this->manager->getRepository(Franchise::class)->findOneBy(["id" => $id]);
        $menus = $this->manager->getRepository(Menu::class)->findBy(["franchise" => $id]);

        foreach ($menus as $menu) {
            $this->manager->remove($menu);
        }
        $franchise->setIsActivated(0);
        $this->manager->flush();

        return true;
    }


}