<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminFidelityController extends AbstractController
{
    /**
     * @Route("/fidelite", name="admin_fidelity_show")
     */
    public function admin_fidelity_show(EntityManagerInterface $manager)
    {
        $articles = $manager->getRepository(Article::class)->findAll();
        return $this->render("admin/fidelity/index.html.twig", [
            "articles" => $articles
        ]);
    }


    /**
     * @Route("/fidelite/edit/{id}", name="admin_fidelity_edit")
     */
    public function admin_fidelity_edit($id, EntityManagerInterface $manager, Request $request) {
        $article = $manager->getRepository(Article::class)->findOneBy(["id" => $id]);
        $form = $this->createForm(ArticleType::class, $article);

        $form
            ->remove('name')
            ->remove('description')
            ->remove('imageFile')
            ->remove('price')
            ->remove('vat')
            ->remove('subCategory')
            ->remove('recipes')
            ->remove('status');


        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager->flush();
            $this->addFlash("info", "Un article fidélité à été mis à jour");
            return $this->redirectToRoute('admin_fidelity_show');

        }

        return $this->render("admin/fidelity/fidelity_edit.html.twig", [
            "form" => $form->createView()
        ]);


    }
}
