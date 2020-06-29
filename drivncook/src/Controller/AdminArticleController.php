<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Recipe;
use App\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminArticleController extends AbstractController
{

    /**
     * @Route("/articles", name="admin_article_show")
     */
    public function admin_article_show(Request $request)
    {

        $manager = $this->getDoctrine()->getManager();
        $articles = $manager->getRepository(Article::class)->findAll();

        $article = new Article();
        $recipe = new Recipe();
        $article->addRecipe($recipe);

        $form = $this->createForm(ArticleType::class, $article);
        $form->remove("vat");
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            foreach ($article->getRecipes() as $recipeToAdd) {
                $recipeToAdd->setArticle($article);
                $manager->persist($recipeToAdd);
            }

            $article->setVat($article->getPrice() * 0.20);

            $manager->persist($article);
            $manager->flush();
            $this->addFlash("success", "Vous avez ajouté un nouvel article");
            return $this->redirectToRoute("admin_article_show");
        }

        return $this->render("admin/articles/articles.html.twig", [
            "form" => $form->createView(),
            "articles" => $articles,
        ]);
    }


    /**
     * @Route("/article/edit/{id}", name="admin_article_edit")
     */
    public function admin_article_edit($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $article = $manager->getRepository(Article::class)->find($id);
        $recipes = $article->getRecipes();

        $form = $this->createForm(ArticleType::class, $article);
        $form->remove("vat");

        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {

            foreach ($recipes as $recipe) {
                $recipe->setArticle($article);
                $manager->persist($recipe);
            }

            $article->setVat($article->getPrice() * 0.20);

            $manager->persist($article);
            $manager->flush();

            $this->addFlash("primary", "Les informations concernant l'article que vous venez de sélectionner ont été modifiées.");
            return $this->redirectToRoute("admin_article_show");
        }

        return $this->render("admin/articles/articles_edit.html.twig", [
            "form" => $form->createView()
        ]);
    }


    /**
     * @Route("/article/delete/{id}", name="admin_article_delete")
     */
    public function admin_article_delete($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $article = $manager->getRepository(Article::class)->find($id);

        $manager->remove($article);
        $manager->flush();

        $this->addFlash("danger", "L'article que vous venez de sélectionner a été supprimé");
        return $this->redirectToRoute("admin_article_show");
    }



}
