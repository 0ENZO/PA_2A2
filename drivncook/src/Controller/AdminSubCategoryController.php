<?php

namespace App\Controller;

use App\Entity\SubCategory;
use App\Form\SubCategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminSubCategoryController extends AbstractController
{

    /**
     * @Route("/sub_category", name="admin_sub_categories_show")
     */
    public function sub_category_show(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $sub_categories = $manager->getRepository(SubCategory::class)->findAll();
        $sub_category = new SubCategory();

        $form = $this->createForm(SubCategoryType::class, $sub_category);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager->persist($sub_category);
            $manager->flush();

            $this->addFlash("success", "Une nouvelle sous-catégorie a été ajoutée");
            return $this->redirectToRoute("admin_sub_categories_show");
        }

        return $this->render("admin/sub_categories.html.twig", [
            "sub_categories" => $sub_categories,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/sub_category/edit/{id}", name="admin_sub_category_edit")
     */
    public function sub_category_edit($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $sub_category = $manager->getRepository(SubCategory::class)->find($id);

        $form = $this->createForm(SubCategoryType::class, $sub_category);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager->flush();

            $this->addFlash("primary", "Une sous-catégorie a été modifiée");
            return $this->redirectToRoute("admin_sub_categories_show");
        }

        return $this->render("admin/sub_categories_edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }


    /**
     * @Route("/sub_category/delete/{id}", name="admin_sub_category_delete")
     */
    public function sub_category_delete($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $sub_category = $manager->getRepository(SubCategory::class)->find($id);

        $manager->remove($sub_category);
        $manager->flush();

        $this->addFlash("danger", "La sous-catégorie que vous avez sélectionné a été supprimée");
        return $this->redirectToRoute("admin_sub_categories_show");
    }




}
