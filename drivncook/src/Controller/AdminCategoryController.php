<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminCategoryController extends AbstractController
{

    /**
     * @Route("/category",name="admin_category_show")
     */
    public function category_show(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $category = new Category();
        $repo = $manager->getRepository(Category::class);

        $categories = $repo->findAll();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager->persist($category);
            $manager->flush();

            $this->addFlash("success", "Une nouvelle catégorie a été ajoutée");
            return $this->redirectToRoute("admin_category_show");
        }

        return $this->render("admin/categories.html.twig", [
            "form" => $form->createView(),
            "categories" => $categories,
        ]);
    }

    /**
     * @Route("/category/edit/{id}", name="admin_category_edit")
     */
    public function category_edit($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $category = $manager->getRepository(Category::class)->find($id);

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager->flush();

            $this->addFlash("primary", "Une catégorie a été modifiée");
            return $this->redirectToRoute("admin_category_show");
        }

        return $this->render("admin/categories_edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/category/delete/{id}", name="admin_category_delete", methods={"GET", "POST"})
     */
    public function category_delete($id)
    {

        // Configurer VichUploader sur : delete_on_remove : false, ou on aura l'erreur suivante
        // error : Expected argument of type "string", "null" given at property path "fileName".

        $manager = $this->getDoctrine()->getManager();
        $category = $manager->getRepository(Category::class)->findOneBy(["id" => $id]);
        $manager->remove($category);
        $manager->flush();

        $this->addFlash("danger", "La catégorie que vous avez sélectionné a été supprimée");
        return $this->redirectToRoute("admin_category_show");
    }


}
